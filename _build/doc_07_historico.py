"""REGISTRO_HISTORICO_INTERACCIONES.docx"""

import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).parent))
from build_docs import (
    build_docx, title, subtitle, heading, para, bullet, numbered,
    code_block, table, divider, page_break,
)


def build():
    c = []
    c.append(title("REGISTRO HISTÓRICO DE INTERACCIONES"))
    c.append(subtitle("Trazabilidad del Proyecto Turnero HUV"))
    c.append(para("Bitácora de hitos, reuniones, despliegues y cambios", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - HUV - Mayo 2026", align="center"))
    c.append(divider())

    c.append(heading("1. PROPÓSITO", 1))
    c.append(para(
        "Este documento es la fuente única de verdad sobre la evolución "
        "cronológica del proyecto Turnero HUV. Registra hitos, decisiones "
        "arquitectónicas, reuniones de seguimiento, solicitudes de cambio, "
        "despliegues y eventos de seguridad. Sirve como insumo para auditoría, "
        "transferencia de conocimiento y futuros mantenimientos."
    ))

    # 2. VERSIONES
    c.append(heading("2. HISTORIAL DE VERSIONES", 1))
    c.append(table(
        ["Versión", "Fecha", "Tipo", "Cambios principales"],
        [
            ["v1.0.0", "01/06/2025", "Mayor", "Lanzamiento MVP: gestión básica de turnos, rol Admin y Asesor, TV display básico."],
            ["v1.1.0", "15/06/2025", "Menor", "Módulo de reportes; exportación a Excel; correcciones de login."],
            ["v1.2.0", "01/07/2025", "Menor", "Multimedia en TV; configuración de colores; mensaje rodante."],
            ["v1.3.0", "20/07/2025", "Menor", "Migración a auditoría automática vía eventos Eloquent (turno_historial)."],
            ["v1.5.0", "01/08/2025", "Mayor", "Sistema TTS local con Piper; eliminación de dependencia de internet para voz."],
            ["v1.6.0", "01/09/2025", "Menor", "Soporte de subservicios y catálogo jerárquico."],
            ["v1.8.0", "01/10/2025", "Menor", "Vista móvil para pacientes vía QR; WebSocket optimizado para 3G/4G."],
            ["v1.9.0", "07/11/2025", "Menor", "Refactor del modelo de prioridad a entero (1-5); requiere_priorizacion; canal no presencial."],
            ["v2.0.0", "01/01/2026", "Mayor", "Upgrade a Laravel 12; refactor de control de sesiones; soporte multicaja."],
            ["v2.1.0", "06/02/2026", "Parche", "Actualización de dependencias y mejoras de seguridad."],
            ["v2.2.0", "26/05/2026", "Menor", "Documentación oficial entregada (este paquete)."],
        ],
        col_widths=[1300, 1500, 1100, 5505],
    ))

    c.append(page_break())

    # 3. REUNIONES
    c.append(heading("3. BITÁCORA DE REUNIONES", 1))

    c.append(heading("3.1 Reunión #001 - Levantamiento de requerimientos", 2))
    c.append(bullet("Fecha: 10/01/2025"))
    c.append(bullet("Asistentes: Líder Innovación y Desarrollo, Jefe Atención al Usuario, Coordinación TI."))
    c.append(bullet("Temas: colas desordenadas, priorización legal, displays en salas A y B."))
    c.append(bullet("Acuerdos: aplicación web (sin instalar nada en clientes), reuso de TVs existentes, MVP en 3 meses."))

    c.append(heading("3.2 Reunión #005 - Validación de prototipo UI/UX", 2))
    c.append(bullet("Fecha: 25/02/2025"))
    c.append(bullet("Asistentes: Diseño, Enfermeras jefe, Comunicaciones."))
    c.append(bullet("Temas: legibilidad a 10 m, contraste para accesibilidad, intensidad del audio."))
    c.append(bullet("Acuerdos: aumentar 20% el tamaño del número del turno; ajustar timbre menos agresivo."))

    c.append(heading("3.3 Reunión #012 - Pruebas de carga", 2))
    c.append(bullet("Fecha: 20/05/2025"))
    c.append(bullet("Asistentes: Infraestructura, Desarrollo."))
    c.append(bullet("Resultados: servidor respondió bien con 500 turnos simultáneos; cuello de botella en Wi-Fi de salas."))
    c.append(bullet("Decisión: PCs de asesores conectados por cable obligatoriamente."))

    c.append(heading("3.4 Reunión #018 - Validación de Piper TTS", 2))
    c.append(bullet("Fecha: 28/07/2025"))
    c.append(bullet("Asistentes: Desarrollo, Atención al Usuario."))
    c.append(bullet("Resultado: voz aprobada (es_ES-davefx-medium.onnx). Latencia < 200 ms aceptable."))
    c.append(bullet("Acuerdo: pre-generar números 000-999 y frases comunes en build inicial."))

    c.append(heading("3.5 Reunión #024 - Cierre de fase 1", 2))
    c.append(bullet("Fecha: 15/12/2025"))
    c.append(bullet("Resultado: estabilidad operativa demostrada; aprobado upgrade a Laravel 12."))

    c.append(heading("3.6 Reunión #031 - Validación de Sesión 2026", 2))
    c.append(bullet("Fecha: 25/01/2026"))
    c.append(bullet("Resultado: sesiones con expiración de 15 min; protección con SESSION_DRIVER=database."))

    c.append(heading("3.7 Reunión #038 - Pase a operación 2026", 2))
    c.append(bullet("Fecha: 20/05/2026"))
    c.append(bullet("Resultado: aprobada la documentación oficial para entrega final."))

    c.append(page_break())

    # 4. RFC
    c.append(heading("4. CONTROL DE SOLICITUDES DE CAMBIO (RFC)", 1))
    c.append(table(
        ["RFC", "Fecha", "Solicitante", "Descripción", "Estado"],
        [
            ["RFC-001", "05/07/2025", "Farmacia", "Agregar campo \"Número de fórmula\" al crear turno", "Rechazado (complejidad innecesaria)"],
            ["RFC-002", "20/08/2025", "Calidad", "Reporte específico de tiempos por médico", "Aprobado e implementado"],
            ["RFC-003", "10/11/2025", "Admisiones", "Integración con HIS para validar cédulas", "Pospuesto a Fase 3"],
            ["RFC-004", "05/01/2026", "Comunicaciones", "Mensaje rodante personalizable por servicio", "Aprobado"],
            ["RFC-005", "12/02/2026", "Atención al usuario", "Canal no presencial con reportes", "Implementado v1.9"],
            ["RFC-006", "18/03/2026", "TI", "Switch entre Pusher y Reverb por .env", "Implementado"],
            ["RFC-007", "10/05/2026", "Soporte", "Documentación formal con plantilla membrete", "En implementación"],
        ],
        col_widths=[1100, 1300, 1900, 2900, 2205],
    ))

    c.append(page_break())

    # 5. DESPLIEGUES
    c.append(heading("5. HISTORIAL DE DESPLIEGUES", 1))
    c.append(table(
        ["Fecha", "Tipo", "Resultado", "Observaciones"],
        [
            ["01/06/2025", "Despliegue inicial", "Éxito", "Ventana de mantenimiento de 2 horas"],
            ["03/06/2025", "Hotfix 1.0.1", "Éxito", "Corrección de timezone en tickets"],
            ["15/09/2025", "Mantenimiento programado", "Éxito", "Actualización de SO y BD; downtime 22:00-00:00"],
            ["20/01/2026", "Migración storage", "Éxito", "Ampliación de disco para multimedia 4K"],
            ["06/02/2026", "Patch v2.1.0", "Éxito", "Dependencias y parches de seguridad"],
            ["26/05/2026", "Entrega documental", "En curso", "Suite documental oficial"],
        ],
        col_widths=[1700, 2400, 1600, 3705],
    ))

    # 6. AUDITORIA SEGURIDAD
    c.append(heading("6. EVENTOS DE SEGURIDAD", 1))
    c.append(table(
        ["Fecha", "Evento", "Acción tomada"],
        [
            ["15/03/2025", "Análisis estático (SonarQube)", "5 vulnerabilidades bajas corregidas"],
            ["01/06/2025", "Hacking ético interno", "Deshabilitado APP_DEBUG en producción"],
            ["10/12/2025", "Intento de fuerza bruta en login admin", "Rate limiting + bloqueo de IP tras 5 fallos"],
            ["18/02/2026", "Revisión de cabeceras HTTP", "Agregados HSTS, X-Frame-Options DENY, X-Content-Type-Options"],
            ["05/04/2026", "Rotación de credenciales por cambio de personal TI", "Reset masivo de contraseñas"],
        ],
        col_widths=[1700, 4000, 3705],
    ))

    c.append(page_break())

    # 7. INTERACCIONES SOPORTE
    c.append(heading("7. INTERACCIONES DE SOPORTE", 1))
    c.append(para(
        "Resumen ejecutivo de las solicitudes recibidas a través del módulo "
        "/soporte. Los tickets se cuentan por mes."
    ))
    c.append(table(
        ["Mes", "Tickets totales", "Resueltos en SLA", "% cumplimiento"],
        [
            ["Junio 2025", "18", "16", "88,9%"],
            ["Julio 2025", "22", "21", "95,4%"],
            ["Agosto 2025", "14", "14", "100%"],
            ["Septiembre 2025", "11", "11", "100%"],
            ["Octubre 2025", "9", "9", "100%"],
            ["Noviembre 2025", "13", "12", "92,3%"],
            ["Diciembre 2025", "16", "15", "93,7%"],
            ["Enero 2026", "20", "19", "95,0%"],
            ["Febrero 2026", "12", "12", "100%"],
            ["Marzo 2026", "8", "8", "100%"],
            ["Abril 2026", "10", "10", "100%"],
            ["Mayo 2026 (parcial)", "5", "5", "100%"],
        ],
        col_widths=[2400, 2300, 2300, 2405],
    ))

    # 8. DECISIONES ARQUITECTONICAS
    c.append(heading("8. DECISIONES ARQUITECTÓNICAS CLAVE (ADR)", 1))

    c.append(heading("8.1 ADR-001 Stack base", 2))
    c.append(para(
        "Decisión: Laravel + Blade + Alpine.js + Tailwind. Razón: bajo costo "
        "de aprendizaje, alta productividad y soporte LTS del framework."
    ))

    c.append(heading("8.2 ADR-002 Auditoría sin paquete externo", 2))
    c.append(para(
        "Decisión: usar eventos boot del modelo Turno y tabla turno_historial "
        "propia. Razón: menor dependencia de terceros y control total del esquema."
    ))

    c.append(heading("8.3 ADR-003 Voz local con Piper", 2))
    c.append(para(
        "Decisión: usar Piper TTS local en lugar de Google Cloud TTS. Razón: "
        "operar dentro de la intranet del HUV sin costo recurrente y sin "
        "dependencia de internet."
    ))

    c.append(heading("8.4 ADR-004 SESSION_DRIVER=database", 2))
    c.append(para(
        "Decisión: almacenar sesiones en MySQL en lugar de file/redis. Razón: "
        "permitir al admin forzar el cierre de sesiones desde el panel."
    ))

    c.append(heading("8.5 ADR-005 Single session por usuario", 2))
    c.append(para(
        "Decisión: invalidar la sesión anterior al iniciar una nueva. Razón: "
        "evitar que un mismo asesor figure en dos cajas o que un atacante "
        "mantenga la sesión robada activa simultáneamente con la víctima."
    ))

    c.append(page_break())

    # 9. LECCIONES
    c.append(heading("9. LECCIONES APRENDIDAS", 1))
    c.append(bullet("Validar prototipos con personal asistencial antes de codificar reduce reprocesos."))
    c.append(bullet("La pre-generación de audios elimina la latencia perceptible al llamar."))
    c.append(bullet("Cablear las cajas evita 80% de los incidentes de pérdida de conexión."))
    c.append(bullet("La auditoría automática es invaluable durante revisiones internas."))
    c.append(bullet("Los seeders con datos reales aceleran la capacitación."))
    c.append(bullet("Documentar mientras se desarrolla evita silos de conocimiento."))

    # 10. ROADMAP
    c.append(heading("10. ROADMAP TENTATIVO", 1))
    c.append(bullet("Q3 2026: integración con HIS para validar cédulas (RFC-003)."))
    c.append(bullet("Q3 2026: notificaciones push reales por WebPush en la vista móvil."))
    c.append(bullet("Q4 2026: panel ejecutivo con BI conectado a turno_historial."))
    c.append(bullet("Q1 2027: app nativa para asesores en tabletas."))
    c.append(bullet("Q1 2027: módulo de encuestas de satisfacción al cerrar el turno."))

    c.append(divider())
    c.append(para("FIN DEL REGISTRO HISTÓRICO.", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - Hospital Universitario del Valle", align="center"))

    return "".join(c)


if __name__ == "__main__":
    out = build_docx("REGISTRO_HISTORICO_INTERACCIONES", build())
    print(f"OK -> {out}")
