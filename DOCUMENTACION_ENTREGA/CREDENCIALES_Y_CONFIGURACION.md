# INNOVACIÓN Y DESARROLLO - HOSPITAL UNIVERSITARIO DEL VALLE
## SISTEMA DE GESTIÓN DE TURNOS (TURNERO HUV)

---

# CREDENCIALES Y CONFIGURACIÓN DEL SISTEMA

### TABLA DE CONTENIDOS

1. [Introducción](#1-introducción)
2. [Requisitos del Servidor](#2-requisitos-del-servidor)
3. [Variables de Entorno (.env)](#3-variables-de-entorno-env)
    - [Configuración de Aplicación](#31-configuración-de-aplicación)
    - [Configuración de Base de Datos](#32-configuración-de-base-de-datos)
    - [Configuración de Cache y Sesiones](#33-configuración-de-cache-y-sesiones)
    - [Configuración de WebSockets (Pusher)](#34-configuración-de-websockets-pusher)
    - [Configuración de Sistema de Archivos](#35-configuración-de-sistema-de-archivos)
4. [Credenciales Administrativas Iniciales](#4-credenciales-administrativas-iniciales)
5. [Configuración de Servicios Externos](#5-configuración-de-servicios-externos)
    - [Google Text-to-Speech](#51-google-text-to-speech)
    - [Piper TTS (Local)](#52-piper-tts-local)
6. [Configuración de Hardware Recomendado](#6-configuración-de-hardware-recomendado)
    - [Servidor](#61-servidor)
    - [Terminales de Asesores](#62-terminales-de-asesores)
    - [Pantallas de Visualización](#63-pantallas-de-visualización)
    - [Sistema de Audio](#64-sistema-de-audio)
7. [Matriz de Puertos y Red](#7-matriz-de-puertos-y-red)
8. [Políticas de Seguridad y Acceso](#8-políticas-de-seguridad-y-acceso)
9. [Gestión de Backups y Restauración](#9-gestión-de-backups-y-restauración)

---

## 1. INTRODUCCIÓN

Este documento detalla exhaustivamente la configuración técnica, credenciales, y parámetros de entorno necesarios para el despliegue, operación y mantenimiento del **Sistema de Gestión de Turnos del Hospital Universitario del Valle (Turnero HUV)**. 

El sistema ha sido diseñado por el área de Innovación y Desarrollo para operar en una infraestructura crítica hospitalaria, por lo cual la correcta configuración de estos parámetros es vital para garantizar la alta disponibilidad (99.9%), la seguridad de los datos de los pacientes y la fluidez en la atención.

La información contenida aquí es estrictamente confidencial y debe ser manejada únicamente por el personal autorizado del área de TI e Innovación y Desarrollo del HUV.

---

## 2. REQUISITOS DEL SERVIDOR

Para garantizar el funcionamiento óptimo de la aplicación basada en Laravel 12 y tecnologías en tiempo real, el servidor host debe cumplir con las siguientes especificaciones de software y librerías.

### 2.1. Sistema Operativo
- **Recomendado:** Linux (Ubuntu 22.04 LTS o superior / Debian 11+).
- **Compatible:** Windows Server 2019/2022 (requiere configuración manual de servicios PHP y Workers).
- **Arquitectura:** x64.

### 2.2. Entorno PHP
- **Versión:** PHP 8.2 o superior.
- **Extensiones Requeridas:**
    - `BCMath` (Para cálculos precisos de tiempos y estadísticas).
    - `Ctype` (Validación de tipos de caracteres).
    - `Fileinfo` (Gestión de archivos multimedia para TV).
    - `JSON` (Manejo de respuestas API).
    - `Mbstring` (Manejo de cadenas multibyte).
    - `OpenSSL` (Seguridad y encriptación).
    - `PDO` (Conexión a base de datos).
    - `Tokenizer` (Parseo de código).
    - `XML` (Procesamiento de datos).
    - `GD` o `Imagick` (Procesamiento de imágenes y QR).
    - `ZIP` (Generación de reportes comprimidos y actualizaciones).
    - `Intl` (Formateo de fechas y números locales).
    - `SQLite3` (Si se usa SQLite como base de datos local o de pruebas).
    - `MySQLi` / `PDO_MySQL` (Para conexión a MySQL/MariaDB en producción).

### 2.3. Base de Datos
- **Motor:** MySQL 8.0+ o MariaDB 10.6+.
- **Configuración:** Soporte para transacciones ACID, codificación `utf8mb4_unicode_ci`.

### 2.4. Servidor Web
- **Nginx:** Recomendado para producción por su manejo eficiente de concurrencia.
    - Configuración requerida para URLs amigables (Pretty URLs).
    - Configuración de headers de seguridad.
- **Apache:** Compatible con módulo `mod_rewrite` habilitado.

### 2.5. Herramientas Adicionales
- **Composer:** Gestor de dependencias de PHP (Versión 2.0+).
- **Node.js & NPM:** Para compilación de assets frontend (Node 18+).
- **Python 3:** Para ejecución de scripts de generación de voz (Piper TTS / Scripts auxiliares). 
- **Supervisor:** Para la gestión de procesos en segundo plano (Colas, WebSockets).

---

## 3. VARIABLES DE ENTORNO (.env)

El archivo `.env` es el corazón de la configuración de la aplicación. A continuación se describe cada variable crítica y su propósito dentro de la infraestructura del HUV.

### 3.1. Configuración de Aplicación

Estas variables definen la identidad del entorno de la aplicación.

```ini
APP_NAME="Turnero HUV"
APP_ENV=production
APP_KEY=base64:Xk9... (LLAVE PRIVADA DE ENCRIPTACION - NO COMPARTIR)
APP_DEBUG=false
APP_URL=http://turnos.huv.gov.co
APP_TIMEZONE="America/Bogota"
APP_LOCALE=es
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=es_ES
```

*   **APP_NAME**: Identificador visible en correos y títulos.
*   **APP_ENV**: Debe estar en `production` para evitar fugas de información de depuración.
*   **APP_KEY**: Si esta llave se pierde, los datos encriptados (sesiones, cookies) no podrán recuperarse.
*   **APP_DEBUG**: `false` en producción obligatoriamente.

### 3.2. Configuración de Base de Datos

Conexión al servidor de base de datos corporativo.

```ini
DB_CONNECTION=mysql
DB_HOST=192.168.X.X
DB_PORT=3306
DB_DATABASE=turnero_huv_db
DB_USERNAME=turnero_user
DB_PASSWORD=***************
```

Recomendaciones:
- El usuario de base de datos debe tener permisos solo sobre la base de datos `turnero_huv_db`.
- Se recomienda el uso de usuarios dedicados, no usar `root`.

### 3.3. Configuración de Cache y Sesiones

Para un alto rendimiento en el HUV, se recomienda usar Redis si está disponible.

```ini
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_STORE=database
QUEUE_CONNECTION=database
```

- **SESSION_DRIVER**: `database` permite gestionar sesiones activas y forzar cierres de sesión desde el panel administrativo, funcionalidad clave para seguridad.
- **QUEUE_CONNECTION**: `database` permite manejar trabajos en segundo plano (generación de reportes, envío de correos) sin bloquear la interfaz de usuario.

### 3.4. Configuración de WebSockets (Pusher / Reverb)

El sistema utiliza WebSockets para actualizar las pantallas de TV y los paneles de asesores en tiempo real sin necesidad de recargar la página.

```ini
BROADCAST_CONNECTION=pusher

PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_HOST=127.0.0.1
PUSHER_PORT=8080
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

El proyecto puede usar un servidor WebSocket local (Laravel Reverb o soketi) para no depender de internet externo, lo cual es ideal para la intranet del hospital.

### 3.5. Configuración de Sistema de Archivos

```ini
FILESYSTEM_DISK=public
```

Esto asegura que los archivos multimedia subidos (videos institucionales, imágenes para el TV) sean accesibles públicamente en la red interna.

---

## 4. CREDENCIALES ADMINISTRATIVAS INICIALES

Tras la instalación inicial (`php artisan db:seed`), el sistema crea una cuenta de "Super Administrador". Esta cuenta tiene acceso total y no puede ser eliminada, solo desactivada.

| Rol | Usuario (Email) | Contraseña Inicial | Nivel de Acceso |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@huv.gov.co` | `password` | **TOTAL** (Configuración, Usuarios, Reportes, Sistema) |

> **IMPORTANTE:** Esta contraseña DEBE ser cambiada inmediatamente después del primer inicio de sesión.

El sistema permite la creación de otros roles:
1.  **Administrador**: Acceso a configuración y reportes.
2.  **Asesor**: Acceso a módulo de atención y llamado.
3.  **Visualizador**: Acceso solo a pantallas y estadísticas (sin interacción).

---

## 5. CONFIGURACIÓN DE SERVICIOS EXTERNOS

### 5.1. Google Text-to-Speech (Opcional)

Si se desea usar la voz neuronal de alta calidad de Google Cloud para los llamados.

1.  Crear proyecto en Google Cloud Console.
2.  Habilitar API "Cloud Text-to-Speech".
3.  Crear cuenta de servicio y descargar JSON de credenciales.
4.  Colocar el JSON en la ruta segura configurada en `GOOGLE_APPLICATION_CREDENTIALS`.

### 5.2. Piper TTS (Local - Recomendado)

El sistema incluye integración con Piper TTS para síntesis de voz offline, reduciendo latencia y dependencia de internet.

- **Ruta de Modelos:** `tools/piper/`
- **Modelo Configurado:** `es_ES-davefx-medium.onnx` (Voz en español estándar, clara y fuerte).
- **Script de Ejecución:** `scripts/setup_piper_tts.py`

Verificar permisos de ejecución en los archivos binarios de Piper dentro de la carpeta `tools`.

---

## 6. CONFIGURACIÓN DE HARDWARE RECOMENDADO

### 6.1. Servidor
- **CPU:** 4 Cores (Intel Xeon / AMD EPYC de generación reciente).
- **RAM:** 8 GB mínimo (16 GB recomendado para manejar múltiples conexiones WebSocket).
- **Almacenamiento:** SSD NVMe 256 GB (Para bases de datos y caché rápida).
- **Red:** Interfaz Gigabit Ethernet dedicada.

### 6.2. Terminales de Asesores
- **Navegador:** Google Chrome, Firefox o Edge (Últimas versiones).
- **Resolución:** 1366x768 o superior.
- **Audio:** No requerido (el audio sale por el sistema de TV o altavoces generales).

### 6.3. Pantallas de Visualización (Smart TV / TV Box)
- **Dispositivo:** Android TV Box, Mini PC o Smart TV con navegador moderno.
- **Conectividad:** Cableada (Ethernet) recomendada sobre Wi-Fi para evitar interrupciones en streaming de video.
- **Resolución:** Full HD (1920x1080) para asegurar legibilidad de los turnos a distancia.
- **Modo Kiosco:** Configurar navegador en modo pantalla completa sin barras de dirección.

### 6.4. Sistema de Audio
- El servidor o la PC que proyecta la pantalla de turnos debe estar conectada al sistema de megafonía o altavoces de la sala de espera.
- Se recomienda usar una salida de línea (Line-Out) balanceada si la distancia al amplificador es larga.

---

## 7. MATRIZ DE PUERTOS Y RED

Para la correcta comunicación dentro de la VLAN del hospital, los siguientes puertos deben estar abiertos en el firewall interno.

| Servicio | Puerto | Protocolo | Dirección | Descripción |
| :--- | :--- | :--- | :--- | :--- |
| **HTTP** | 80 | TCP | Entrada | Acceso web general |
| **HTTPS** | 443 | TCP | Entrada | Acceso web seguro (Recomendado) |
| **Base de Datos** | 3306 | TCP | Salida/Local | Conexión a MySQL |
| **WebSockets** | 6001/8080 | TCP | Entrada | Comunicación en tiempo real (Pusher) |
| **SSH** | 22 | TCP | Entrada | Administración remota del servidor |

---

## 8. POLÍTICAS DE SEGURIDAD Y ACCESO

### 8.1. Control de Sesiones
- El sistema implementa "Single Session" por defecto para asesores de caja lógica. Si un asesor inicia sesión en otra terminal, la sesión anterior se invalida.
- Tiempo de expiración de sesión inactiva: 120 minutos (Configurable).

### 8.2. Logs y Auditoría
- Todas las acciones críticas (Crear usuario, Borrar turno, Cambiar configuración) quedan registradas en `storage/logs/laravel.log` y en la tabla de auditoría interna si está activada.
- Se recomienda configurar rotación de logs diaria.

### 8.3. Protección de Datos (Habeas Data)
- Aunque el sistema muestra nombres de pacientes, se recomienda usar solo primer nombre y apellido o iniciales configurables en el panel de administración para cumplir con normativas de privacidad si la pantalla es visible desde áreas públicas externas.

---

## 9. GESTIÓN DE BACKUPS Y RESTAURACIÓN

### 9.1. Estrategia de Copias de Seguridad
Se recomienda implementar un script cron que ejecute:

1.  **Dump de Base de Datos:** `mysqldump` diario a las 00:00 horas.
2.  **Copia de Archivos de Config:** Respaldo de `.env` y carpeta `storage/app/public` (multimedia).

### 9.2. Plan de Recuperación ante Desastres (DRP)
En caso de falla catastrófica del servidor:

1.  Aprovisionar nuevo servidor con requisitos (Punto 2).
2.  Clonar repositorio del código fuente.
3.  Restaurar archivo `.env` desde backup seguro.
4.  Restaurar base de datos desde último dump SQL.
5.  Ejecutar `composer install` y `npm install && npm run build`.
6.  Verificar permisos de carpetas (`chmod -R 775 storage bootstrap/cache`).

---

**FIN DEL DOCUMENTO DE CREDENCIALES Y CONFIGURACIÓN**
**INNOVACIÓN Y DESARROLLO - HUV**
