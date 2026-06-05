"""MANUAL_DE_USUARIO.docx"""

import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).parent))
from build_docs import (
    build_docx, title, subtitle, heading, para, bullet, numbered,
    code_block, table, divider, page_break,
)


def build():
    c = []
    c.append(title("MANUAL DE USUARIO"))
    c.append(subtitle("Sistema de Gestión de Turnos - Turnero HUV"))
    c.append(para("Guía operativa para administradores, asesores y pacientes", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - HUV - Mayo 2026", align="center"))
    c.append(divider())

    # 1. INTRODUCCION
    c.append(heading("1. INTRODUCCIÓN", 1))
    c.append(para(
        "Bienvenido al Manual de Usuario del Sistema de Gestión de Turnos del "
        "Hospital Universitario del Valle. Este documento describe paso a paso "
        "cómo operar el sistema según el rol del usuario: administrador, asesor "
        "(personal médico o administrativo), paciente y operador de atril o "
        "pantalla de televisión."
    ))
    c.append(para(
        "El sistema busca eliminar las colas físicas, agilizar la atención y "
        "ofrecer trazabilidad operativa. La interfaz fue diseñada para ser usable "
        "sin entrenamiento técnico previo."
    ))

    c.append(heading("1.1 Perfiles cubiertos en este manual", 2))
    c.append(bullet("Administrador del sistema."))
    c.append(bullet("Asesor / médico atendiendo en caja o consultorio."))
    c.append(bullet("Paciente (vista móvil vía QR)."))
    c.append(bullet("Operador del atril de generación de turnos."))
    c.append(bullet("Operador de la pantalla TV pública."))

    # 2. ACCESO
    c.append(heading("2. ACCESO AL SISTEMA", 1))
    c.append(heading("2.1 URL", 2))
    c.append(para(
        "Abrir el navegador (recomendado: Google Chrome o Microsoft Edge) e "
        "ingresar a la URL provista por el equipo de TI (ejemplo: "
        "http://turnos.huv.gov.co o la IP interna asignada)."
    ))

    c.append(heading("2.2 Inicio de sesión", 2))
    c.append(numbered("Ingresar nombre de usuario (no es el correo).", 1))
    c.append(numbered("Ingresar contraseña.", 2))
    c.append(numbered("Hacer clic en \"Iniciar sesión\".", 3))
    c.append(para(
        "El sistema redirigirá automáticamente al panel correspondiente según el "
        "rol. Si el usuario es Asesor sin caja asignada, se pedirá seleccionar "
        "una caja al iniciar la sesión."
    ))

    c.append(heading("2.3 Reglas de sesión", 2))
    c.append(bullet("Solo se permite una sesión activa por usuario. Si se inicia desde otro equipo, la sesión anterior se cierra automáticamente."))
    c.append(bullet("La sesión expira tras 15 minutos sin actividad."))
    c.append(bullet("Si se pierde la conexión, refrescar la página (F5) recupera el estado."))

    c.append(page_break())

    # 3. ADMINISTRADOR
    c.append(heading("3. PERFIL: ADMINISTRADOR", 1))
    c.append(para(
        "El administrador tiene control total sobre el sistema. Las opciones "
        "disponibles en el menú lateral se describen a continuación."
    ))

    c.append(heading("3.1 Dashboard principal", 2))
    c.append(para("Métricas en tiempo real disponibles en /dashboard:"))
    c.append(bullet("Turnos en espera por servicio."))
    c.append(bullet("Turnos atendidos del día."))
    c.append(bullet("Asesores conectados y su estado."))
    c.append(bullet("Tiempo promedio de atención y de espera."))

    c.append(heading("3.2 Gestión de usuarios", 2))
    c.append(para("Menú: Usuarios. Permite crear, editar e inactivar cuentas."))
    c.append(table(
        ["Campo", "Descripción"],
        [
            ["Nombre completo", "Como aparece en el carnet del funcionario"],
            ["Correo electrónico", "Email institucional"],
            ["Nombre de usuario", "Identificador para login (único)"],
            ["Cédula", "Documento del funcionario (único)"],
            ["Rol", "Administrador o Asesor"],
            ["Contraseña", "Temporal; el usuario debe cambiarla"],
            ["Estado del asesor", "Disponible / Ocupado / Descanso / No disponible"],
        ],
        col_widths=[3000, 6405],
    ))
    c.append(bullet("Para inactivar un funcionario que se retira, editar y cambiar estado a inactivo. NO eliminar (se perdería el historial)."))
    c.append(bullet("Para resetear contraseña, usar la opción \"Editar\" y asignar una nueva clave temporal."))

    c.append(heading("3.3 Gestión de servicios", 2))
    c.append(para("Menú: Servicios. Define las colas de atención."))
    c.append(bullet("Servicios principales (CITAS, COPAGOS, FACTURACIÓN, PROGRAMACIÓN, etc.)."))
    c.append(bullet("Subservicios anidados (Citas Medicina General, Facturación Ambulatoria, ...)."))
    c.append(bullet("Código: prefijo del turno (3 letras). Se muestra al paciente (ej. CIT-001)."))
    c.append(bullet("Orden: posición en el atril."))
    c.append(bullet("Ocultar turno: si está marcado, el número no se muestra en la pantalla pública."))
    c.append(bullet("Requiere priorización: habilita el botón de priorización en el atril."))

    c.append(heading("3.4 Gestión de cajas", 2))
    c.append(para("Menú: Cajas. Define los puntos físicos de atención."))
    c.append(bullet("Nombre: \"Caja 1\", \"Consultorio 205\", \"Módulo A\", etc."))
    c.append(bullet("Ubicación: descripción física para guiar al paciente."))
    c.append(bullet("Estado activa: si está apagada, no aparece para ser seleccionada por los asesores."))
    c.append(bullet("Asesor asignado: la caja se libera automáticamente cuando la sesión del asesor expira."))

    c.append(heading("3.5 Asignación de servicios a asesores", 2))
    c.append(para("Menú: Asignación de servicios."))
    c.append(numbered("Seleccionar el asesor.", 1))
    c.append(numbered("Marcar los servicios que está autorizado a atender.", 2))
    c.append(numbered("Guardar. Los cambios aplican inmediatamente.", 3))
    c.append(para(
        "El sistema usa esta tabla para mostrar al asesor únicamente los turnos "
        "de servicios que puede atender."
    ))

    c.append(heading("3.6 Configuración del TV", 2))
    c.append(para("Menú: TV Config. Personaliza la pantalla pública."))
    c.append(bullet("Logo institucional."))
    c.append(bullet("Mensaje rodante (marquesina inferior)."))
    c.append(bullet("Multimedia: imágenes y videos que rotan junto a la cola de turnos."))
    c.append(bullet("Orden de reproducción de multimedia."))
    c.append(bullet("Habilitar/deshabilitar audio."))

    c.append(heading("3.7 Multimedia", 2))
    c.append(numbered("Cargar archivo (imagen .jpg/.png o video .mp4).", 1))
    c.append(numbered("Definir duración (segundos) si es imagen.", 2))
    c.append(numbered("Activar / desactivar.", 3))
    c.append(numbered("Reordenar arrastrando.", 4))
    c.append(para(
        "Tamaño recomendado: imágenes 1920x1080, videos máximo 50 MB.",
        italic=True,
    ))

    c.append(heading("3.8 Gráficos y reportes", 2))
    c.append(bullet("Menú Gráficos: panel interactivo en tiempo real e histórico."))
    c.append(bullet("Menú Reportes: generación de PDF y Excel filtrando por rango de fechas, servicio o asesor."))
    c.append(bullet("Botón \"Exportar dashboard histórico\" descarga un reporte ejecutivo consolidado."))

    c.append(heading("3.9 Soporte", 2))
    c.append(para(
        "Menú: Soporte. Permite registrar incidencias o solicitudes hacia el "
        "área de Innovación y Desarrollo. Cada solicitud queda con número de "
        "ticket y se atiende según los SLA definidos en el Acta de Entrega."
    ))

    c.append(heading("3.10 Mantenimiento de sesiones", 2))
    c.append(bullet("Limpiar sesiones expiradas: libera cajas ocupadas por usuarios desconectados."))
    c.append(bullet("Limpiar todas las sesiones: cierra todas las sesiones del sistema."))
    c.append(bullet("Limpiar sesión de un usuario específico: cierra solo la del usuario seleccionado."))

    c.append(page_break())

    # 4. ASESOR
    c.append(heading("4. PERFIL: ASESOR / MÉDICO", 1))
    c.append(para(
        "El asesor es el funcionario que atiende a los pacientes. El panel "
        "fue diseñado para ser rápido y mantener la atención en un solo botón."
    ))

    c.append(heading("4.1 Selección de caja", 2))
    c.append(para("Al iniciar sesión por primera vez en el día:"))
    c.append(numbered("Aparece la pantalla \"Seleccionar caja\".", 1))
    c.append(numbered("Elegir la caja física donde se atenderá hoy.", 2))
    c.append(numbered("Presionar \"Iniciar atención\".", 3))
    c.append(para(
        "La caja queda asociada al asesor hasta que cierre sesión o expire por "
        "inactividad. Si necesita cambiar de caja durante el día, usar la opción "
        "\"Cambiar caja\" del menú superior."
    ))

    c.append(heading("4.2 Llamar al siguiente paciente", 2))
    c.append(para("En el dashboard del asesor se ve el botón gigante LLAMAR SIGUIENTE."))
    c.append(numbered("Presionar el botón.", 1))
    c.append(numbered("El sistema busca el siguiente turno según prioridad y orden de llegada.", 2))
    c.append(numbered("Se emite el anuncio por voz en la pantalla TV: \"Turno CIT-001, diríjase a la Caja 1\".", 3))
    c.append(numbered("El estado del turno cambia a \"llamado\" y se muestra en la TV en color destacado.", 4))

    c.append(heading("4.3 Atender turno específico", 2))
    c.append(para(
        "Si el paciente trae un turno específico, se puede llamar directamente "
        "ingresando el código en la opción \"Llamar turno específico\"."
    ))

    c.append(heading("4.4 Marcar como atendido", 2))
    c.append(numbered("Al terminar con el paciente, presionar FINALIZAR.", 1))
    c.append(numbered("El sistema calcula la duración real de atención.", 2))
    c.append(numbered("Se libera la caja y se queda lista para llamar al siguiente.", 3))

    c.append(heading("4.5 Aplazar turno", 2))
    c.append(para(
        "Si el paciente requiere completar documentación o regresar más tarde, "
        "presionar \"Aplazar\". El turno se devuelve a la cola al final."
    ))

    c.append(heading("4.6 Rellamar (paciente ausente)", 2))
    c.append(numbered("Tras llamar, esperar 20 segundos.", 1))
    c.append(numbered("Si el paciente no aparece, presionar el ícono de bocina (rellamar).", 2))
    c.append(numbered("Esperar otros 20 segundos.", 3))
    c.append(numbered("Si tras el segundo intento no aparece, marcar como ausente / aplazar.", 4))

    c.append(heading("4.7 Canal no presencial", 2))
    c.append(para(
        "Si el asesor atiende llamadas o canales virtuales (no pacientes "
        "presenciales), debe usar las opciones:"
    ))
    c.append(bullet("Iniciar canal no presencial: define el tipo de actividad (callcenter, virtual)."))
    c.append(bullet("Finalizar canal no presencial: registra el tiempo total."))
    c.append(para(
        "Mientras esté en canal no presencial, el asesor figura como \"No "
        "disponible\" para turnos presenciales y los tiempos se registran en los "
        "reportes correspondientes."
    ))

    c.append(heading("4.8 Historial de turnos", 2))
    c.append(para(
        "El menú \"Historial\" muestra los turnos atendidos por el asesor en el "
        "día, con tiempos de atención y estado final."
    ))

    c.append(page_break())

    # 5. PACIENTE (movil)
    c.append(heading("5. PERFIL: PACIENTE (VISTA MÓVIL)", 1))
    c.append(heading("5.1 Acceso vía QR", 2))
    c.append(numbered("Tomar el ticket impreso al generar el turno.", 1))
    c.append(numbered("Escanear el código QR con la cámara del celular.", 2))
    c.append(numbered("Se abre la página /movil del sistema con el estado del turno.", 3))

    c.append(heading("5.2 Información disponible", 2))
    c.append(bullet("Código del turno (ej. CIT-001)."))
    c.append(bullet("Servicio solicitado."))
    c.append(bullet("Posición en la cola."))
    c.append(bullet("Estado actual (en espera / llamado / atendido)."))
    c.append(bullet("Caja asignada cuando sea llamado."))

    c.append(heading("5.3 Notificaciones", 2))
    c.append(para(
        "Cuando se llama el turno, la página se actualiza automáticamente y, si "
        "el navegador lo permite, vibra y reproduce un sonido de notificación. "
        "Es responsabilidad del paciente mantener la página abierta para recibir "
        "el aviso."
    ))

    # 6. ATRIL
    c.append(heading("6. ATRIL DE GENERACIÓN DE TURNOS", 1))
    c.append(heading("6.1 Flujo paciente / recepcionista", 2))
    c.append(numbered("Tocar el botón del servicio deseado (Citas, Copagos, Facturación, ...).", 1))
    c.append(numbered("Si el servicio tiene subservicios, seleccionar la opción concreta.", 2))
    c.append(numbered("Si aplica, tocar \"Prioritario\" antes de generar (adulto mayor, embarazada, discapacidad).", 3))
    c.append(numbered("Esperar la impresión del ticket con el código y el QR.", 4))
    c.append(numbered("Tomar asiento en la sala de espera y observar la pantalla.", 5))

    c.append(heading("6.2 Buenas prácticas", 2))
    c.append(bullet("Mantener el rollo de papel térmico abastecido."))
    c.append(bullet("Limpiar la pantalla táctil al inicio y al final del día."))
    c.append(bullet("Si la impresora se atasca, abrir, retirar el papel arrugado y reinsertar el rollo con la cara térmica hacia afuera."))
    c.append(bullet("En caso de congelamiento, reiniciar el mini-PC desde el botón físico."))

    # 7. TV
    c.append(heading("7. PANTALLA TV PÚBLICA", 1))
    c.append(heading("7.1 Configuración", 2))
    c.append(numbered("Iniciar el navegador en modo pantalla completa (F11).", 1))
    c.append(numbered("Ingresar a /tv.", 2))
    c.append(numbered("Hacer un clic en cualquier parte de la pantalla para autorizar el audio del navegador.", 3))

    c.append(heading("7.2 Qué muestra la pantalla", 2))
    c.append(bullet("Cola de turnos en espera por servicio."))
    c.append(bullet("Turno actualmente llamado con caja destacada."))
    c.append(bullet("Multimedia institucional (imágenes y videos)."))
    c.append(bullet("Mensaje rodante configurable."))
    c.append(bullet("Reloj y fecha sincronizados con el servidor."))

    c.append(heading("7.3 Reinicio rápido", 2))
    c.append(para(
        "Si la TV se queda congelada o pierde la conexión, refrescar la "
        "página con F5. El sistema recupera el estado automáticamente."
    ))

    c.append(page_break())

    # 8. SOLUCION DE PROBLEMAS
    c.append(heading("8. SOLUCIÓN DE PROBLEMAS COMUNES", 1))
    c.append(table(
        ["Problema", "Causa probable", "Solución"],
        [
            ["No suena el audio del llamado", "Navegador bloqueó autoplay", "Hacer clic una vez sobre la TV para autorizar el audio"],
            ["Pantalla TV no actualiza", "WebSocket caído", "Refrescar con F5; el polling de respaldo recupera en 3s"],
            ["No puedo iniciar sesión", "Usuario o contraseña incorrectos", "Solicitar reset al administrador"],
            ["No aparezco como disponible", "Sesión expirada", "Cerrar y volver a iniciar sesión"],
            ["No veo turnos en espera", "Ningún turno generado o no se atienden esos servicios", "Verificar asignación en /asignacion-servicios"],
            ["Impresora sin papel", "Rollo agotado", "Cambiar rollo y reiniciar la pantalla del atril"],
            ["Error 419", "Token CSRF expirado", "Refrescar la página; en kiosko ejecutar fix-session-419.bat"],
            ["Caja ocupada por otro usuario", "Otro asesor inició sesión", "Esperar que libere; admin puede limpiar la sesión"],
        ],
        col_widths=[2800, 2900, 3705],
    ))

    # 9. CONTACTO SOPORTE
    c.append(heading("9. CONTACTO DE SOPORTE", 1))
    c.append(bullet("Mesa de servicio HUV: Ext. 1234."))
    c.append(bullet("Correo: soporte_sistemas@huv.gov.co."))
    c.append(bullet("Solicitudes formales: módulo /soporte dentro del sistema."))
    c.append(bullet("Horario: lunes a viernes 7:00 - 18:00; turnos rotativos 24/7 para incidentes críticos."))

    c.append(divider())
    c.append(para("FIN DEL MANUAL DE USUARIO.", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - Hospital Universitario del Valle", align="center"))

    return "".join(c)


if __name__ == "__main__":
    out = build_docx("MANUAL_DE_USUARIO", build())
    print(f"OK -> {out}")
