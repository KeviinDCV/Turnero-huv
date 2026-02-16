# INNOVACIÓN Y DESARROLLO - HOSPITAL UNIVERSITARIO DEL VALLE
## SISTEMA DE GESTIÓN DE TURNOS (TURNERO HUV)

---

# ACTA DE ENTREGA FINAL

**FECHA:** 06 de Febrero de 2026
**LUGAR:** Hospital Universitario del Valle
**PROYECTO:** Sistema de Gestión de Turnos (Turnero HUV)

---

### 1. OBJETO DEL ACTA

El presente documento tiene por objeto formalizar la entrega y aceptación del software denominado **"SISTEMA DE GESTIÓN DE TURNOS HUV"**, desarrollado por el área de **INNOVACIÓN Y DESARROLLO**, a favor del **HOSPITAL UNIVERSITARIO DEL VALLE** (en adelante "LA ENTIDAD"), representado por las áreas operativas beneficiarias.

Con la firma (simbólica) de este documento, se certifica que el sistema ha sido instalado, configurado y probado, cumpliendo con los requerimientos funcionales y técnicos establecidos en la fase de planificación.

---

### 2. DETALLE DE LOS ENTREGABLES

El área de Innovación y Desarrollo hace entrega de los siguientes componentes:

#### A. Componentes de Software (Código Fuente y Ejecutables)
1.  **Código Fuente Completo:** Repositorio actualizado del proyecto (Laravel Framework v12.0), incluyendo controladores, modelos, vistas y archivos de configuración.
2.  **Base de Datos:** Scripts de migración y seeds para la estructura inicial de la base de datos (MySQL/MariaDB).
3.  **Módulos Funcionales Operativos:**
    *   Módulo de Autenticación y Seguridad.
    *   Módulo de Administración (Dashboard, Usuarios, Servicios).
    *   Módulo de Asesor/Caja (Atención, Llamado, Gestión).
    *   Módulo de Visualización Pública (TV Display con Multimedia).
    *   Módulo de Reportes y Exportación de Datos.
    *   Sistema de Generación de Voz (TTS) integrado.
4.  **Scripts de Automatización:** Scripts Python y Batch para tareas de mantenimiento y generación de audios.

#### B. Documentación
1.  **Manual de Usuario:** Guías paso a paso para todos los roles.
2.  **Documentación Técnica:** Descripción de arquitectura, base de datos y despliegue.
3.  **Credenciales y Configuración:** Información sensible para administración.
4.  **Material de Entrenamiento:** Recursos pedagógios para capacitación.

#### C. Transferencia de Conocimiento
1.  Capacitación realizada a los líderes de área (Train the Trainers).
2.  Sesión de inducción técnica al equipo de Soporte IT para resolución de incidentes nivel 1.

---

### 3. CRITERIOS DE ACEPTACIÓN VERIFICADOS

Se declara que el sistema ha superado las siguientes pruebas de aceptación:

*   [x] **Funcionalidad:** El sistema permite el ciclo completo de un turno (Generar -> Esperar -> Llamar -> Atender -> Finalizar) sin errores bloqueantes.
*   [x] **Estabilidad:** El sistema operó de manera continua durante el periodo de marcha blanca (piloto) de 15 días sin caídas críticas.
*   [x] **Seguridad:** Los accesos están protegidos por contraseña encriptada y sistema de roles. No se exponen datos sensibles en la vista pública.
*   [x] **Rendimiento:** El tiempo de respuesta de las acciones comunes es inferior a 2 segundos en la red interna.
*   [x] **Integridad de Datos:** Los reportes generados coinciden con los registros transaccionales de prueba.

---

### 4. GARANTÍA Y SOPORTE

El área de Innovación y Desarrollo se compromete a brindar soporte post-implementación bajo los siguientes términos:

1.  **Periodo de Garantía:** 12 meses a partir de la fecha de esta acta.
    *   Cubre: Errores de programación (bugs) no detectados en pruebas, fallos de seguridad.
    *   No cubre: Nuevos requerimientos, fallos de hardware, mal uso del sistema, problemas de red ajenos al software.
2.  **Niveles de Servicio (SLA):**
    *   Critico (Sistema caído): Respuesta < 2 horas.
    *   Alto (Funcionalidad principal fallando): Respuesta < 8 horas.
    *   Medio/Bajo (Consultas, errores cosméticos): Respuesta < 48 horas.

---

### 5. OBSERVACIONES Y RESTRICCIONES

1.  El sistema requiere conexión estable a la red LAN del hospital para funcionar correctamente.
2.  La calidad del audio de los llamados depende del hardware (altavoces) instalado en las salas, lo cual es responsabilidad de mantenimiento físico.
3.  Cualquier modificación al código fuente realizada por personal ajeno a Innovación y Desarrollo anula la garantía de estabilidad aquí descrita.
4.  Los respaldos (backups) de la información son responsabilidad del área de Operaciones TI, siguiendo las políticas definidas en el documento de configuración.

---

### 6. CIERRE

Habiendo verificado el cumplimiento de lo acordado, se da por recibido el proyecto a entera satisfacción.

El sistema pasa de estado "EN DESARROLLO" a estado "EN PRODUCCIÓN Y MANTENIMIENTO".

---
**POR INNOVACIÓN Y DESARROLLO**
*Hospital Universitario del Valle*

*(Firma Digital / Aprobación del Sistema)*

---
**POR EL CLIENTE (ÁREAS ASISTENCIALES)**
*Hospital Universitario del Valle*

*(Firma Digital / Aprobación del Sistema)*

---
**FECHA DE SUSCRIPCIÓN:** 06 de Febrero de 2026
**CIUDAD:** Santiago de Cali, Valle del Cauca

