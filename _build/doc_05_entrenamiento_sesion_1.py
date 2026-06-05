"""MATERIAL_ENTRENAMIENTO_SESION_1.docx - introducción y conceptos."""

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
    c.append(subtitle("Sesión 1 - Introducción al Turnero HUV"))
    c.append(para("Conceptos básicos, flujo del paciente y primeros pasos", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - HUV - Mayo 2026", align="center"))
    c.append(divider())

    # 1. INTRODUCCION
    c.append(heading("1. PRESENTACIÓN DE LA SESIÓN", 1))
    c.append(heading("1.1 Duración estimada", 2))
    c.append(para("3 horas (incluye pausa de 15 minutos)."))

    c.append(heading("1.2 Público objetivo", 2))
    c.append(bullet("Personal de recepción y atención al usuario."))
    c.append(bullet("Asesores nuevos (médicos, enfermeras, auxiliares administrativos)."))
    c.append(bullet("Líderes de área que supervisarán la operación."))

    c.append(heading("1.3 Objetivos pedagógicos", 2))
    c.append(numbered("Comprender qué es el sistema y qué problema resuelve.", 1))
    c.append(numbered("Reconocer los roles y responsabilidades de cada perfil.", 2))
    c.append(numbered("Dominar el flujo del paciente de principio a fin.", 3))
    c.append(numbered("Iniciar sesión, generar un turno y atender un paciente de prueba.", 4))
    c.append(numbered("Identificar los puntos de soporte y escalamiento.", 5))

    c.append(heading("1.4 Materiales requeridos", 2))
    c.append(bullet("Computador o tablet con acceso a la red del HUV."))
    c.append(bullet("Acceso al ambiente de entrenamiento (URL provista)."))
    c.append(bullet("Credenciales temporales para cada asistente."))
    c.append(bullet("Pantalla TV y atril en sala de simulación."))
    c.append(bullet("Cuaderno de notas o tablet para registro de ejercicios."))

    c.append(page_break())

    # 2. CONTEXTO
    c.append(heading("2. CONTEXTO Y JUSTIFICACIÓN", 1))
    c.append(heading("2.1 Problemática previa", 2))
    c.append(bullet("Colas físicas largas y desordenadas en salas de espera."))
    c.append(bullet("Dificultad para priorizar pacientes con derecho preferencial."))
    c.append(bullet("Ausencia de métricas operativas para toma de decisiones."))
    c.append(bullet("Quejas frecuentes por demoras y falta de información."))
    c.append(bullet("Tiempos de atención no trazables ni auditables."))

    c.append(heading("2.2 Qué resuelve el sistema", 2))
    c.append(bullet("Asigna turnos digitales con código único y código QR."))
    c.append(bullet("Distribuye automáticamente los turnos por servicio y prioridad."))
    c.append(bullet("Anuncia por voz y pantalla cuando es el momento de pasar."))
    c.append(bullet("Provee métricas en tiempo real al área administrativa."))
    c.append(bullet("Permite que el paciente consulte su estado desde su celular."))

    c.append(heading("2.3 Indicadores esperados tras adopción", 2))
    c.append(table(
        ["Indicador", "Estado anterior", "Meta con sistema"],
        [
            ["Tiempo promedio de espera", "30 minutos", "12 minutos"],
            ["Quejas relacionadas con la fila", "12 mensuales", "≤ 2 mensuales"],
            ["Pacientes prioritarios atendidos a tiempo", "75%", "98%"],
            ["Tiempo de cierre administrativo del día", "60 minutos", "Automático"],
            ["Reportes operativos por mes", "1 manual", "Diarios automáticos"],
        ],
        col_widths=[3500, 2800, 3105],
    ))

    c.append(page_break())

    # 3. GLOSARIO
    c.append(heading("3. GLOSARIO BÁSICO", 1))
    c.append(para(
        "Estos términos se usarán durante toda la operación. Es importante "
        "que el equipo los maneje con el mismo significado."
    ))
    c.append(table(
        ["Término", "Definición"],
        [
            ["Turno", "Código alfanumérico único asignado a un paciente (ej. CIT-001)."],
            ["Servicio", "Categoría de la atención (Citas, Copagos, Facturación, etc.)."],
            ["Subservicio", "Especialización dentro de un servicio (ej. Citas Medicina General)."],
            ["Caja", "Punto físico donde el asesor atiende (ventanilla o consultorio)."],
            ["Atril", "Pantalla táctil donde el paciente o recepcionista genera el turno."],
            ["Display TV", "Pantalla pública que muestra los turnos llamados y la cola."],
            ["Asesor", "Funcionario que atiende al paciente desde una caja."],
            ["Prioridad", "Clasificación que altera el orden natural de llegada."],
            ["Ticket", "Comprobante físico con el código del turno y el código QR."],
            ["Canal no presencial", "Atención telefónica o virtual realizada por un asesor."],
        ],
        col_widths=[2700, 6705],
    ))

    c.append(page_break())

    # 4. FLUJO DEL PACIENTE
    c.append(heading("4. FLUJO DEL PACIENTE", 1))
    c.append(para(
        "El siguiente flujo es el camino completo que recorre un paciente "
        "desde que ingresa hasta que es atendido."
    ))
    c.append(code_block(
        "  [Llegada] -> [Atril] -> [Espera con ticket] -> [Llamado en TV]\n"
        "                                                       |\n"
        "                                                       v\n"
        "                            [Atención en caja] -> [Finalización]\n"
        "                                                       |\n"
        "                                                       v\n"
        "                                       [Cierre y métricas]"
    ))
    c.append(heading("4.1 Etapas detalladas", 2))
    c.append(numbered("Ingreso del paciente al hospital.", 1))
    c.append(numbered("Selección del servicio en el atril (o asistencia del recepcionista).", 2))
    c.append(numbered("Marcado de priorización si aplica (Ley 1171, embarazo, discapacidad).", 3))
    c.append(numbered("Impresión del ticket con código y QR.", 4))
    c.append(numbered("Paciente toma asiento y observa la pantalla TV.", 5))
    c.append(numbered("Cuando el asesor presiona \"Llamar siguiente\", el sistema anuncia el turno.", 6))
    c.append(numbered("Paciente se dirige a la caja indicada.", 7))
    c.append(numbered("Asesor presta el servicio.", 8))
    c.append(numbered("Asesor marca el turno como \"Atendido\".", 9))
    c.append(numbered("El sistema registra duración y libera la caja.", 10))

    c.append(heading("4.2 Casos especiales", 2))
    c.append(bullet("Aplazamiento: si el paciente requiere más documentos, se aplaza y vuelve a la cola."))
    c.append(bullet("Rellamada: si no aparece, se llama una segunda vez antes de marcar ausente."))
    c.append(bullet("Transferencia: se puede mover a otra caja en caso de derivación."))
    c.append(bullet("Atención prioritaria: salta a la cabeza de la cola, respetando otros prioritarios."))

    c.append(page_break())

    # 5. ROLES
    c.append(heading("5. ROLES Y RESPONSABILIDADES", 1))
    c.append(table(
        ["Rol", "Quién", "Responsabilidad"],
        [
            ["Administrador", "Líderes de área, TI", "Configura servicios, cajas, usuarios y reportes."],
            ["Asesor", "Médicos, enfermeras, auxiliares", "Llama y atiende pacientes."],
            ["Recepcionista", "Personal de recepción", "Asiste al paciente en el atril si requiere."],
            ["Operador TV", "Personal de servicios generales", "Vigila que la pantalla esté encendida y refresca si falla."],
            ["Paciente", "Usuario externo", "Toma su turno, espera, atiende el llamado."],
        ],
        col_widths=[2200, 3000, 4205],
    ))

    c.append(heading("5.1 Reglas de oro para asesores", 2))
    c.append(bullet("Iniciar sesión con su propia cuenta - nunca prestar credenciales."))
    c.append(bullet("Seleccionar siempre la caja real donde está atendiendo."))
    c.append(bullet("Llamar al siguiente turno inmediatamente después de cerrar el anterior."))
    c.append(bullet("Usar la opción \"Pausa\" si se ausenta, no cerrar el navegador."))
    c.append(bullet("Cerrar sesión al terminar la jornada."))

    c.append(heading("5.2 Reglas de oro para administradores", 2))
    c.append(bullet("Revisar a diario el dashboard antes de la apertura."))
    c.append(bullet("Mantener actualizada la asignación de servicios a asesores."))
    c.append(bullet("Rotar contraseñas trimestralmente."))
    c.append(bullet("Verificar que los backups estén funcionando."))
    c.append(bullet("Atender los tickets de soporte en tiempos SLA."))

    c.append(page_break())

    # 6. PRIMER CONTACTO
    c.append(heading("6. PRIMER CONTACTO CON EL SISTEMA", 1))
    c.append(heading("6.1 Ejercicio 1: Iniciar sesión", 2))
    c.append(numbered("Abrir el navegador (Chrome o Edge).", 1))
    c.append(numbered("Ingresar a la URL provista por el instructor.", 2))
    c.append(numbered("Digitar usuario y contraseña entregados.", 3))
    c.append(numbered("Identificar el rol asignado en el menú lateral.", 4))

    c.append(heading("6.2 Ejercicio 2: Generar un turno", 2))
    c.append(numbered("Ingresar al atril en /turnos.", 1))
    c.append(numbered("Seleccionar el servicio \"CITAS\".", 2))
    c.append(numbered("Seleccionar el subservicio \"Citas Medicina General\".", 3))
    c.append(numbered("Visualizar la pantalla de ticket con el código generado.", 4))
    c.append(numbered("Comprobar que el QR funciona escaneándolo con el celular.", 5))

    c.append(heading("6.3 Ejercicio 3: Atender un turno (como asesor)", 2))
    c.append(numbered("Cerrar sesión como administrador.", 1))
    c.append(numbered("Iniciar sesión como asesor de prueba.", 2))
    c.append(numbered("Seleccionar una caja (ej. Caja 1).", 3))
    c.append(numbered("Presionar \"Llamar siguiente\".", 4))
    c.append(numbered("Verificar el anuncio en la pantalla TV de la sala de simulación.", 5))
    c.append(numbered("Marcar el turno como \"Atendido\".", 6))

    c.append(heading("6.4 Ejercicio 4: Vista móvil", 2))
    c.append(numbered("Escanear el QR del ticket generado.", 1))
    c.append(numbered("Verificar que aparezca el estado del turno.", 2))
    c.append(numbered("Esperar a que un asesor lo llame y comprobar la actualización.", 3))

    c.append(page_break())

    # 7. EVALUACION
    c.append(heading("7. EVALUACIÓN DE LA SESIÓN 1", 1))
    c.append(heading("7.1 Checklist individual", 2))
    c.append(bullet("Sé qué es un turno y cómo se compone su código."))
    c.append(bullet("Identifico los servicios principales del HUV."))
    c.append(bullet("Sé iniciar sesión, generar un turno y atenderlo."))
    c.append(bullet("Conozco la diferencia entre rol Administrador y rol Asesor."))
    c.append(bullet("Sé a quién contactar ante una incidencia."))

    c.append(heading("7.2 Preguntas rápidas", 2))
    c.append(numbered("¿Cuántos minutos puede estar inactiva mi sesión antes de cerrarse?", 1))
    c.append(numbered("¿Qué hago si el paciente no se presenta al ser llamado?", 2))
    c.append(numbered("¿Qué ocurre si inicio sesión desde otro PC con mis credenciales?", 3))
    c.append(numbered("¿Cómo doy prioridad a una mujer en estado de embarazo?", 4))
    c.append(numbered("¿En qué menú está la opción \"Multimedia\"?", 5))

    # 8. PROXIMA SESION
    c.append(heading("8. PRÓXIMA SESIÓN", 1))
    c.append(para(
        "En la Sesión 2 abordaremos la operación avanzada: rellamadas, "
        "aplazamientos, canal no presencial, reportes, gráficos y "
        "procedimientos de contingencia ante caídas del sistema."
    ))
    c.append(bullet("Lectura previa recomendada: secciones 4 y 5 del Manual de Usuario."))
    c.append(bullet("Traer un caso real (anonimizado) de la operación para discutirlo."))

    c.append(divider())
    c.append(para("FIN DEL MATERIAL DE ENTRENAMIENTO - SESIÓN 1.", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - Hospital Universitario del Valle", align="center"))

    return "".join(c)


if __name__ == "__main__":
    out = build_docx("MATERIAL_ENTRENAMIENTO_SESION_1", build())
    print(f"OK -> {out}")
