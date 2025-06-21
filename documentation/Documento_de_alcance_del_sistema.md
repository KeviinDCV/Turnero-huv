# Documento de Alcance del Sistema: Turnero HUV

---

## 1. Descripción del Producto
El "Turnero HUV" es un sistema web integral diseñado para modernizar y automatizar la gestión de colas de espera en el Hospital Universitario del Valle. El sistema gestionará el ciclo de vida completo de un turno, desde que el usuario lo solicita en un quiosco hasta que es atendido por un asesor, mostrando el estado en tiempo real en pantallas y dispositivos móviles.

## 2. Funcionalidades del Sistema (Dentro del Alcance)

A continuación se detallan las funcionalidades que serán incluidas en la versión final del producto.

### Módulo de Administración
-   **Gestión de Usuarios:**
    -   Crear, leer, actualizar y eliminar (CRUD) cuentas de usuario para el personal (roles: Administrador, Asesor).
    -   Asignar roles y permisos.
    -   Resetear contraseñas.
-   **Gestión de Servicios:**
    -   CRUD para los servicios ofrecidos (ej. Citas, Copagos, Facturación, Programación).
    -   Asociar servicios a módulos o ventanillas de atención.
-   **Gestión de Módulos/Ventanillas:**
    -   CRUD para los puntos de atención física.
    -   Asignar asesores a los módulos.
-   **Configuración General:**
    -   Configurar horarios de atención.
    -   Personalizar mensajes para las pantallas y tickets.
    -   Configurar parámetros del sistema (ej. tiempo de alerta).
-   **Configuración de TV:**
    -   Gestionar qué información se muestra en las pantallas.
    -   Personalizar la apariencia de la vista de TV.
-   **Gestión de Contenido:**
    -   Administrar preguntas frecuentes (si aplica).

### Módulo de Asesor
-   **Inicio de Sesión:** Autenticación segura.
-   **Dashboard de Asesor:**
    -   Visualizar el estado de su módulo (abierto/cerrado).
    -   Ver la cantidad de personas en espera para sus servicios asignados.
-   **Llamada de Turnos:**
    -   Llamar al siguiente turno en la cola.
    -   Volver a llamar a un turno (recall).
    -   Marcar un turno como "no se presentó".
-   **Gestión de Atención:**
    -   Iniciar y finalizar la atención de un turno.
    -   Transferir un turno a otro servicio o módulo.

### Módulo de Quiosco (Atril)
-   **Interfaz Táctil e Intuitiva:**
    -   Pantalla de bienvenida con la identidad del HUV.
-   **Selección de Servicio:**
    -   El usuario selecciona el tipo de servicio que necesita (Citas, Copagos, etc.).
-   **Generación de Ticket:**
    -   El sistema genera un turno con un código único (ej. A001).
    -   (Opcional) Impresión de ticket físico.
    -   Muestra de un código QR para seguimiento móvil.

### Módulo de Visualización (TV y Móvil)
-   **Pantalla de TV:**
    -   Muestra en tiempo real los últimos turnos llamados, indicando el turno y el módulo/ventanilla.
    -   Puede mostrar contenido multimedia (videos, imágenes) en un área designada.
-   **Vista Móvil:**
    -   El usuario escanea el QR o introduce su código de turno en una URL pública.
    -   Puede ver su posición en la cola y recibir una notificación cuando su turno esté próximo a ser llamado.

### Módulo de Reportes y Gráficos
-   **Reportes:**
    -   Reporte de tiempos de espera (promedio, máximo).
    -   Reporte de tiempos de atención por asesor/servicio.
    -   Reporte de turnos atendidos, abandonados, etc.
    -   Filtros por fecha, servicio y asesor.
-   **Gráficos:**
    -   Dashboard con gráficos visuales sobre la operación en tiempo real y datos históricos.

## 3. Fuera del Alcance
Las siguientes funcionalidades no serán incluidas en la versión inicial del proyecto, pero podrían ser consideradas para futuras versiones:
-   Integración con el sistema de historia clínica electrónica (HIS).
-   Agendamiento de citas a través del quiosco.
-   Sistema de encuestas de satisfacción al finalizar la atención.
-   Pagos en línea de copagos o facturas.
-   Autenticación de pacientes mediante documento de identidad.

## 4. Supuestos y Restricciones
-   **Supuesto:** La red del hospital es estable y proporciona la conectividad necesaria para todos los componentes del sistema.
-   **Supuesto:** Los usuarios tienen acceso a smartphones con capacidad para escanear códigos QR y navegar en la web para la funcionalidad de seguimiento móvil.
-   **Restricción:** El sistema debe ser compatible con los navegadores web modernos (Chrome, Firefox, Safari, Edge).
-   **Restricción:** El desarrollo se realizará sobre la infraestructura y stack tecnológico definido (PHP/Laravel). 