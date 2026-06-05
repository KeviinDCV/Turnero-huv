"""
Generador de documentos Word usando la plantilla membrete HUV.

Estrategia: usa el .docx original como base, sustituye el contenido del body en
word/document.xml manteniendo el header (membrete institucional) y footer, y
re-empaqueta cada documento.
"""

from __future__ import annotations

import os
import re
import shutil
import subprocess
import sys
import zipfile
from html import escape
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
TEMPLATE_DOCX = Path(r"C:\Users\Kechavarro\Downloads\PLANTILLA_MEMBRETE_2026.docx")
SKILLS_BASE = Path(
    r"C:\Users\Kechavarro\AppData\Roaming\Claude\local-agent-mode-sessions"
    r"\skills-plugin\cc26f3ea-c859-4cb1-a2d3-3d36d80fb0d7"
    r"\d06f7e28-ac8d-4888-b171-c5a25612a5c7\skills\docx"
)
UNPACK_SCRIPT = SKILLS_BASE / "scripts" / "office" / "unpack.py"
PACK_SCRIPT = SKILLS_BASE / "scripts" / "office" / "pack.py"

BUILD_DIR = ROOT / "_build"
OUTPUT_DIR = ROOT / "DOCUMENTACION_ENTREGA" / "_word_output"

W = 'xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"'


# ----------------------------- helpers de XML ----------------------------- #


def xml_escape(text: str) -> str:
    """Escapa texto para XML, conserva entities Unicode válidas."""
    return (
        text.replace("&", "&amp;")
        .replace("<", "&lt;")
        .replace(">", "&gt;")
        .replace("‘", "&#x2018;")
        .replace("’", "&#x2019;")
        .replace("“", "&#x201C;")
        .replace("”", "&#x201D;")
    )


def run(text: str, *, bold: bool = False, italic: bool = False, color: str | None = None,
        size: int = 20) -> str:
    """Crea un <w:r> con tipografía Arial."""
    rpr_parts = ['<w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>']
    if bold:
        rpr_parts.append("<w:b/><w:bCs/>")
    if italic:
        rpr_parts.append("<w:i/><w:iCs/>")
    if color:
        rpr_parts.append(f'<w:color w:val="{color}"/>')
    rpr_parts.append(f'<w:sz w:val="{size}"/><w:szCs w:val="{size}"/>')
    rpr = "<w:rPr>" + "".join(rpr_parts) + "</w:rPr>"
    return (
        f"<w:r>{rpr}"
        f'<w:t xml:space="preserve">{xml_escape(text)}</w:t></w:r>'
    )


def paragraph(runs: str, *, align: str | None = None, spacing_before: int = 0,
              spacing_after: int = 80) -> str:
    ppr_parts = []
    if spacing_before or spacing_after:
        ppr_parts.append(
            f'<w:spacing w:before="{spacing_before}" w:after="{spacing_after}"/>'
        )
    if align:
        ppr_parts.append(f'<w:jc w:val="{align}"/>')
    ppr = "<w:pPr>" + "".join(ppr_parts) + "</w:pPr>" if ppr_parts else ""
    return f"<w:p>{ppr}{runs}</w:p>"


def heading(text: str, level: int = 1) -> str:
    sizes = {1: 32, 2: 26, 3: 22, 4: 20}
    colors = {1: "1E40AF", 2: "1E40AF", 3: "1F4E79", 4: "1F4E79"}
    spacings_before = {1: 320, 2: 240, 3: 200, 4: 160}
    spacings_after = {1: 160, 2: 120, 3: 100, 4: 80}
    sz = sizes.get(level, 20)
    color = colors.get(level, "000000")
    r = run(text, bold=True, color=color, size=sz)
    return paragraph(
        r,
        spacing_before=spacings_before.get(level, 120),
        spacing_after=spacings_after.get(level, 80),
    )


def title(text: str) -> str:
    r = run(text, bold=True, color="1E40AF", size=40)
    return paragraph(r, align="center", spacing_before=120, spacing_after=240)


def subtitle(text: str) -> str:
    r = run(text, bold=True, color="555555", size=22)
    return paragraph(r, align="center", spacing_before=0, spacing_after=320)


def para(text: str, *, bold: bool = False, italic: bool = False, align: str | None = None) -> str:
    return paragraph(run(text, bold=bold, italic=italic), align=align, spacing_after=120)


def bullet(text: str, *, level: int = 0) -> str:
    """Item de lista con bullet renderizado con prefijo (• ó ◦) -- evita configurar
    numbering.xml complejo y siempre funciona en Word/Google Docs/LibreOffice."""
    indent_left = 360 + (level * 360)
    # Usamos tab para separar bullet del texto y un indent colgante
    ppr = (
        "<w:pPr>"
        f'<w:spacing w:before="0" w:after="60"/>'
        f'<w:ind w:left="{indent_left}" w:hanging="280"/>'
        "</w:pPr>"
    )
    bullet_char = "•" if level == 0 else "◦"
    bullet_run = (
        '<w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>'
        '<w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr>'
        f'<w:t xml:space="preserve">{bullet_char}\t</w:t></w:r>'
    )
    return f"<w:p>{ppr}{bullet_run}{run(text)}</w:p>"


def numbered(text: str, num: int) -> str:
    ppr = (
        "<w:pPr>"
        '<w:spacing w:before="0" w:after="60"/>'
        '<w:ind w:left="360" w:hanging="280"/>'
        "</w:pPr>"
    )
    num_run = (
        '<w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>'
        '<w:b/><w:bCs/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr>'
        f'<w:t xml:space="preserve">{num}.\t</w:t></w:r>'
    )
    return f"<w:p>{ppr}{num_run}{run(text)}</w:p>"


def code_block(text: str) -> str:
    """Bloque de código monoespacio con sombreado claro."""
    parts = []
    for line in text.splitlines() or [""]:
        run_xml = (
            '<w:r><w:rPr><w:rFonts w:ascii="Consolas" w:hAnsi="Consolas" w:cs="Consolas"/>'
            '<w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr>'
            f'<w:t xml:space="preserve">{xml_escape(line)}</w:t></w:r>'
        )
        ppr = (
            "<w:pPr>"
            '<w:pBdr>'
            '<w:left w:val="single" w:sz="6" w:space="4" w:color="3B82F6"/>'
            "</w:pBdr>"
            '<w:shd w:val="clear" w:color="auto" w:fill="F3F4F6"/>'
            '<w:spacing w:before="0" w:after="0"/>'
            '<w:ind w:left="240"/>'
            "</w:pPr>"
        )
        parts.append(f"<w:p>{ppr}{run_xml}</w:p>")
    # añadir un pequeño espacio después
    spacer = '<w:p><w:pPr><w:spacing w:before="0" w:after="80"/></w:pPr></w:p>'
    return "".join(parts) + spacer


def table(headers: list[str], rows: list[list[str]],
          col_widths: list[int] | None = None) -> str:
    """Crea una tabla con anchos consistentes. Usa DXA (1440 = 1 inch).

    El área útil de página de la plantilla es:
    page width 12240 - left 1701 - right 1134 = 9405 DXA aprox.
    """
    content_width = 9405
    n = len(headers)
    if col_widths is None:
        col_widths = [content_width // n] * n
        diff = content_width - sum(col_widths)
        col_widths[-1] += diff
    assert sum(col_widths) == content_width
    assert len(col_widths) == n

    border = (
        '<w:top w:val="single" w:sz="4" w:space="0" w:color="999999"/>'
        '<w:left w:val="single" w:sz="4" w:space="0" w:color="999999"/>'
        '<w:bottom w:val="single" w:sz="4" w:space="0" w:color="999999"/>'
        '<w:right w:val="single" w:sz="4" w:space="0" w:color="999999"/>'
        '<w:insideH w:val="single" w:sz="4" w:space="0" w:color="CCCCCC"/>'
        '<w:insideV w:val="single" w:sz="4" w:space="0" w:color="CCCCCC"/>'
    )
    cell_border = (
        '<w:tcBorders>'
        '<w:top w:val="single" w:sz="4" w:space="0" w:color="CCCCCC"/>'
        '<w:left w:val="single" w:sz="4" w:space="0" w:color="CCCCCC"/>'
        '<w:bottom w:val="single" w:sz="4" w:space="0" w:color="CCCCCC"/>'
        '<w:right w:val="single" w:sz="4" w:space="0" w:color="CCCCCC"/>'
        '</w:tcBorders>'
    )
    margins = (
        '<w:tcMar>'
        '<w:top w:w="60" w:type="dxa"/>'
        '<w:bottom w:w="60" w:type="dxa"/>'
        '<w:left w:w="100" w:type="dxa"/>'
        '<w:right w:w="100" w:type="dxa"/>'
        '</w:tcMar>'
    )

    def cell(text: str, *, width: int, header: bool = False) -> str:
        shading = (
            '<w:shd w:val="clear" w:color="auto" w:fill="1E40AF"/>'
            if header
            else ""
        )
        tcpr = (
            "<w:tcPr>"
            f'<w:tcW w:w="{width}" w:type="dxa"/>'
            + shading
            + cell_border
            + margins
            + "</w:tcPr>"
        )
        r = run(text, bold=header, color="FFFFFF" if header else None, size=18)
        p = (
            "<w:p>"
            '<w:pPr><w:spacing w:before="0" w:after="0"/></w:pPr>'
            f"{r}</w:p>"
        )
        return f"<w:tc>{tcpr}{p}</w:tc>"

    tbl_pr = (
        "<w:tblPr>"
        f'<w:tblW w:w="{content_width}" w:type="dxa"/>'
        '<w:tblBorders>' + border + "</w:tblBorders>"
        '<w:tblLayout w:type="fixed"/>'
        "</w:tblPr>"
    )
    tbl_grid = "<w:tblGrid>" + "".join(
        f'<w:gridCol w:w="{w}"/>' for w in col_widths
    ) + "</w:tblGrid>"

    header_row = (
        "<w:tr><w:trPr><w:tblHeader/></w:trPr>"
        + "".join(cell(h, width=col_widths[i], header=True) for i, h in enumerate(headers))
        + "</w:tr>"
    )
    body_rows = []
    for row in rows:
        cells = "".join(
            cell(str(c), width=col_widths[i]) for i, c in enumerate(row)
        )
        body_rows.append(f"<w:tr>{cells}</w:tr>")
    return (
        f"<w:tbl>{tbl_pr}{tbl_grid}{header_row}{''.join(body_rows)}</w:tbl>"
        # add spacing paragraph after table
        '<w:p><w:pPr><w:spacing w:before="0" w:after="120"/></w:pPr></w:p>'
    )


def divider() -> str:
    return paragraph(
        "",
        spacing_before=60,
        spacing_after=120,
    ).replace(
        "<w:pPr>",
        '<w:pPr><w:pBdr><w:bottom w:val="single" w:sz="6" w:space="1" w:color="1E40AF"/></w:pBdr>',
    )


def page_break() -> str:
    return (
        '<w:p><w:r><w:br w:type="page"/></w:r></w:p>'
    )


# ----------------------- empaquetado del documento ----------------------- #


SIGNATURE_BLOCK = (
    # ANEXOS y firma típica HUV - mantenemos el espíritu de la plantilla
    paragraph(run(""), spacing_before=240, spacing_after=80)
    + paragraph(run("Anexos: Documentación técnica y operativa del Sistema de Turnos HUV.", size=16))
    + paragraph(run("Copia archivo: Innovación y Desarrollo - HUV.", size=16))
    + paragraph(run("Fecha: 26 de mayo de 2026", size=16))
    + paragraph(run(""), spacing_after=60)
    + paragraph(run("Proyectó: Kevin Echavarro - Desarrollador Innovación y Desarrollo", size=16))
    + paragraph(run("Revisó: Líder de Innovación y Desarrollo - HUV", size=16))
    + paragraph(run("Aprobó: Coordinación de Innovación y Desarrollo - HUV", size=16))
)


def build_body(content_xml: str) -> str:
    """Devuelve el contenido completo del <w:body> reemplazando el original."""
    sect_pr = (
        '<w:sectPr>'
        '<w:headerReference w:type="default" r:id="rId7"/>'
        '<w:footerReference w:type="default" r:id="rId8"/>'
        '<w:pgSz w:w="12240" w:h="15840"/>'
        '<w:pgMar w:top="2774" w:right="1134" w:bottom="1700" w:left="1701" '
        'w:header="283" w:footer="1417" w:gutter="0"/>'
        '<w:cols w:space="720"/>'
        '<w:docGrid w:linePitch="326"/>'
        '</w:sectPr>'
    )
    return f"<w:body>{content_xml}{SIGNATURE_BLOCK}{sect_pr}</w:body>"


DOCUMENT_HEADER = (
    '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
    '<w:document '
    'xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" '
    'xmlns:cx="http://schemas.microsoft.com/office/drawing/2014/chartex" '
    'xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" '
    'xmlns:o="urn:schemas-microsoft-com:office:office" '
    'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" '
    'xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" '
    'xmlns:v="urn:schemas-microsoft-com:vml" '
    'xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" '
    'xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" '
    'xmlns:w10="urn:schemas-microsoft-com:office:word" '
    'xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" '
    'xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" '
    'xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" '
    'xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" '
    'xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" '
    'xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" '
    'xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" '
    'mc:Ignorable="w14 w15 wp14">'
    '<w:background w:color="FFFFFF"/>'
)


def build_docx(name: str, content_xml: str) -> Path:
    """Genera un docx a partir de la plantilla original con un body nuevo."""
    work_dir = BUILD_DIR / f"_work_{name}"
    if work_dir.exists():
        shutil.rmtree(work_dir)

    subprocess.run(
        [sys.executable, str(UNPACK_SCRIPT), str(TEMPLATE_DOCX), str(work_dir)],
        check=True,
        capture_output=True,
    )

    doc_xml_path = work_dir / "word" / "document.xml"
    new_xml = DOCUMENT_HEADER + build_body(content_xml) + "</w:document>"
    doc_xml_path.write_text(new_xml, encoding="utf-8")

    out_path = OUTPUT_DIR / f"{name}.docx"
    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)
    if out_path.exists():
        out_path.unlink()

    subprocess.run(
        [
            sys.executable,
            str(PACK_SCRIPT),
            str(work_dir),
            str(out_path),
            "--original",
            str(TEMPLATE_DOCX),
            "--validate",
            "false",
        ],
        check=True,
        capture_output=True,
    )

    shutil.rmtree(work_dir, ignore_errors=True)
    return out_path
