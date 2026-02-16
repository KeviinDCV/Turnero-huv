# INNOVACIÓN Y DESARROLLO - HOSPITAL UNIVERSITARIO DEL VALLE
## SISTEMA DE GESTIÓN DE TURNOS (TURNERO HUV)

---

# MANUAL DE USUARIO

### TABLA DE CONTENIDOS

1. [Introducción](#1-introducción)
2. [Acceso al Sistema](#2-acceso-al-sistema)
3. [Perfil: Administrador](#3-perfil-administrador)
    - [Dashboard General](#31-dashboard-general)
    - [Gestión de Usuarios](#32-gestión-de-usuarios)
    - [Configuración de Servicios](#33-configuración-de-servicios)
    - [Configuración de Puntos de Atención (Cajas)](#34-configuración-de-puntos-de-atención-cajas)
    - [Gestión de Multimedia TV](#35-gestión-de-multimedia-tv)
    - [Reportes y Estadísticas](#36-reportes-y-estadísticas)
4. [Perfil: Asesor / Médico](#4-perfil-asesor-médico)
    - [Inicio de Turno](#41-inicio-de-turno)
    - [Llamado de Pacientes](#42-llamado-de-pacientes)
    - [Gestión de la Atención](#43-gestión-de-la-atención)
    - [Pausas y Finalización](#44-pausas-y-finalización)
5. [Perfil: Visualizador (Pantalla TV)](#5-perfil-visualizador-pantalla-tv)
6. [Módulo de Autogestión (Kiosco / Recepción)](#6-módulo-de-autogestión-kiosco-recepción)
7. [Solución de Problemas Comunes](#7-solución-de-problemas-comunes)

---

## 1. INTRODUCCIÓN

Bienvenido al Manual de Usuario del **Sistema de Gestión de Turnos HUV**. Esta guía está diseñada para acompañar a todo el personal del Hospital Universitario del Valle en el uso correcto de la plataforma.

El sistema tiene como objetivo agilizar el flujo de pacientes, reducir el estrés en las salas de espera y proveer herramientas modernas de gestión para el personal asistencial y administrativo.

---

## 2. ACCESO AL SISTEMA

### URL de Acceso
Abra su navegador web (Google Chrome recomendado) e ingrese a la dirección proporcionada por el equipo de TI (ej. `http://turnos.huv.gov.co`).

### Pantalla de Login
Verá una pantalla con el logo del HUV. Ingrese sus credenciales institucionales:
-   **Correo Electrónico:** Su email corporativo.
-   **Contraseña:** Su clave asignada.

Si es su primer ingreso, el sistema le solicitará cambiar la contraseña por una segura.

---

## 3. PERFIL: ADMINISTRADOR

El administrador tiene control total sobre la configuración del sistema.

### 3.1. Dashboard General
Al ingresar, verá el panel de control principal con métricas en tiempo real:
-   **Turnos en Espera:** Total de pacientes aguardando.
-   **Turnos Atendidos:** Contador diario.
-   **Tiempo Promedio de Espera:** Indicador crítico de calidad.
-   **Asesores Activos:** Personal conectado actualmente.

### 3.2. Gestión de Usuarios
En el menú lateral, seleccione **Usuarios**.
-   **Crear Usuario:** Botón "Nuevo Usuario". Complete nombre, correo, rol (Admin/Asesor) y contraseña temporal.
-   **Editar:** Modifique datos si un funcionario cambia de área.
-   **Inactivar:** Si un funcionario se retira, cambie su estado a "Inactivo" para revocar acceso sin perder el historial.

### 3.3. Configuración de Servicios
Los servicios definen las colas de atención (ej. "Laboratorio", "Facturación", "Medicina General").
-   Vaya a **Configuración > Servicios**.
-   **Código:** Use abreviaturas de 2-3 letras (ej. LAB). Esto aparecerá en el ticket (LAB-001).
-   **Nombre:** Nombre visible para el paciente.
-   **Prioridad:** Define si este servicio "salta" la cola general (Útil para Urgencias o Preferencial).

### 3.4. Configuración de Puntos de Atención (Cajas)
Defina los lugares físicos de atención.
-   Vaya a **Configuración > Cajas/Consultorios**.
-   Cree registros correspondientes a la realidad física (ej. "Ventanilla 1", "Consultorio 205").
-   Puede asignar cajas específicas a servicios específicos (ej. Ventanilla 1 solo atiende Facturación).

### 3.5. Gestión de Multimedia TV
Controle lo que ven los pacientes en las pantallas de la sala de espera.
-   Vaya a **TV Config**.
-   **Mensaje Rodante:** Escriba avisos importantes (ej. "Recuerde tener su documento a la mano").
-   **Cargar Multimedia:** Suba imágenes (.jpg, .png) o videos (.mp4) institucionales.
-   **Orden:** Arrastre y suelte para definir el orden de reproducción.

### 3.6. Reportes y Estadísticas
Herramienta vital para la toma de decisiones.
-   **Reporte Diario:** Resumen ejecutivo del día.
-   **Reporte por Asesor:** Evalúe el rendimiento individual (tiempos de atención, cantidad de pacientes).
-   **Exportar:** Use los botones "Excel" o "PDF" para descargar la data y trabajarla externamente.

---

## 4. PERFIL: ASESOR / MÉDICO

Este perfil está diseñado para ser rápido y eficiente.

### 4.1. Inicio de Turno
1.  Inicie sesión.
2.  El sistema le pedirá **Seleccionar Caja/Servicio**. Elija el punto físico donde se encuentra (ej. "Consultorio 1").
3.  Presione "Iniciar Atención".

### 4.2. Llamado de Pacientes
En su panel principal verá el botón gigante **LLAMAR SIGUIENTE**.
-   Al presionarlo, el sistema busca inteligentemente el siguiente turno según prioridad y orden de llegada.
-   En la TV de la sala sonará el timbre y la voz indicando: *"Paciente con turno A-005, pasar a Consultorio 1"*.
-   El estado del turno cambia a "Llamado".

### 4.3. Gestión de la Atención
Cuando el paciente llega a su sitio:
1.  Presione **INICIAR ATENCIÓN**. El cronómetro de "Tiempo de Atención" comienza a correr.
2.  Verifique los datos del paciente.
3.  Realice el procedimiento médico o administrativo normal.

### 4.4. Pausas y Finalización
-   Al terminar con el paciente, presione **FINALIZAR**. El sistema queda listo para llamar al siguiente.
-   **Pausa Activa:** Si necesita ir al baño o tomar un descanso, presione el botón "Pausa". Esto evita que el sistema le asigne turnos o lo muestre como disponible en reportes de tiempo real.

**Opciones Adicionales:**
-   **Re-llamar:** Si el paciente no aparece, puede presionar el ícono de bocina para repetir el anuncio de voz.
-   **Ausente:** Si tras 3 llamados no aparece, marque como "No Asistió".

---

## 5. PERFIL: VISUALIZADOR (PANTALLA TV)

Este perfil no requiere interacción humana constante.
1.  En el Smart TV o PC conectado a la pantalla, inicie sesión con el usuario designado (ej. `tv@huv.gov.co`).
2.  El sistema detectará el rol y redireccionará automáticamente a la vista pública.
3.  **Modo Pantalla Completa:** Presione F11 en el teclado para ocultar bordes.
4.  Si se va la luz o internet, al volver, simplemente refresque la página (F5). El sistema recuperará el estado automáticamente.

---

## 6. MÓDULO DE AUTOGESTIÓN (KIOSCO / RECEPCIÓN)

Punto donde se generan los turnos.
-   Puede ser operado por un recepcionista o ser una pantalla táctil para el paciente (Totem).
-   **Interfaz:** Botones grandes con los Servicios disponibles.
-   **Proceso:**
    1.  Tocar el Servicio deseado (ej. "Citas Médicas").
    2.  (Opcional) Digitar Cédula.
    3.  **Impresión:** La impresora térmica entregará un ticket con el turno (ej. MED-042), la hora y un código QR para seguimiento móvil.

---

## 7. SOLUCIÓN DE PROBLEMAS COMUNES

| Problema | Causa Probable | Solución |
| :--- | :--- | :--- |
| **No sale audio en la TV** | Volumen bajo o navegador bloqueó reproducción automática. | Verificar volumen del TV. Hacer clic en cualquier parte de la pantalla de TV para habilitar el audio del navegador. |
| **"Error de Conexión"** | Pérdida de red o Wi-Fi inestable. | Verificar cable Ethernet. Refrescar página (F5) cuando vuelva la red. |
| **Impresora no saca ticket** | Papel atascado o falta de papel. | Verificar hardware de impresora. Revisar si el servicio de impresión del PC está activo. |
| **Sistema lento** | Muchos usuarios o red saturada. | Contactar a TI para verificar ancho de banda. |
| **No puedo llamar turno** | No ha seleccionado caja. | Cerrar sesión y volver a entrar seleccionando correctamente la caja. |

---

**FIN DEL MANUAL DE USUARIO**
**INNOVACIÓN Y DESARROLLO - HUV**
