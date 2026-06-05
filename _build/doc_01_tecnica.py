"""DOCUMENTACION_TECNICA.docx - documento técnico principal."""

import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).parent))
from build_docs import (
    build_docx, title, subtitle, heading, para, bullet, numbered,
    code_block, table, divider, page_break,
)


def build():
    c = []
    c.append(title("DOCUMENTACIÓN TÉCNICA"))
    c.append(subtitle("Sistema de Gestión de Turnos - Turnero HUV"))
    c.append(para("Hospital Universitario del Valle - Innovación y Desarrollo", bold=True, align="center"))
    c.append(para("Versión 2.0 - Mayo 2026", align="center"))
    c.append(divider())

    # 1. INTRODUCCION
    c.append(heading("1. INTRODUCCIÓN", 1))
    c.append(para(
        "Este documento describe la arquitectura, componentes, modelo de datos y "
        "lineamientos técnicos del Sistema de Gestión de Turnos del Hospital "
        "Universitario del Valle (en adelante \"Turnero HUV\"). El sistema fue "
        "desarrollado por el área de Innovación y Desarrollo del HUV para "
        "modernizar la atención al paciente, eliminar las filas físicas y proveer "
        "trazabilidad operativa en tiempo real a la gerencia."
    ))
    c.append(para(
        "El documento está dirigido al equipo de Tecnologías de la Información, "
        "desarrolladores que reciban el código, integradores y personal de soporte "
        "de segundo y tercer nivel."
    ))

    c.append(heading("1.1 Alcance del sistema", 2))
    c.append(bullet("Generación de turnos vía atril táctil y módulos administrativos."))
    c.append(bullet("Atención de pacientes por parte de asesores en cajas / consultorios."))
    c.append(bullet("Visualización pública en televisores con anuncio por voz (TTS)."))
    c.append(bullet("Vista móvil para el paciente vía código QR."))
    c.append(bullet("Reportes operativos, dashboard administrativo y gráficos históricos."))
    c.append(bullet("Gestión de servicios, subservicios, cajas, multimedia y usuarios."))
    c.append(bullet("Auditoría automática de todos los cambios sobre los turnos."))
    c.append(bullet("Canal no presencial (telefónico / virtual) con tiempos por asesor."))

    c.append(heading("1.2 Convenciones", 2))
    c.append(para(
        "Los nombres en código (controladores, modelos, rutas) se mantienen en su "
        "forma original (snake_case o PascalCase) para facilitar la búsqueda dentro "
        "del repositorio."
    ))

    c.append(page_break())

    # 2. ARQUITECTURA
    c.append(heading("2. ARQUITECTURA DEL SISTEMA", 1))
    c.append(para(
        "El Turnero HUV es una aplicación web monolítica modular basada en "
        "Laravel 12 con vistas server-side renderizadas (Blade) e interactividad "
        "ligera vía Alpine.js. La comunicación en tiempo real se hace mediante "
        "broadcasting (configurable a log, Pusher o Reverb)."
    ))

    c.append(heading("2.1 Estilo arquitectónico", 2))
    c.append(bullet("Patrón MVC clásico de Laravel (Modelo - Vista - Controlador)."))
    c.append(bullet("Eventos del modelo Eloquent para auditoría automática de turnos."))
    c.append(bullet("Service Container para inyección de dependencias."))
    c.append(bullet("Middlewares para roles, sesiones y limpieza automática de cajas expiradas."))
    c.append(bullet("Patrón Repository implícito mediante Eloquent (no se usan repositorios externos)."))

    c.append(heading("2.2 Diagrama lógico de componentes", 2))
    c.append(code_block(
        "  +-----------+   HTTP/HTTPS   +-------------------+\n"
        "  |  Atril    | <-----------> |                   |\n"
        "  |  Asesor   |               |  Laravel 12       |\n"
        "  |  Admin    | <-----------> |  (Controladores)  | <----> MySQL 8 / MariaDB\n"
        "  |  TV       |               |  (Modelos)        |\n"
        "  |  Móvil    |               |  (Vistas Blade)   |\n"
        "  +-----------+               +-------------------+\n"
        "                                       |\n"
        "                                       v\n"
        "                              +-------------------+\n"
        "                              | Piper TTS local   |\n"
        "                              | (síntesis voz)    |\n"
        "                              +-------------------+\n"
    ))

    c.append(heading("2.3 Capas lógicas", 2))
    c.append(table(
        ["Capa", "Responsabilidad", "Tecnología"],
        [
            ["Presentación", "Renderizado HTML, interactividad cliente", "Blade + Alpine.js + Tailwind 4"],
            ["Aplicación", "Controladores, validación, orquestación", "Laravel 12 (PHP 8.2)"],
            ["Dominio", "Modelos Eloquent, reglas de negocio del turno", "Eloquent ORM"],
            ["Persistencia", "Almacenamiento transaccional y de auditoría", "MySQL 8 / MariaDB 10.6+"],
            ["Tiempo real", "Notificación de cambios al frontend", "Laravel Broadcasting (Pusher/Reverb)"],
            ["Voz", "Síntesis de anuncios de llamado", "Piper TTS (binario local)"],
        ],
        col_widths=[2000, 4200, 3205],
    ))

    c.append(page_break())

    # 3. STACK
    c.append(heading("3. STACK TECNOLÓGICO", 1))
    c.append(heading("3.1 Backend", 2))
    c.append(table(
        ["Componente", "Versión", "Propósito"],
        [
            ["PHP", "^8.2", "Lenguaje base"],
            ["Laravel Framework", "^12.0", "Framework principal"],
            ["Laravel Tinker", "^2.10", "REPL para mantenimiento"],
            ["barryvdh/laravel-dompdf", "^3.1", "Generación de PDFs"],
            ["phpoffice/phpspreadsheet", "^4.4", "Exportación a Excel"],
            ["pusher/pusher-php-server", "^7.2", "Broadcasting tiempo real"],
            ["simplesoftwareio/simple-qrcode", "^4.2", "Códigos QR en tickets"],
        ],
        col_widths=[3200, 1500, 4705],
    ))

    c.append(heading("3.2 Frontend", 2))
    c.append(table(
        ["Componente", "Versión", "Propósito"],
        [
            ["Tailwind CSS", "^4.0", "Sistema de estilos utilitario"],
            ["Alpine.js", "^3.14.9", "Interactividad declarativa"],
            ["Laravel Echo", "^2.1.6", "Cliente broadcasting"],
            ["Pusher JS", "^8.4.0", "Cliente WebSocket"],
            ["Vite", "^6.2.4", "Bundler de assets"],
            ["Axios", "^1.8.2", "Cliente HTTP"],
        ],
        col_widths=[2500, 1800, 5105],
    ))

    c.append(heading("3.3 Herramientas de desarrollo", 2))
    c.append(bullet("Composer 2.x para gestión de dependencias PHP."))
    c.append(bullet("Node 18+ y NPM 10+ para assets."))
    c.append(bullet("Laravel Pint (^1.13) para estilo de código PHP."))
    c.append(bullet("PHPUnit (^11.5) para pruebas."))
    c.append(bullet("Laravel Pail (^1.2) para inspección de logs en desarrollo."))
    c.append(bullet("Concurrently para el comando \"composer dev\" (serve + queue + pail + vite)."))

    c.append(page_break())

    # 4. MODELO DE DATOS
    c.append(heading("4. MODELO DE DATOS", 1))
    c.append(para(
        "El esquema se gestiona vía migraciones de Laravel en database/migrations. "
        "A continuación se describen las tablas principales y sus columnas más "
        "relevantes."
    ))

    c.append(heading("4.1 Tabla users", 2))
    c.append(para("Almacena administradores y asesores del sistema."))
    c.append(table(
        ["Columna", "Tipo", "Descripción"],
        [
            ["id", "bigint PK", "Identificador interno"],
            ["nombre_completo", "varchar", "Nombre del funcionario"],
            ["correo_electronico", "varchar", "Correo institucional"],
            ["nombre_usuario", "varchar unique", "Usuario de inicio de sesión"],
            ["cedula", "varchar unique", "Cédula del funcionario"],
            ["rol", "enum", "Administrador | Asesor"],
            ["password", "varchar (Bcrypt)", "Contraseña hasheada"],
            ["estado_asesor", "enum", "disponible | ocupado | descanso | no_disponible"],
            ["session_id", "varchar nullable", "ID de la sesión Laravel activa"],
            ["session_start", "datetime", "Inicio de sesión actual"],
            ["last_activity", "datetime", "Última interacción del usuario"],
            ["last_ip", "varchar", "Última IP de uso"],
            ["actividad_canal_no_presencial", "varchar nullable", "Actividad en curso (callcenter, virtual)"],
            ["inicio_canal_no_presencial", "datetime nullable", "Hora de inicio del canal no presencial"],
        ],
        col_widths=[3000, 2000, 4405],
    ))

    c.append(heading("4.2 Tabla servicios", 2))
    c.append(para("Catálogo jerárquico de servicios y subservicios."))
    c.append(table(
        ["Columna", "Tipo", "Descripción"],
        [
            ["id", "bigint PK", "Identificador"],
            ["nombre", "varchar", "Nombre visible"],
            ["descripcion", "text", "Descripción del servicio"],
            ["codigo", "varchar", "Prefijo del turno (ej. CIT, COP, FAC)"],
            ["nivel", "enum", "servicio | subservicio"],
            ["servicio_padre_id", "bigint nullable", "Referencia jerárquica"],
            ["estado", "enum", "activo | inactivo"],
            ["orden", "int", "Orden de presentación"],
            ["ocultar_turno", "boolean", "Si se debe ocultar el número en pantalla"],
            ["requiere_priorizacion", "boolean", "Habilita botón de priorización en atril"],
        ],
        col_widths=[3000, 2000, 4405],
    ))

    c.append(heading("4.3 Tabla cajas", 2))
    c.append(table(
        ["Columna", "Tipo", "Descripción"],
        [
            ["id", "bigint PK", "Identificador"],
            ["nombre", "varchar", "Nombre del punto (ej. Caja 1, Cons 205)"],
            ["ubicacion", "varchar", "Ubicación física"],
            ["activa", "boolean", "Disponibilidad operativa"],
            ["user_id", "bigint nullable", "Asesor actualmente asignado"],
            ["session_start", "datetime", "Inicio de la sesión en caja"],
        ],
        col_widths=[3000, 2000, 4405],
    ))

    c.append(heading("4.4 Tabla turnos (núcleo transaccional)", 2))
    c.append(table(
        ["Columna", "Tipo", "Descripción"],
        [
            ["id", "bigint PK", "Identificador interno"],
            ["codigo", "varchar", "Prefijo (ej. CIT)"],
            ["numero", "int", "Consecutivo diario por servicio"],
            ["servicio_id", "bigint FK", "Servicio solicitado"],
            ["caja_id", "bigint FK nullable", "Caja que atendió"],
            ["asesor_id", "bigint FK nullable", "Asesor que atendió"],
            ["estado", "string", "pendiente | llamado | atendido | aplazado"],
            ["prioridad", "int (1-5)", "1-3 normal, 4-5 prioritario"],
            ["fecha_creacion", "datetime", "Generación del turno"],
            ["fecha_llamado", "datetime nullable", "Momento del llamado"],
            ["fecha_atencion", "datetime nullable", "Cierre de atención"],
            ["duracion_atencion", "int (segundos)", "Tiempo real de atención"],
            ["observaciones", "text nullable", "Notas operativas"],
        ],
        col_widths=[3000, 2000, 4405],
    ))
    c.append(para(
        "El atributo accesor codigo_completo concatena código y número con padding "
        "(ej. CIT-001). Los eventos created/updated/deleting del modelo Turno "
        "generan automáticamente un registro en turno_historial.",
        italic=True,
    ))

    c.append(heading("4.5 Tablas auxiliares", 2))
    c.append(bullet("user_servicio: pivote N:M para asesores y servicios que pueden atender."))
    c.append(bullet("turno_historial: backup inmutable de cada cambio sobre turnos (auditoría)."))
    c.append(bullet("canal_no_presencial_historial: tiempos de canal telefónico/virtual por asesor."))
    c.append(bullet("multimedia: archivos (imagen/video) para reproducción en TV."))
    c.append(bullet("tv_configs: parámetros visuales del display público."))
    c.append(bullet("sessions: gestión de sesiones (driver database)."))
    c.append(bullet("cache, jobs: tablas estándar de Laravel para cache y colas."))

    c.append(page_break())

    # 5. CONTROLADORES
    c.append(heading("5. CONTROLADORES Y LÓGICA DE NEGOCIO", 1))
    c.append(para(
        "Los controladores están en app/Http/Controllers. La tabla siguiente resume "
        "su responsabilidad."
    ))
    c.append(table(
        ["Controlador", "Rol", "Responsabilidades clave"],
        [
            ["AuthController", "Auth", "Login, logout, verificación de sesión y CSRF."],
            ["AdminController", "Admin", "Dashboard, CRUD de usuarios, métricas y limpieza de sesiones."],
            ["CajaController", "Admin", "CRUD de cajas y puntos de atención."],
            ["ServicioController", "Admin", "CRUD de servicios y subservicios."],
            ["AsignacionServicioController", "Admin", "Vincula asesores con servicios que pueden atender."],
            ["TvConfigController", "Admin/Público", "Configura el display TV y expone APIs públicas."],
            ["MultimediaController", "Admin", "Subida y orden de imágenes/videos para la TV."],
            ["TurnoController", "Público", "Generación de turnos desde atril y vista móvil."],
            ["AsesorController", "Asesor", "Llamar, atender, aplazar, rellamar y canal no presencial."],
            ["GraficosController", "Admin", "Consultas agregadas para los gráficos."],
            ["ReportesController", "Admin", "Generación y exportación de reportes (PDF/Excel)."],
            ["VoiceController", "Admin/Asesor", "Validación y generación on-demand de audios TTS."],
            ["SoporteController", "Admin", "Solicitudes de soporte hacia el área de Innovación."],
        ],
        col_widths=[3000, 1400, 5005],
    ))

    c.append(heading("5.1 Flujo del turno", 2))
    c.append(numbered("Paciente o recepcionista genera el turno en el atril (TurnoController@store/inicio).", 1))
    c.append(numbered("Se asigna número consecutivo diario por servicio (Turno::siguienteNumero).", 2))
    c.append(numbered("Se imprime ticket con QR (turnos/ticket).", 3))
    c.append(numbered("Asesor selecciona caja al iniciar sesión (AsesorController@seleccionarCaja).", 4))
    c.append(numbered("Asesor presiona \"Llamar siguiente\" (AsesorController@llamarSiguienteTurno).", 5))
    c.append(numbered("Se marca como \"llamado\", se emite anuncio TTS y se actualiza la TV.", 6))
    c.append(numbered("Asesor marca \"Atendido\" (marcarAtendido) o \"Aplazado\" (aplazarTurno).", 7))
    c.append(numbered("Cada transición es replicada en turno_historial automáticamente.", 8))

    c.append(heading("5.2 Middlewares clave", 2))
    c.append(bullet("auth: protección estándar Laravel."))
    c.append(bullet("admin.role / asesor.role: control de acceso por rol."))
    c.append(bullet("update.user.activity: actualiza last_activity en cada request."))
    c.append(bullet("clean.expired.boxes: libera cajas tras cierre de sesión expirada."))
    c.append(bullet("no.session.api: evita crear sesión en APIs públicas (TV, móvil)."))

    c.append(page_break())

    # 6. APIS Y RUTAS
    c.append(heading("6. RUTAS Y APIS INTERNAS", 1))
    c.append(para(
        "El sistema no expone una API REST pública; las rutas /api/* son consumidas "
        "por las propias vistas Blade vía fetch/axios. Las rutas se definen en "
        "routes/web.php agrupadas por middleware de rol."
    ))

    c.append(heading("6.1 Rutas públicas (atril y display)", 2))
    c.append(table(
        ["Método", "Ruta", "Propósito"],
        [
            ["GET", "/", "Redirección a login"],
            ["GET", "/turnos", "Pantalla inicial del atril"],
            ["GET", "/turnos/menu", "Selección de servicio"],
            ["POST", "/turnos/seleccionar", "Generación del turno"],
            ["POST", "/turnos/crear-con-prioridad", "Generación priorizada"],
            ["GET", "/turnos/ticket/{turno}", "Vista de impresión con QR"],
            ["GET", "/tv", "Display público en TV"],
            ["GET", "/movil", "Vista móvil para paciente"],
            ["GET", "/atril", "Vista del atril"],
            ["GET", "/api/tv-config", "Configuración del TV"],
            ["GET", "/api/multimedia", "Multimedia activa"],
            ["GET", "/api/turnos-llamados", "Turnos llamados (TV)"],
            ["GET", "/api/turno-status/{turno}", "Estado puntual de un turno"],
        ],
        col_widths=[1000, 3500, 4905],
    ))

    c.append(heading("6.2 Rutas administrativas (rol Administrador)", 2))
    c.append(table(
        ["Ruta", "Propósito"],
        [
            ["/dashboard", "Dashboard principal"],
            ["/admin/usuarios", "Gestión de usuarios"],
            ["/cajas", "Gestión de cajas"],
            ["/servicios", "Gestión de servicios"],
            ["/asignacion-servicios", "Vincular asesores ↔ servicios"],
            ["/admin/turnos", "Listado de turnos del día"],
            ["/tv-config", "Configurar TV y multimedia"],
            ["/graficos", "Tablero de gráficos en tiempo real e histórico"],
            ["/reportes", "Generación de reportes"],
            ["/soporte", "Tickets de soporte"],
            ["/voice/*", "Panel del sistema de voz"],
        ],
        col_widths=[3500, 5905],
    ))

    c.append(heading("6.3 Rutas del asesor (rol Asesor)", 2))
    c.append(table(
        ["Ruta", "Propósito"],
        [
            ["/asesor/seleccionar-caja", "Pantalla de selección de caja"],
            ["/asesor/dashboard", "Tablero de atención"],
            ["/asesor/llamar-siguiente-turno", "Llamar siguiente paciente"],
            ["/asesor/llamar-turno-especifico", "Llamar turno por código"],
            ["/asesor/marcar-atendido", "Cerrar atención"],
            ["/asesor/aplazar-turno", "Aplazar turno"],
            ["/asesor/volver-llamar-turno", "Rellamar paciente ausente"],
            ["/asesor/historial-turnos", "Historial del asesor"],
            ["/asesor/iniciar-canal-no-presencial", "Iniciar atención telefónica/virtual"],
            ["/asesor/finalizar-canal-no-presencial", "Cerrar canal no presencial"],
        ],
        col_widths=[3800, 5605],
    ))

    c.append(page_break())

    # 7. SEGURIDAD
    c.append(heading("7. SEGURIDAD", 1))
    c.append(heading("7.1 Autenticación y sesión", 2))
    c.append(bullet("Driver de sesión: database (tabla sessions)."))
    c.append(bullet("Login por nombre de usuario y contraseña (Bcrypt, 12 rondas)."))
    c.append(bullet("Single Session por usuario - una nueva sesión invalida la anterior."))
    c.append(bullet("Expiración por inactividad: 15 minutos (verificado en User::tieneSessionActiva)."))
    c.append(bullet("Limpieza administrativa de sesiones: /admin/clean-sessions y similares."))

    c.append(heading("7.2 Protección de la aplicación", 2))
    c.append(bullet("Token CSRF en todos los formularios y peticiones AJAX."))
    c.append(bullet("Validación de Request usando $request->validate()."))
    c.append(bullet("Sanitización automática vía Eloquent (prevención de SQLi)."))
    c.append(bullet("Output escapado en Blade ({{ $var }}) para prevenir XSS."))
    c.append(bullet("Headers de seguridad recomendados en Nginx (X-Frame-Options, CSP, HSTS)."))

    c.append(heading("7.3 Control de acceso (RBAC)", 2))
    c.append(para(
        "El rol se almacena en users.rol (enum Administrador|Asesor). Cada grupo "
        "de rutas se protege con middleware específico (admin.role, asesor.role)."
    ))

    c.append(heading("7.4 Auditoría", 2))
    c.append(bullet("Todos los cambios de turno (created, updated, deleting) replican un registro en turno_historial."))
    c.append(bullet("El registro guarda actor, cambios, valores anteriores, motivo."))
    c.append(bullet("storage/logs/laravel.log captura excepciones."))

    c.append(page_break())

    # 8. DESPLIEGUE
    c.append(heading("8. DESPLIEGUE E INSTALACIÓN", 1))
    c.append(heading("8.1 Requisitos del servidor", 2))
    c.append(bullet("Sistema operativo: Ubuntu 22.04 LTS o Windows Server 2019/2022."))
    c.append(bullet("PHP 8.2+ con extensiones bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, pdo_mysql, tokenizer, xml, gd, zip, intl."))
    c.append(bullet("MySQL 8.0+ o MariaDB 10.6+ con charset utf8mb4."))
    c.append(bullet("Nginx (recomendado) o Apache con mod_rewrite."))
    c.append(bullet("Composer 2.x y Node 18+."))
    c.append(bullet("Python 3.10+ para Piper TTS (opcional, pero recomendado)."))
    c.append(bullet("Supervisor para mantener php artisan queue:work si se usa cola asíncrona."))

    c.append(heading("8.2 Instalación paso a paso", 2))
    c.append(code_block(
        "# 1. Clonar repositorio\n"
        "git clone <repo> turnero-huv && cd turnero-huv\n\n"
        "# 2. Dependencias\n"
        "composer install --no-dev --optimize-autoloader\n"
        "npm install && npm run build\n\n"
        "# 3. Variables de entorno\n"
        "cp .env.example .env\n"
        "php artisan key:generate\n\n"
        "# 4. Base de datos\n"
        "php artisan migrate --seed\n\n"
        "# 5. Storage symlink\n"
        "php artisan storage:link\n\n"
        "# 6. Permisos (Linux)\n"
        "chmod -R 775 storage bootstrap/cache\n"
        "chown -R www-data:www-data storage bootstrap/cache\n\n"
        "# 7. (Opcional) Piper TTS\n"
        "python3 scripts/setup_piper_tts.py"
    ))

    c.append(heading("8.3 Comandos útiles de mantenimiento", 2))
    c.append(code_block(
        "# Cache de configuración (producción)\n"
        "php artisan config:cache\n"
        "php artisan route:cache\n"
        "php artisan view:cache\n\n"
        "# Limpiar cache\n"
        "php artisan optimize:clear\n\n"
        "# Workers\n"
        "php artisan queue:work --tries=3\n\n"
        "# Logs en tiempo real (dev)\n"
        "php artisan pail"
    ))

    c.append(heading("8.4 Entorno multi-modo (.bat / .sh)", 2))
    c.append(para(
        "El repositorio incluye scripts para alternar entornos (start-local-server, "
        "start-server-network, start-server-local, switch-env) que ajustan APP_URL "
        "y arrancan el servidor embebido para uso en intranet del hospital."
    ))

    c.append(divider())
    c.append(para("FIN DEL DOCUMENTO TÉCNICO PRINCIPAL.", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - Hospital Universitario del Valle", align="center"))

    return "".join(c)


if __name__ == "__main__":
    out = build_docx("DOCUMENTACION_TECNICA", build())
    print(f"OK -> {out}")
