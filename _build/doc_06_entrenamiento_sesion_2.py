"""MATERIAL_ENTRENAMIENTO_SESION_2.docx - operación avanzada, reportes y contingencia."""

import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).parent))
from build_docs import (
    build_docx, title, subtitle, heading, para, bullet, numbered,
    code_block, table, divider, page_break,
)


def build():
    c = []
    c.append(title("MATERIAL DE ENTRENAMIENTO"))
    c.append(subtitle("Sesión 2 - Operación avanzada y contingencia"))
    c.append(para("Reportes, gráficos, canal no presencial y procedimientos de respaldo", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - HUV - Mayo 2026", align="center"))
    c.append(divider())

    c.append(heading("1. PRESENTACIÓN DE LA SESIÓN", 1))
    c.append(heading("1.1 Duración estimada", 2))
    c.append(para("3 horas (incluye pausa de 15 minutos)."))

    c.append(heading("1.2 Público objetivo", 2))
    c.append(bullet("Asesores experimentados que ya cursaron la Sesión 1."))
    c.append(bullet("Líderes de área y supervisores."))
    c.append(bullet("Administradores del sistema."))
    c.append(bullet("Personal de soporte de primer nivel."))

    c.append(heading("1.3 Objetivos pedagógicos", 2))
    c.append(numbered("Dominar las funciones avanzadas del panel del asesor.", 1))
    c.append(numbered("Operar el canal no presencial y registrar sus tiempos.", 2))
    c.append(numbered("Interpretar los gráficos del dashboard administrativo.", 3))
    c.append(numbered("Generar reportes y exportarlos en PDF/Excel.", 4))
    c.append(numbered("Ejecutar el procedimiento de respaldo manual ante caída del sistema.", 5))
    c.append(numbered("Identificar y mitigar incidentes comunes.", 6))

    c.append(page_break())

    # 2. OPERACION AVANZADA ASESOR
    c.append(heading("2. OPERACIÓN AVANZADA - ASESOR", 1))

    c.append(heading("2.1 Gestión eficiente de la cola", 2))
    c.append(bullet("Regla de oro: llamar al siguiente turno inmediatamente después de cerrar el anterior."))
    c.append(bullet("No acumular múltiples turnos en estado \"llamado\" sin atender."))
    c.append(bullet("Mantener el estado de \"disponible\" sólo cuando realmente puede atender."))
    c.append(bullet("Si necesita ausentarse, marcar \"Descanso\" o cerrar sesión."))

    c.append(heading("2.2 Re-llamada y pacientes ausentes", 2))
    c.append(numbered("Llamar al turno y esperar 20 segundos.", 1))
    c.append(numbered("Si no aparece, presionar el ícono de bocina (rellamar).", 2))
    c.append(numbered("Esperar otros 20 segundos.", 3))
    c.append(numbered("Si persiste la ausencia: aplazar o marcar como ausente según política interna.", 4))
    c.append(para(
        "Política HUV: si el paciente llega tarde y su turno ya pasó, debe "
        "tomar uno nuevo. Esto preserva la equidad de la cola.",
        italic=True,
    ))

    c.append(heading("2.3 Aplazamientos", 2))
    c.append(bullet("Usar \"Aplazar\" cuando el paciente debe completar documentación."))
    c.append(bullet("El turno regresa al final de la cola y se notifica al paciente vía la vista móvil."))
    c.append(bullet("Aplazar NO equivale a cancelar; el paciente conserva su código de turno."))

    c.append(heading("2.4 Cambio de caja", 2))
    c.append(numbered("En el menú superior seleccionar \"Cambiar caja\".", 1))
    c.append(numbered("Elegir la nueva caja disponible.", 2))
    c.append(numbered("La caja anterior queda liberada automáticamente.", 3))

    c.append(heading("2.5 Pausas y descansos", 2))
    c.append(bullet("\"Descanso\": el asesor sigue logueado pero no se le asignan turnos."))
    c.append(bullet("\"Cerrar sesión\": libera la caja y la pone disponible para otro asesor."))
    c.append(bullet("La diferencia es importante: si va al almuerzo (más de 30 min), cerrar sesión."))

    c.append(page_break())

    # 3. CANAL NO PRESENCIAL
    c.append(heading("3. CANAL NO PRESENCIAL", 1))
    c.append(para(
        "Permite registrar el tiempo que un asesor dedica a atender pacientes "
        "que no están físicamente presentes (callcenter, asistencia virtual, "
        "respuesta de correos, autorizaciones)."
    ))

    c.append(heading("3.1 Activación", 2))
    c.append(numbered("En el dashboard del asesor, pulsar \"Iniciar canal no presencial\".", 1))
    c.append(numbered("Seleccionar el tipo de actividad (callcenter, virtual, otra).", 2))
    c.append(numbered("Mientras esté activo, el asesor queda como \"No disponible\" para turnos presenciales.", 3))

    c.append(heading("3.2 Cierre", 2))
    c.append(numbered("Pulsar \"Finalizar canal no presencial\".", 1))
    c.append(numbered("El sistema registra el tiempo total y vuelve a \"Disponible\".", 2))

    c.append(heading("3.3 Reportes derivados", 2))
    c.append(bullet("Tiempo total por asesor en canal no presencial."))
    c.append(bullet("Distribución por tipo de actividad."))
    c.append(bullet("Comparativo presencial vs. no presencial."))

    c.append(page_break())

    # 4. DASHBOARD Y GRAFICOS
    c.append(heading("4. DASHBOARD Y GRÁFICOS", 1))
    c.append(heading("4.1 Métricas en tiempo real", 2))
    c.append(table(
        ["Indicador", "Significado", "Acción esperada"],
        [
            ["Turnos en cola", "Pacientes en espera por servicio", "Si > 30 en un servicio, abrir más cajas"],
            ["Tiempo promedio de espera", "Minutos desde generación hasta atención", "Si > 25 min, redistribuir personal"],
            ["Tiempo promedio de atención", "Duración real por paciente", "Si crece sostenidamente, revisar procesos"],
            ["Asesores conectados", "Funcionarios con sesión activa", "Comparar con planificación del día"],
            ["Pacientes prioritarios", "Embarazadas, adultos mayores, discapacitados", "Atender < 10 min"],
        ],
        col_widths=[2800, 3300, 3305],
    ))

    c.append(heading("4.2 Gráficos disponibles", 2))
    c.append(bullet("Turnos por servicio en la semana."))
    c.append(bullet("Turnos por estado (espera, llamado, atendido, aplazado)."))
    c.append(bullet("Turnos por hora del día."))
    c.append(bullet("Rendimiento por asesor."))
    c.append(bullet("Turnos por día (últimos 30 días)."))
    c.append(bullet("Tiempo de atención por servicio."))
    c.append(bullet("Distribución de prioridades."))

    c.append(heading("4.3 Gráficos históricos", 2))
    c.append(bullet("Volumen por tiempo (semana, mes, año)."))
    c.append(bullet("Distribución por servicios."))
    c.append(bullet("Distribución por estados."))
    c.append(bullet("Horas pico."))
    c.append(bullet("Tiempo promedio de atención."))
    c.append(bullet("Patrones por día de la semana."))
    c.append(bullet("Eficiencia por servicio."))

    c.append(heading("4.4 Interpretación con colores", 2))
    c.append(table(
        ["Color", "Significado", "Recomendación"],
        [
            ["Verde", "Operación normal", "Continuar monitoreo"],
            ["Amarillo", "Atención", "Preparar plan de contingencia"],
            ["Rojo", "Crítico", "Acción inmediata (más cajas / personal flotante)"],
        ],
        col_widths=[1800, 3300, 4305],
    ))

    c.append(page_break())

    # 5. REPORTES
    c.append(heading("5. REPORTES Y EXPORTACIONES", 1))
    c.append(heading("5.1 Tipos de reporte", 2))
    c.append(bullet("Reporte diario: resumen del día por servicio y asesor."))
    c.append(bullet("Reporte por rango: parametrizable por fechas, servicio y asesor."))
    c.append(bullet("Reporte por asesor: rendimiento individual con tiempos y cantidades."))
    c.append(bullet("Reporte histórico ejecutivo: PDF consolidado para la alta dirección."))

    c.append(heading("5.2 Generación", 2))
    c.append(numbered("Ingresar al menú \"Reportes\".", 1))
    c.append(numbered("Seleccionar rango de fechas.", 2))
    c.append(numbered("Filtrar por servicio o asesor si aplica.", 3))
    c.append(numbered("Pulsar \"Generar\" y luego \"Descargar PDF\" o \"Descargar Excel\".", 4))

    c.append(heading("5.3 Buenas prácticas", 2))
    c.append(bullet("Exportar reporte semanal cada lunes a primera hora."))
    c.append(bullet("Mantener un archivo histórico fuera del sistema (carpeta institucional)."))
    c.append(bullet("Compartir indicadores clave con líderes de área cada quincena."))

    c.append(page_break())

    # 6. CONTINGENCIA
    c.append(heading("6. PROCEDIMIENTOS DE CONTINGENCIA", 1))

    c.append(heading("6.1 Caída de red local", 2))
    c.append(numbered("Verificar conexión: probar abrir Google o un sitio interno.", 1))
    c.append(numbered("Si todo el hospital está sin red, reportar de inmediato a TI.", 2))
    c.append(numbered("Continuar atención con respaldo manual (tickets numerados en papel).", 3))
    c.append(numbered("Al volver el servicio, registrar los pacientes atendidos en el sistema usando \"Llamar turno específico\".", 4))

    c.append(heading("6.2 Caída del servidor", 2))
    c.append(numbered("Validar primero que sea caída del servidor y no de la red local.", 1))
    c.append(numbered("Notificar a TI con: hora del incidente, URL afectada y captura del error.", 2))
    c.append(numbered("Activar protocolo manual mientras se restablece.", 3))
    c.append(numbered("Al volver, refrescar las pantallas (F5) en TV y atril.", 4))

    c.append(heading("6.3 Falla del audio", 2))
    c.append(bullet("Verificar volumen del TV / amplificador."))
    c.append(bullet("Hacer un clic en la pantalla TV para autorizar autoplay del navegador."))
    c.append(bullet("Si no se resuelve, revisar /voice/status como administrador."))
    c.append(bullet("En último recurso, llamar verbalmente a los pacientes con su código."))

    c.append(heading("6.4 Atril fuera de servicio", 2))
    c.append(numbered("Verificar encendido del mini-PC y cables.", 1))
    c.append(numbered("Reiniciar el mini-PC si está congelado.", 2))
    c.append(numbered("Mientras se restaura, la recepción puede generar turnos desde un PC alterno conectado al sistema.", 3))

    c.append(heading("6.5 Sesión bloqueada por otro usuario", 2))
    c.append(bullet("Solicitar al administrador limpiar la sesión vía /admin/clean-user-session."))
    c.append(bullet("Volver a iniciar sesión y reseleccionar caja."))

    c.append(page_break())

    # 7. INCIDENTES COMUNES
    c.append(heading("7. INCIDENTES COMUNES (NIVEL 1)", 1))
    c.append(table(
        ["Síntoma", "Diagnóstico rápido", "Acción"],
        [
            ["TV muestra turno antiguo", "WebSocket caído", "Refrescar (F5)"],
            ["No suena audio", "Autoplay bloqueado", "Clic en pantalla TV"],
            ["Error 419", "Token CSRF expirado", "Refrescar la página"],
            ["No puedo iniciar sesión", "Credenciales o sesión bloqueada", "Pedir reset a admin"],
            ["Impresora no imprime", "Sin papel o fuera de línea", "Cambiar rollo / encender"],
            ["No veo turnos en cola", "No tengo el servicio asignado", "Validar asignación"],
        ],
        col_widths=[2800, 3000, 3605],
    ))

    # 8. ESCENARIOS DE PRACTICA
    c.append(heading("8. ESCENARIOS DE PRÁCTICA", 1))
    c.append(heading("8.1 Escenario A - Atención normal", 2))
    c.append(para(
        "Se generan 10 turnos para el servicio \"CITAS\". Tres asesores los "
        "atienden y cierran. Validar tiempos en el dashboard al finalizar."
    ))

    c.append(heading("8.2 Escenario B - Paciente prioritario", 2))
    c.append(para(
        "Una asistente del recepción genera un turno común. Otra genera un "
        "turno prioritario. Validar que el segundo se atiende antes."
    ))

    c.append(heading("8.3 Escenario C - Ausencia y rellamada", 2))
    c.append(para(
        "Se genera un turno y, al llamarlo, el paciente no aparece. Se "
        "ejecuta el protocolo de rellamada y aplazamiento. Validar registro "
        "en el historial."
    ))

    c.append(heading("8.4 Escenario D - Canal no presencial", 2))
    c.append(para(
        "Un asesor activa canal no presencial durante 20 minutos. Validar "
        "que el dashboard lo refleja y que el reporte derivado lo contabiliza."
    ))

    c.append(heading("8.5 Escenario E - Contingencia", 2))
    c.append(para(
        "Se simula caída de red durante 5 minutos. Se atiende manualmente y "
        "luego se ingresan los turnos atendidos al sistema. Validar reportes."
    ))

    # 9. EVALUACION
    c.append(heading("9. EVALUACIÓN DE LA SESIÓN 2", 1))
    c.append(bullet("¿Sé generar un reporte en Excel y enviarlo a mi líder?"))
    c.append(bullet("¿Sé activar y desactivar el canal no presencial?"))
    c.append(bullet("¿Reconozco una caída de red versus una caída del servidor?"))
    c.append(bullet("¿Sé interpretar los colores del dashboard?"))
    c.append(bullet("¿Tengo claro el protocolo de respaldo manual?"))

    # 10. CERTIFICACION
    c.append(heading("10. CERTIFICACIÓN", 1))
    c.append(para(
        "El asistente que apruebe ambas sesiones (1 y 2) recibirá una "
        "constancia digital de capacitación válida para el HUV. La "
        "constancia se emite tras aprobar la evaluación final con al "
        "menos el 80% de aciertos."
    ))

    c.append(divider())
    c.append(para("FIN DEL MATERIAL DE ENTRENAMIENTO - SESIÓN 2.", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - Hospital Universitario del Valle", align="center"))

    return "".join(c)


if __name__ == "__main__":
    out = build_docx("MATERIAL_ENTRENAMIENTO_SESION_2", build())
    print(f"OK -> {out}")
