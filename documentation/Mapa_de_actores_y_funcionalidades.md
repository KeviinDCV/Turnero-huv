# Mapa de Actores y Funcionalidades: Turnero HUV

---

## 1. Introducción
Este documento identifica los actores clave del sistema "Turnero HUV" y mapea las funcionalidades específicas que cada uno puede realizar. Un actor es un rol que interactúa con el sistema, ya sea una persona o un sistema externo.

## 2. Actores del Sistema

-   **Usuario/Paciente:** Es la persona que acude al hospital y necesita un servicio. Interactúa con el sistema para obtener un turno.
-   **Asesor:** Es el empleado del hospital que atiende a los usuarios en un módulo o ventanilla. Utiliza el sistema para gestionar la llamada y atención de turnos.
-   **Administrador:** Es el usuario con los máximos privilegios, responsable de configurar y mantener el sistema.
-   **Sistema:** Se refiere a las acciones automáticas y procesos internos que el software realiza.

## 3. Matriz de Funcionalidades por Actor

A continuación se detalla qué puede hacer cada actor dentro del sistema.

### Usuario / Paciente
-   **Interactuar con el Quiosco/Atril:**
    -   Ver la lista de servicios disponibles (Citas, Copagos, Facturación, Programación).
    -   Seleccionar un servicio para solicitar un turno.
    -   Recibir un número de turno en pantalla.
    -   Obtener un código QR o URL para el seguimiento móvil.
-   **Seguimiento Móvil:**
    -   Acceder a la página web de seguimiento de turnos.
    -   Ingresar su número de turno.
    -   Visualizar su posición en la cola y el estado actual de los llamados.
-   **Visualización en TV:**
    -   Ver en las pantallas públicas qué turno está siendo llamado y a qué módulo debe dirigirse.

### Asesor
-   **Autenticación:**
    -   Iniciar y cerrar sesión en el sistema con sus credenciales.
-   **Gestión de Estado:**
    -   Abrir o cerrar su puesto de atención (módulo/ventanilla).
-   **Gestión de Turnos:**
    -   Llamar al siguiente turno de la cola de los servicios que tiene asignados.
    -   Ver en su pantalla el número del turno llamado.
    -   Re-llamar un turno si el usuario no se presenta inmediatamente.
    -   Marcar un turno como "atendido" para finalizar el proceso.
    -   Marcar un turno como "ausente" o "abandonado".
    -   Transferir un turno a otro servicio si es necesario.
-   **Visualización de Información:**
    -   Ver la cantidad de usuarios en espera para sus servicios.
    -   Ver estadísticas básicas de su propio rendimiento (turnos atendidos en el día).

### Administrador
-   **Todas las funcionalidades del Asesor:** Un administrador puede realizar todas las acciones de un asesor.
-   **Gestión de Usuarios (CRUD):**
    -   Crear cuentas para nuevos asesores y administradores.
    -   Modificar los datos y roles de los usuarios existentes.
    -   Desactivar o eliminar cuentas de usuario.
-   **Gestión de Servicios (CRUD):**
    -   Crear nuevos tipos de servicio.
    -   Editar los nombres o propiedades de los servicios.
    -   Eliminar servicios.
-   **Gestión de Módulos (CRUD):**
    -   Añadir, modificar o eliminar los módulos/ventanillas de atención.
-   **Asignación y Configuración:**
    -   Asignar servicios específicos a los módulos de atención.
    -   Asignar asesores a los módulos.
-   **Configuración del Sistema:**
    -   Definir horarios de atención.
    -   Personalizar la apariencia y contenido de la pantalla de TV.
    -   Modificar textos y mensajes del sistema.
-   **Reportes y Estadísticas:**
    -   Acceder a reportes detallados sobre el rendimiento general del sistema.
    -   Filtrar datos por fechas, asesores, servicios, etc.
    -   Exportar los reportes (ej. a PDF o Excel).
    -   Visualizar gráficos y dashboards de gestión.

### Sistema (Procesos Automáticos)
-   **Gestión de Colas:**
    -   Asignar un número de turno correlativo y único por servicio.
    -   Mantener el orden de la cola (FIFO: First-In, First-Out).
    -   Actualizar el estado de los turnos (en espera, llamado, atendido, ausente).
-   **Sincronización:**
    -   Actualizar en tiempo real la información en todas las pantallas (Asesor, TV, Móvil) cuando un turno es llamado o su estado cambia.
-   **Cálculos y Registros:**
    -   Registrar timestamps para cada acción (generación, llamada, inicio/fin de atención).
    -   Calcular tiempos de espera y de atención.
    -   Almacenar los datos para la generación de reportes. 