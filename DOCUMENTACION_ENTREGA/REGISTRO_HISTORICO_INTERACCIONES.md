# INNOVACIÓN Y DESARROLLO - HOSPITAL UNIVERSITARIO DEL VALLE
## SISTEMA DE GESTIÓN DE TURNOS (TURNERO HUV)

---

# REGISTRO HISTÓRICO DE INTERACCIONES Y CONTROL DE CAMBIOS

### TABLA DE CONTENIDOS

1. [Propósito del Documento](#1-propósito-del-documento)
2. [Historial de Versiones del Sistema](#2-historial-de-versiones-del-sistema)
3. [Registro de Reuniones de Seguimiento (Bitácora)](#3-registro-de-reuniones-de-seguimiento-bitácora)
4. [Control de Solicitudes de Cambio (RFC)](#4-control-de-solicitudes-de-cambio-rfc)
5. [Historial de Despliegues en Producción](#5-historial-de-despliegues-en-producción)
6. [Registro de Auditoría de Seguridad](#6-registro-de-auditoría-de-seguridad)

---

## 1. PROPÓSITO DEL DOCUMENTO

Este documento sirve como la fuente oficial de verdad respecto a la evolución cronológica del proyecto **Turnero HUV**. Registra todas las interacciones significativas entre el equipo de Desarrollo (Innovación) y los Interesados (Stakeholders/Áreas Médicas), así como los cambios técnicos, hitos alcanzados y decisiones arquitectónicas tomadas a lo largo del ciclo de vida del software.

El objetivo es garantizar la trazabilidad completa, transparencia y gestión del conocimiento para futuros mantenimientos o auditorías.

---

## 2. HISTORIAL DE VERSIONES DEL SISTEMA

| Versión | Fecha de Lanzamiento | Tipo | Descripción General | Cambios Principales |
| :--- | :--- | :--- | :--- | :--- |
| **v1.0.0** | 01/06/2025 | Major | **Lanzamiento Inicial (MVP)** | - Gestión básica de turnos.<br>- Roles Admin y Asesor.<br>- TV Display básico. - Base de datos inicial. |
| **v1.1.0** | 15/06/2025 | Minor | **Módulo de Reportes** | - Agregado dashboard de estadísticas.<br>- Exportación a Excel.<br>- Corrección de bugs en login. |
| **v1.2.0** | 01/07/2025 | Minor | **Multimedia y TV** | - Publicidad en TV.<br>- Configuración de kleuren.<br>- Scrolling text. |
| **v1.5.0** | 01/08/2025 | Major | **Sistema de Audio TTS** | - Implementación de Piper TTS (Local).<br>- Eliminación de dependencia de internet para voz.<br>- Voces neuronales. |
| **v1.8.0** | 01/10/2025 | Minor | **Optimización Móvil** | - Vista responsiva para pacientes (QR).<br>- WebSockets optimizados para 3G/4G. |
| **v2.0.0** | 01/01/2026 | Major | **Versión Estable 2026** | - Refactorización a Laravel 12.<br>- Integración con Directorio Activo (LDAP).<br>- Soporte multicaja avanzado. |
| **v2.1.0-beta** | 06/02/2026 | Patch | **Actualización Seguridad** | - Parches de dependencias.<br>- Ajustes en documentación. |

---

## 3. REGISTRO DE REUNIONES DE SEGUIMIENTO (BITÁCORA)

Registro de interacciones clave con las áreas usuarias para definición de alcance.

### Reunión #001: Levantamiento de Requerimientos
*   **Fecha:** 10/01/2025
*   **Asistentes:** Líder Desarrollo, Jefe de Atención al Usuario, Coordinador TI.
*   **Temas Tratados:**
    *   Problemática actual de colas físicas desordenadas.
    *   Necesidad de priorizar adultos mayores y urgencias.
    *   Requerimiento de pantallas visibles en salas A y B.
*   **Acuerdos:**
    *   Se desarrollará sistema web (sin instalación en clientes).
    *   Se usarán televisores existentes.
    *   Plazo estimado MVP: 3 meses.

### Reunión #005: Revisión de Prototipo (UI/UX)
*   **Fecha:** 25/02/2025
*   **Asistentes:** Equipo Diseno, Enfermeras Jefes.
*   **Temas Tratados:**
    *   Validación de tamaños de letra en pantalla TV (deben ser legibles a 10 metros).
    *   Validación de colores (Contraste alto para accesibilidad).
*   **Acuerdos:**
    *   Aumentar tamaño de fuente del número del turno en 20%.
    *   Cambiar sonido de timbre por uno menos "agresivo".

### Reunión #012: Pruebas de Carga (Stress Testing)
*   **Fecha:** 20/05/2025
*   **Asistentes:** Infraestructura, Desarrollo.
*   **Temas Tratados:**
    *   Simulación de 500 pacientes concurrentes.
    *   Evaluación de red Wi-Fi.
*   **Resultados:**
    *   El servidor respondió bien.
    *   Cuello de botella identificado en la red Wi-Fi de sala de espera.
*   **Decisiones:**
    *   Conectar PCs de asesores por cable obligatoriamente.

---

## 4. CONTROL DE SOLICITUDES DE CAMBIO (RFC)

Gestión de cambios solicitados post-congelación de alcance.

| RFC ID | Fecha | Solicitante | Descripción del Cambio | Impacto | Estado | Aprobado Por |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **RFC-001** | 05/07/2025 | Farmacia | Agregar campo "Número de Fórmula" al crear turno. | Medio (Requiere migración DB y cambio en vistas). | **Rechazado** | Gerencia TI (Por complejidad innecesaria en kiosco). |
| **RFC-002** | 20/08/2025 | Calidad | Reporte específico de tiempos por médico. | Bajo (Solo query nueva). | **Aprobado** | Líder Proyecto. |
| **RFC-003** | 10/11/2025 | Admisiones | Integración con HIS (Sistema Hospitalario) para validar cédulas. | Alto (Requiere Web Services externos). | **Pospuesto** | Para Fase 3. |

---

## 5. HISTORIAL DE DESPLIEGUES EN PRODUCCIÓN

Registro de intervenciones en servidor productivo.

*   **Despliegue Inicial:** 01/06/2025 - Éxito total. Ventana de mantenimiento 2 horas.
*   **Hotfix 1.0.1:** 03/06/2025 - Corrección urgente. Los tickets salían con la hora incorrecta (Timezone fix).
*   **Mantenimiento Programado:** 15/09/2025 - Actualización de SO del servidor y base de datos. Downtime planificado de 10pm a 12am.
*   **Migración Storage:** 20/01/2026 - Ampliación de disco duro para almacenar videos promocionales 4K.

---

## 6. REGISTRO DE AUDITORÍA DE SEGURIDAD

Eventos relacionados con la seguridad de la información.

*   **15/03/2025:** Análisis de vulnerabilidades estático (SonarQube). Resultado: 5 vulnerabilidades bajas corregidas.
*   **01/06/2025:** Hacking Ético interno. Se recomendó deshabilitar debug mode (Realizado).
*   **10/12/2025:** Intento de fuerza bruta detectado en login de admin.
    *   *Acción:* Se implementó limitador de tasa (Rate Limiting) y bloqueo de IP tras 5 intentos fallidos.

---

**FIN DEL REGISTRO HISTÓRICO**
**INNOVACIÓN Y DESARROLLO - HUV**
