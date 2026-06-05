"""Estadistica.docx - métricas, KPIs y reportes del sistema."""

import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).parent))
from build_docs import (
    build_docx, title, subtitle, heading, para, bullet, numbered,
    code_block, table, divider, page_break,
)


def build():
    c = []
    c.append(title("ESTADÍSTICA Y MÉTRICAS"))
    c.append(subtitle("Indicadores operativos del Turnero HUV"))
    c.append(para("KPIs, fórmulas de cálculo y guía de interpretación", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - HUV - Mayo 2026", align="center"))
    c.append(divider())

    # 1. INTRODUCCION
    c.append(heading("1. INTRODUCCIÓN", 1))
    c.append(para(
        "Este documento describe la estructura estadística del Sistema de "
        "Gestión de Turnos del Hospital Universitario del Valle: qué se "
        "mide, cómo se calcula, dónde se consulta y cómo interpretarlo. Su "
        "propósito es habilitar a la dirección del HUV y a los líderes de "
        "área para tomar decisiones basadas en datos."
    ))
    c.append(para(
        "Todas las métricas se calculan a partir de las tablas turnos, "
        "turno_historial y canal_no_presencial_historial. El motor de "
        "consultas es MySQL y el frontend del dashboard se renderiza con "
        "Chart.js sobre Blade + Alpine."
    ))

    # 2. KPIS
    c.append(heading("2. INDICADORES PRINCIPALES (KPIs)", 1))
    c.append(table(
        ["KPI", "Definición", "Frecuencia", "Meta"],
        [
            ["Volumen diario de turnos", "Cantidad de turnos generados en el día", "Tiempo real", "Comparar vs. histórico"],
            ["Tiempo promedio de espera", "Promedio de minutos entre creación y llamado", "Tiempo real", "≤ 15 min"],
            ["Tiempo promedio de atención", "Promedio de segundos entre llamado y cierre", "Tiempo real", "Según servicio"],
            ["Tasa de atención", "% de turnos atendidos / generados", "Diario", "≥ 95%"],
            ["Tasa de aplazamiento", "% de turnos aplazados / atendidos", "Diario", "≤ 5%"],
            ["Tasa de ausentismo", "% de turnos llamados sin atender", "Diario", "≤ 8%"],
            ["Productividad por asesor", "Turnos atendidos por asesor por hora", "Diario", "Según rol"],
            ["Cumplimiento prioritarios", "% prioritarios atendidos ≤ 10 min", "Diario", "≥ 95%"],
            ["Tiempo en canal no presencial", "Minutos por asesor en callcenter/virtual", "Diario", "Según planificación"],
            ["Disponibilidad del sistema", "% del tiempo operativo", "Mensual", "≥ 99,5%"],
        ],
        col_widths=[2700, 3400, 1600, 1705],
    ))

    c.append(page_break())

    # 3. FORMULAS
    c.append(heading("3. FÓRMULAS DE CÁLCULO", 1))
    c.append(heading("3.1 Tiempo de espera", 2))
    c.append(code_block(
        "tiempo_espera = fecha_llamado - fecha_creacion\n\n"
        "SELECT AVG(TIMESTAMPDIFF(MINUTE, fecha_creacion, fecha_llamado)) AS espera_min\n"
        "FROM turnos\n"
        "WHERE DATE(fecha_creacion) = CURDATE()\n"
        "  AND estado IN ('llamado', 'atendido');"
    ))

    c.append(heading("3.2 Tiempo de atención", 2))
    c.append(para(
        "La columna duracion_atencion se calcula directamente en el modelo "
        "Turno al marcar como atendido (en segundos):"
    ))
    c.append(code_block(
        "duracion_atencion = (fecha_atencion - fecha_llamado) en segundos\n\n"
        "SELECT s.nombre, AVG(t.duracion_atencion) AS promedio_seg\n"
        "FROM turnos t\n"
        "JOIN servicios s ON s.id = t.servicio_id\n"
        "WHERE t.estado = 'atendido'\n"
        "  AND DATE(t.fecha_atencion) = CURDATE()\n"
        "GROUP BY s.id;"
    ))

    c.append(heading("3.3 Tasa de atención y aplazamiento", 2))
    c.append(code_block(
        "tasa_atencion   = atendidos / generados\n"
        "tasa_aplazo     = aplazados / atendidos\n"
        "tasa_ausentes   = (llamados_sin_atender) / llamados\n\n"
        "SELECT estado, COUNT(*)\n"
        "FROM turnos\n"
        "WHERE DATE(fecha_creacion) = CURDATE()\n"
        "GROUP BY estado;"
    ))

    c.append(heading("3.4 Productividad por asesor", 2))
    c.append(code_block(
        "SELECT u.nombre_completo,\n"
        "       COUNT(t.id) AS atendidos,\n"
        "       AVG(t.duracion_atencion) AS promedio_seg\n"
        "FROM users u\n"
        "JOIN turnos t ON t.asesor_id = u.id\n"
        "WHERE t.estado = 'atendido'\n"
        "  AND DATE(t.fecha_atencion) = CURDATE()\n"
        "GROUP BY u.id;"
    ))

    c.append(heading("3.5 Cumplimiento de prioritarios", 2))
    c.append(code_block(
        "SELECT 100.0 * SUM(CASE WHEN TIMESTAMPDIFF(MINUTE, fecha_creacion, fecha_llamado) <= 10 THEN 1 ELSE 0 END)\n"
        "      / COUNT(*) AS porcentaje\n"
        "FROM turnos\n"
        "WHERE prioridad >= 4\n"
        "  AND estado IN ('llamado', 'atendido')\n"
        "  AND DATE(fecha_creacion) = CURDATE();"
    ))

    c.append(heading("3.6 Tiempo en canal no presencial", 2))
    c.append(code_block(
        "SELECT u.nombre_completo,\n"
        "       SUM(TIMESTAMPDIFF(MINUTE, h.inicio, h.fin)) AS minutos_canal\n"
        "FROM canal_no_presencial_historial h\n"
        "JOIN users u ON u.id = h.user_id\n"
        "WHERE DATE(h.inicio) = CURDATE()\n"
        "GROUP BY u.id;"
    ))

    c.append(page_break())

    # 4. DASHBOARDS
    c.append(heading("4. PANELES DISPONIBLES", 1))

    c.append(heading("4.1 Dashboard en tiempo real (/graficos)", 2))
    c.append(bullet("Turnos por servicio (últimos 7 días)."))
    c.append(bullet("Turnos por estado (espera, llamado, atendido, aplazado)."))
    c.append(bullet("Turnos por hora del día."))
    c.append(bullet("Rendimiento por asesor (cantidad y tiempo promedio)."))
    c.append(bullet("Turnos por día (últimos 30 días)."))
    c.append(bullet("Tiempo de atención por servicio."))
    c.append(bullet("Distribución de prioridades."))
    c.append(bullet("Estadísticas generales (resumen ejecutivo del día)."))

    c.append(heading("4.2 Dashboard histórico (/api/graficos/historial/*)", 2))
    c.append(bullet("Volumen por tiempo (semana / mes / año)."))
    c.append(bullet("Distribución por servicios histórica."))
    c.append(bullet("Distribución por estados histórica."))
    c.append(bullet("Horas pico identificadas."))
    c.append(bullet("Tiempo de atención por servicio en el periodo."))
    c.append(bullet("Rendimiento de asesores en el periodo."))
    c.append(bullet("Patrones por día de la semana."))
    c.append(bullet("Eficiencia por servicio (atendidos / generados)."))

    c.append(heading("4.3 Dashboard canales no presenciales", 2))
    c.append(bullet("Tiempo total en canales no presenciales por asesor."))
    c.append(bullet("Distribución de actividades (callcenter, virtual, otra)."))
    c.append(bullet("Estadísticas agregadas comparando canal presencial vs. no presencial."))

    c.append(page_break())

    # 5. APIS GRAFICOS
    c.append(heading("5. APIS DE GRÁFICOS", 1))
    c.append(para(
        "Las APIs internas que alimentan el panel se exponen bajo /api/graficos. "
        "Son consumidas por las propias vistas vía fetch/axios."
    ))
    c.append(table(
        ["Endpoint", "Propósito"],
        [
            ["/api/graficos/turnos-por-servicio-semana", "Volumen por servicio en los últimos 7 días"],
            ["/api/graficos/turnos-por-estado", "Distribución por estado"],
            ["/api/graficos/turnos-por-hora", "Volumen por hora del día"],
            ["/api/graficos/rendimiento-asesores", "Productividad por asesor"],
            ["/api/graficos/turnos-por-dia", "Volumen por día (últimos 30)"],
            ["/api/graficos/tiempo-atencion-por-servicio", "Promedio de duración por servicio"],
            ["/api/graficos/distribucion-prioridades", "Reparto de prioridades"],
            ["/api/graficos/estadisticas-generales", "Cards resumen del día"],
            ["/api/graficos/historial/volumen-por-tiempo", "Histórico de volumen"],
            ["/api/graficos/historial/distribucion-servicios", "Histórico por servicio"],
            ["/api/graficos/historial/distribucion-estados", "Histórico por estado"],
            ["/api/graficos/historial/horas-pico", "Identifica horas con más demanda"],
            ["/api/graficos/historial/tiempo-atencion", "Histórico de tiempos de atención"],
            ["/api/graficos/historial/rendimiento-asesores", "Histórico de productividad"],
            ["/api/graficos/historial/estadisticas-generales", "Cards históricos"],
            ["/api/graficos/historial/patrones-dia-semana", "Patrones por día de la semana"],
            ["/api/graficos/historial/eficiencia-servicios", "Atendidos / generados por servicio"],
            ["/api/graficos/canales-no-presenciales/tiempo-por-asesor", "Tiempos en canal no presencial"],
            ["/api/graficos/canales-no-presenciales/distribucion", "Distribución de actividades"],
            ["/api/graficos/canales-no-presenciales/estadisticas", "Estadísticas globales"],
        ],
        col_widths=[4800, 4605],
    ))

    c.append(page_break())

    # 6. EJEMPLOS REPORTES
    c.append(heading("6. EJEMPLOS DE REPORTES", 1))

    c.append(heading("6.1 Reporte diario", 2))
    c.append(para(
        "Resumen ejecutivo del día. Se obtiene desde /reportes seleccionando "
        "el día actual."
    ))
    c.append(table(
        ["Indicador", "Valor (ejemplo)"],
        [
            ["Turnos generados", "156"],
            ["Turnos atendidos", "142"],
            ["Turnos aplazados", "8"],
            ["Turnos pendientes al cierre", "6"],
            ["Tiempo promedio de espera", "12 min"],
            ["Tiempo promedio de atención", "8,5 min"],
            ["Hora pico", "10:00 - 11:00 (37 turnos)"],
            ["Servicio más solicitado", "Citas Medicina General (89)"],
            ["Asesor con más turnos", "Karen Julieth Meneses (28)"],
        ],
        col_widths=[4500, 4905],
    ))

    c.append(heading("6.2 Reporte por asesor", 2))
    c.append(table(
        ["Asesor", "Atendidos", "Tiempo promedio", "Aplazados", "Canal no presencial"],
        [
            ["Karen Julieth Meneses", "28", "7:45", "1", "0 min"],
            ["Jorge Orlando Duarte", "25", "8:30", "0", "30 min"],
            ["Luis Cruz", "22", "9:10", "2", "15 min"],
            ["Andrea Yulieth Rojas", "21", "8:00", "1", "0 min"],
            ["Viviana Arango", "18", "9:45", "1", "0 min"],
        ],
        col_widths=[3000, 1500, 2000, 1500, 1405],
    ))

    c.append(heading("6.3 Reporte por servicio", 2))
    c.append(table(
        ["Servicio", "Generados", "Atendidos", "Tiempo promedio", "% cumplimiento"],
        [
            ["Citas Medicina General", "89", "82", "7:30", "92,1%"],
            ["Citas Especialidades", "32", "30", "9:15", "93,8%"],
            ["Copagos", "18", "18", "5:20", "100%"],
            ["Facturación", "12", "11", "11:00", "91,7%"],
            ["Programación", "5", "1", "10:00", "20% (parcial)"],
        ],
        col_widths=[3200, 1500, 1500, 1900, 1305],
    ))

    c.append(page_break())

    # 7. EXPORTACION
    c.append(heading("7. EXPORTACIÓN DE DATOS", 1))
    c.append(heading("7.1 Formatos soportados", 2))
    c.append(bullet("PDF (vía barryvdh/laravel-dompdf)."))
    c.append(bullet("Excel (.xlsx vía phpoffice/phpspreadsheet)."))
    c.append(bullet("CSV (vía exportación simple)."))

    c.append(heading("7.2 Procedimiento", 2))
    c.append(numbered("Ingresar al menú \"Reportes\" como administrador.", 1))
    c.append(numbered("Seleccionar rango de fechas y filtros.", 2))
    c.append(numbered("Pulsar \"Generar\".", 3))
    c.append(numbered("Descargar en PDF o Excel desde los botones correspondientes.", 4))

    c.append(heading("7.3 Reporte ejecutivo histórico", 2))
    c.append(para(
        "El botón \"Exportar dashboard histórico\" genera un PDF consolidado "
        "con todos los indicadores en un solo documento, ideal para comités "
        "de gerencia y auditorías externas."
    ))

    # 8. INTERPRETACION
    c.append(heading("8. GUÍA DE INTERPRETACIÓN", 1))
    c.append(table(
        ["Métrica", "Verde", "Amarillo", "Rojo"],
        [
            ["Tiempo de espera", "< 15 min", "15-25 min", "> 25 min"],
            ["Cumplimiento prioritarios", "≥ 95%", "85-94%", "< 85%"],
            ["Tasa de atención", "≥ 95%", "85-94%", "< 85%"],
            ["Asesores conectados", "≥ planificado", "1-2 menos", "> 2 menos"],
            ["Turnos en cola", "< 20 por servicio", "20-40", "> 40"],
            ["Tiempo en canal no presencial", "≤ 50% del turno", "50-70%", "> 70%"],
        ],
        col_widths=[3500, 2000, 1800, 2105],
    ))

    c.append(heading("8.1 Acciones recomendadas según semáforo", 2))
    c.append(bullet("Verde: continuar el monitoreo de rutina."))
    c.append(bullet("Amarillo: preparar plan de contingencia (personal flotante)."))
    c.append(bullet("Rojo: activar plan inmediato (más cajas, comunicar a líderes, ajustar prioridades)."))

    c.append(page_break())

    # 9. PERIODICIDAD
    c.append(heading("9. PERIODICIDAD DE ANÁLISIS", 1))
    c.append(table(
        ["Periodo", "Audiencia", "Acción"],
        [
            ["Tiempo real (cada 3-5 s)", "Asesores, líderes de sala", "Reaccionar a colas, abrir cajas"],
            ["Diario (cierre del día)", "Coordinación de área", "Validar SLA, identificar cuellos"],
            ["Semanal", "Líderes de servicio", "Ajustar planificación de la semana siguiente"],
            ["Mensual", "Gerencia operativa", "Tablero ejecutivo y rendición de cuentas"],
            ["Trimestral", "Dirección", "Toma de decisiones de capacidad instalada"],
            ["Anual", "Junta directiva", "Análisis estratégico y planeación de recursos"],
        ],
        col_widths=[2800, 3200, 3405],
    ))

    # 10. RESPONSABLES
    c.append(heading("10. RESPONSABLES DEL ANÁLISIS", 1))
    c.append(table(
        ["Responsable", "Rol", "Frecuencia"],
        [
            ["Líder de Atención al Usuario", "Operativo", "Diario"],
            ["Coordinadores de servicio", "Táctico", "Semanal"],
            ["Innovación y Desarrollo", "Tecnológico", "Mensual (calidad de datos)"],
            ["Subdirección Administrativa", "Estratégico", "Mensual / Trimestral"],
            ["Dirección General", "Gobierno", "Trimestral / Anual"],
        ],
        col_widths=[3700, 2700, 3005],
    ))

    c.append(divider())
    c.append(para("FIN DEL DOCUMENTO DE ESTADÍSTICA.", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - Hospital Universitario del Valle", align="center"))

    return "".join(c)


if __name__ == "__main__":
    out = build_docx("Estadistica", build())
    print(f"OK -> {out}")
