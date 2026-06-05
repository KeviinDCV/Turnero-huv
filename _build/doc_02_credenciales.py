"""CREDENCIALES_Y_CONFIGURACION.docx"""

import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).parent))
from build_docs import (
    build_docx, title, subtitle, heading, para, bullet, numbered,
    code_block, table, divider, page_break,
)


def build():
    c = []
    c.append(title("CREDENCIALES Y CONFIGURACIÓN"))
    c.append(subtitle("Sistema de Gestión de Turnos - Turnero HUV"))
    c.append(para("Documento de uso interno - Confidencial", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - HUV - Mayo 2026", align="center"))
    c.append(divider())

    # 1. INTRODUCCION
    c.append(heading("1. INTRODUCCIÓN", 1))
    c.append(para(
        "Este documento detalla las credenciales por defecto, variables de entorno "
        "y parámetros de infraestructura necesarios para desplegar, operar y "
        "mantener el Sistema de Gestión de Turnos del Hospital Universitario del "
        "Valle. Es información sensible: debe almacenarse en un repositorio "
        "controlado y compartirse únicamente con personal autorizado del área de "
        "TI e Innovación y Desarrollo."
    ))
    c.append(para(
        "Las credenciales que aquí se listan corresponden al estado inicial del "
        "sistema tras ejecutar php artisan db:seed. Todas deben rotarse antes de "
        "poner el sistema en producción.",
        bold=True,
    ))

    # 2. CREDENCIALES POR DEFECTO
    c.append(heading("2. CREDENCIALES POR DEFECTO (POST-SEED)", 1))
    c.append(para(
        "El seeder UserSeeder (database/seeders/UserSeeder.php) crea dos cuentas "
        "iniciales. Si se ejecuta AsesoresSeeder se crean 15 asesores adicionales "
        "con contraseña común. Cambiar inmediatamente antes de salir a producción."
    ))

    c.append(heading("2.1 Cuentas principales", 2))
    c.append(table(
        ["Rol", "Usuario", "Contraseña", "Correo", "Cédula"],
        [
            ["Administrador", "admin", "admin123", "admin@huv.gov.co", "12345678"],
            ["Asesor", "asesor", "asesor123", "asesor@huv.gov.co", "87654321"],
        ],
        col_widths=[1800, 1600, 1800, 2400, 1805],
    ))

    c.append(heading("2.2 Asesores de prueba (AsesoresSeeder)", 2))
    c.append(para(
        "Contraseña común de los 15 asesores creados por AsesoresSeeder: password123. "
        "Estos usuarios solo existen si el seeder se ejecuta explícitamente."
    ))
    c.append(table(
        ["Nombre", "Usuario", "Cédula"],
        [
            ["Karen Julieth Meneses", "kjmeneses", "12345001"],
            ["Jorge Orlando Duarte Martinez", "jodumarti", "12345002"],
            ["Luis Cruz", "lcruz", "12345003"],
            ["Andrea Yulieth Rojas", "ayrojas", "12345004"],
            ["Viviana Arango", "viarango", "12345005"],
            ["Carlos Murillo", "carmurillo", "12345006"],
            ["Juan David Delgado", "jddelgado", "12345007"],
            ["Rosa Maria Prado", "rmprado", "12345008"],
            ["Jesus Aldana", "jealdana", "12345009"],
            ["Alejandra Gonzalez", "alejagonz", "12345010"],
            ["Sandra Castro", "sandrac", "12345011"],
            ["Maria Galvis", "magalvis", "12345012"],
            ["Sofia Sanchez", "ssanchez", "12345013"],
            ["Miguel Ojeda", "miojeda", "12345014"],
            ["Diana Fernanda Velasco", "dfvelascov", "12345015"],
        ],
        col_widths=[4205, 2800, 2400],
    ))

    c.append(para(
        "IMPORTANTE: estas cuentas están pensadas para entornos de prueba. En "
        "producción deben eliminarse o tener contraseña rotada y forzar cambio en "
        "el primer inicio de sesión.",
        bold=True,
    ))

    c.append(page_break())

    # 3. VARIABLES DE ENTORNO
    c.append(heading("3. VARIABLES DE ENTORNO (.env)", 1))
    c.append(para(
        "El archivo .env (no versionado) controla la configuración por entorno. "
        "A continuación se documentan las claves relevantes con valores "
        "recomendados de producción y desarrollo."
    ))

    c.append(heading("3.1 Aplicación", 2))
    c.append(code_block(
        'APP_NAME="Turnero HUV"\n'
        "APP_ENV=production        # production en prod, local en dev\n"
        "APP_KEY=base64:...        # generado con php artisan key:generate\n"
        "APP_DEBUG=false           # false en producción SIEMPRE\n"
        "APP_URL=http://turnos.huv.gov.co\n"
        "APP_LOCALE=es\n"
        "APP_FALLBACK_LOCALE=es\n"
        "APP_FAKER_LOCALE=es_ES\n"
        'APP_TIMEZONE="America/Bogota"\n'
        "APP_MAINTENANCE_DRIVER=file\n"
        "BCRYPT_ROUNDS=12          # coste de hash de contraseñas"
    ))
    c.append(para(
        "APP_KEY es crítica: si se pierde, las sesiones y datos encriptados se "
        "invalidan. Mantener backup cifrado en lugar seguro.",
        bold=True,
    ))

    c.append(heading("3.2 Base de datos", 2))
    c.append(code_block(
        "DB_CONNECTION=mysql\n"
        "DB_HOST=127.0.0.1         # IP del servidor MySQL en producción\n"
        "DB_PORT=3306\n"
        "DB_DATABASE=turnero_huv\n"
        "DB_USERNAME=turnero_user  # usuario dedicado, NO root\n"
        "DB_PASSWORD=*************"
    ))
    c.append(bullet("El usuario debe tener permisos restringidos a la base turnero_huv."))
    c.append(bullet("No usar el usuario root en producción."))
    c.append(bullet("Recomendado: TLS entre aplicación y base de datos si están en hosts distintos."))

    c.append(heading("3.3 Sesiones, cache y colas", 2))
    c.append(code_block(
        "SESSION_DRIVER=database   # permite forzar cierre desde panel admin\n"
        "SESSION_LIFETIME=120      # minutos\n"
        "SESSION_ENCRYPT=false\n"
        "SESSION_PATH=/\n"
        "SESSION_DOMAIN=null\n"
        "SESSION_SECURE_COOKIE=true  # true en HTTPS\n"
        "SESSION_SAME_SITE=lax\n\n"
        "CACHE_STORE=database\n"
        "QUEUE_CONNECTION=database"
    ))

    c.append(heading("3.4 Tiempo real (Broadcasting)", 2))
    c.append(code_block(
        "BROADCAST_CONNECTION=pusher   # log en dev, pusher en prod\n"
        "PUSHER_APP_ID=...\n"
        "PUSHER_APP_KEY=...\n"
        "PUSHER_APP_SECRET=...\n"
        "PUSHER_HOST=127.0.0.1         # si se usa Reverb local\n"
        "PUSHER_PORT=8080\n"
        "PUSHER_SCHEME=http\n"
        "PUSHER_APP_CLUSTER=mt1\n\n"
        'VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"\n'
        'VITE_PUSHER_HOST="${PUSHER_HOST}"\n'
        'VITE_PUSHER_PORT="${PUSHER_PORT}"\n'
        'VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"\n'
        'VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"'
    ))
    c.append(para(
        "Para una intranet hospitalaria sin salida a internet, se recomienda "
        "Laravel Reverb (o soketi) corriendo localmente como reemplazo de Pusher.",
        italic=True,
    ))

    c.append(heading("3.5 Almacenamiento, correo y logs", 2))
    c.append(code_block(
        "FILESYSTEM_DISK=public\n\n"
        "MAIL_MAILER=log           # log en desarrollo\n"
        "MAIL_HOST=127.0.0.1\n"
        "MAIL_PORT=2525\n"
        'MAIL_FROM_ADDRESS="turnero@huv.gov.co"\n'
        'MAIL_FROM_NAME="${APP_NAME}"\n\n'
        "LOG_CHANNEL=stack\n"
        "LOG_STACK=single\n"
        "LOG_LEVEL=info            # debug solo en desarrollo"
    ))

    c.append(page_break())

    # 4. INFRAESTRUCTURA
    c.append(heading("4. INFRAESTRUCTURA RECOMENDADA", 1))
    c.append(heading("4.1 Servidor de aplicaciones", 2))
    c.append(table(
        ["Recurso", "Mínimo", "Recomendado"],
        [
            ["CPU", "4 cores", "8 cores"],
            ["RAM", "8 GB", "16 GB"],
            ["Disco", "100 GB SSD", "256 GB NVMe"],
            ["Red", "1 Gbps", "1 Gbps (dedicada)"],
            ["SO", "Ubuntu 22.04 LTS", "Ubuntu 22.04 LTS"],
        ],
        col_widths=[2200, 3400, 3805],
    ))

    c.append(heading("4.2 Base de datos", 2))
    c.append(bullet("MySQL 8.0+ o MariaDB 10.6+."))
    c.append(bullet("Charset utf8mb4, collation utf8mb4_unicode_ci."))
    c.append(bullet("innodb_buffer_pool_size = 25-50% RAM."))
    c.append(bullet("Backups diarios mysqldump comprimidos y replicación off-site."))

    c.append(heading("4.3 Terminales y dispositivos", 2))
    c.append(table(
        ["Punto", "Hardware sugerido", "Notas"],
        [
            ["Asesor", "PC con Chrome/Edge/Firefox actualizado", "Conexión cableada preferida"],
            ["Atril (kiosko)", "Mini-PC con pantalla táctil + impresora térmica", "Modo kiosko en Chrome"],
            ["TV pública", "Smart TV o Android TV Box Full HD", "Cableado Ethernet recomendado"],
            ["Móvil paciente", "Smartphone con cámara para QR", "Solo lectura sobre /movil"],
            ["Audio", "Salida del PC TV hacia amplificador o altavoz", "Salida balanceada para distancias largas"],
        ],
        col_widths=[1800, 4100, 3505],
    ))

    c.append(heading("4.4 Matriz de puertos", 2))
    c.append(table(
        ["Servicio", "Puerto", "Protocolo", "Dirección"],
        [
            ["HTTP", "80", "TCP", "Entrada"],
            ["HTTPS", "443", "TCP", "Entrada"],
            ["MySQL", "3306", "TCP", "Local/Salida"],
            ["WebSockets (Pusher/Reverb)", "6001 / 8080", "TCP", "Entrada"],
            ["SSH (administración)", "22", "TCP", "Restringido"],
        ],
        col_widths=[3800, 1800, 1800, 2005],
    ))

    c.append(page_break())

    # 5. SISTEMA DE VOZ
    c.append(heading("5. SISTEMA DE VOZ (TTS)", 1))
    c.append(heading("5.1 Piper TTS (local)", 2))
    c.append(bullet("Binario en tools/piper/ (piper.exe en Windows, piper en Linux)."))
    c.append(bullet("Modelos onnx en tools/piper/models/."))
    c.append(bullet("Voz por defecto: es_ES-davefx-medium.onnx o es_ES-mms-medium.onnx."))
    c.append(bullet("Scripts auxiliares en scripts/setup_piper_tts.py y raíz del proyecto (generate_voice_*.py)."))
    c.append(bullet("Audios generados en public/audio/turnero/ y reproducidos desde el navegador."))

    c.append(heading("5.2 Validación", 2))
    c.append(code_block(
        "# Windows\n"
        ".\\setup_piper.ps1\n"
        ".\\tools\\piper\\piper.exe --help\n\n"
        "# Linux / Mac\n"
        "python3 scripts/setup_piper_tts.py\n"
        "./tools/piper/piper --help"
    ))

    c.append(heading("5.3 Generación de audios faltantes", 2))
    c.append(bullet("Desde el panel: /voice/admin → \"Generar archivos faltantes\"."))
    c.append(bullet("Por script: python generate_voice_simple.py o generate_more_numbers.py."))

    # 6. POLITICAS
    c.append(heading("6. POLÍTICAS DE SEGURIDAD Y ACCESO", 1))
    c.append(heading("6.1 Control de sesiones", 2))
    c.append(bullet("Single session por usuario (una nueva sesión invalida la anterior)."))
    c.append(bullet("Expiración por inactividad: 15 minutos."))
    c.append(bullet("Sesiones almacenadas en MySQL (tabla sessions)."))
    c.append(bullet("Limpieza administrable desde /admin/clean-sessions, /admin/clean-all-sessions y /admin/clean-user-session."))

    c.append(heading("6.2 Endurecimiento recomendado", 2))
    c.append(bullet("HTTPS obligatorio (Let's Encrypt o certificado corporativo)."))
    c.append(bullet("Headers HSTS, X-Frame-Options DENY, CSP estricta, X-Content-Type-Options nosniff."))
    c.append(bullet("Limitar accesos a /admin y /asesor por VLAN o WAF."))
    c.append(bullet("Backups cifrados de .env (almacenar fuera del servidor de aplicación)."))
    c.append(bullet("Auditoría periódica del log de Laravel (storage/logs/laravel.log)."))

    c.append(heading("6.3 Protección de datos (Habeas Data)", 2))
    c.append(para(
        "Si la pantalla pública es visible desde zonas externas, configurar el "
        "sistema para mostrar únicamente el código de turno (sin nombre completo). "
        "Validar con el área jurídica el cumplimiento de la Ley 1581 de 2012 y "
        "su decreto reglamentario."
    ))

    c.append(page_break())

    # 7. BACKUPS Y DRP
    c.append(heading("7. BACKUPS Y RECUPERACIÓN", 1))
    c.append(heading("7.1 Estrategia", 2))
    c.append(bullet("Dump diario de MySQL a las 00:00 con mysqldump y compresión gzip."))
    c.append(bullet("Retención: 30 días en local + 90 días en repositorio off-site."))
    c.append(bullet("Backup semanal completo de storage/app/public (multimedia)."))
    c.append(bullet("Snapshot semanal de configuración (.env cifrado)."))

    c.append(heading("7.2 Procedimiento de restauración", 2))
    c.append(numbered("Aprovisionar servidor con los requisitos descritos en la sección 4.", 1))
    c.append(numbered("Clonar el repositorio y ejecutar composer install --no-dev y npm run build.", 2))
    c.append(numbered("Restaurar .env desde almacenamiento seguro.", 3))
    c.append(numbered("Restaurar dump MySQL más reciente (mysql turnero_huv < dump.sql).", 4))
    c.append(numbered("Restaurar multimedia en storage/app/public.", 5))
    c.append(numbered("Ejecutar php artisan storage:link y ajustar permisos.", 6))
    c.append(numbered("Iniciar workers y validar acceso a /dashboard, /tv y /atril.", 7))

    c.append(heading("7.3 Plan de continuidad operativa", 2))
    c.append(bullet("Servidor secundario en caliente con replicación MySQL."))
    c.append(bullet("Procedimiento manual de respaldo (entrega de turnos en papel) documentado en Manual de Usuario."))
    c.append(bullet("Pruebas trimestrales de restauración completa."))

    # 8. CONTACTOS
    c.append(heading("8. CONTACTOS Y RESPONSABLES", 1))
    c.append(table(
        ["Rol", "Responsable", "Contacto"],
        [
            ["Producto / Solicitante", "Líder Atención al Usuario - HUV", "atencion@huv.gov.co"],
            ["Desarrollo principal", "Innovación y Desarrollo - HUV", "innovacion@huv.gov.co"],
            ["Infraestructura", "Coordinación TI - HUV", "ti@huv.gov.co"],
            ["Soporte 24/7", "Mesa de servicio HUV", "Ext. 1234"],
        ],
        col_widths=[2800, 3800, 2805],
    ))

    c.append(divider())
    c.append(para("FIN DEL DOCUMENTO DE CREDENCIALES Y CONFIGURACIÓN.", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - Hospital Universitario del Valle", align="center"))

    return "".join(c)


if __name__ == "__main__":
    out = build_docx("CREDENCIALES_Y_CONFIGURACION", build())
    print(f"OK -> {out}")
