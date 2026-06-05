"""DOCUMENTACION_TECNICA_ADICIONAL.docx - detalles complementarios."""

import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).parent))
from build_docs import (
    build_docx, title, subtitle, heading, para, bullet, numbered,
    code_block, table, divider, page_break,
)


def build():
    c = []
    c.append(title("DOCUMENTACIÓN TÉCNICA ADICIONAL"))
    c.append(subtitle("Detalles complementarios del Turnero HUV"))
    c.append(para("Innovación y Desarrollo - HUV - Mayo 2026", align="center"))
    c.append(divider())

    c.append(heading("1. INTRODUCCIÓN", 1))
    c.append(para(
        "Este documento complementa la Documentación Técnica principal con "
        "detalles operativos sobre estructura del repositorio, scripts auxiliares, "
        "sistema de auditoría, broadcasting en tiempo real, generación de voz, "
        "estrategia de errores y guía rápida de extensión del sistema. Está "
        "pensado para desarrolladores que reciban el código y necesiten "
        "ubicarse rápidamente."
    ))

    # 2. ESTRUCTURA REPO
    c.append(heading("2. ESTRUCTURA DEL REPOSITORIO", 1))
    c.append(code_block(
        "turnero-huv/\n"
        "├── app/\n"
        "│   ├── Http/Controllers/        # 14 controladores principales\n"
        "│   ├── Http/Middleware/         # roles, sesión, cajas expiradas\n"
        "│   ├── Models/                  # Caja, Servicio, Turno, User, ...\n"
        "│   └── Providers/\n"
        "├── bootstrap/                   # bootstrap de Laravel\n"
        "├── config/                      # configuración por categoría\n"
        "├── database/\n"
        "│   ├── migrations/              # 25+ migraciones evolutivas\n"
        "│   └── seeders/                 # UserSeeder, AsesoresSeeder, ...\n"
        "├── public/\n"
        "│   ├── audio/turnero/           # WAV/MP3 generados por TTS\n"
        "│   ├── images/                  # logos e iconos\n"
        "│   └── multimedia/              # symlink a storage\n"
        "├── resources/\n"
        "│   ├── views/admin/             # vistas Blade del panel admin\n"
        "│   ├── views/asesor/            # vistas Blade del asesor\n"
        "│   ├── views/turnos/            # vistas del atril\n"
        "│   ├── views/tv/                # vista del display público\n"
        "│   └── views/mobile/            # vista móvil para paciente\n"
        "├── routes/web.php               # única definición de rutas\n"
        "├── scripts/                     # setup TTS y utilidades Python\n"
        "├── storage/                     # logs, sesión, cache, multimedia\n"
        "├── tests/                       # PHPUnit\n"
        "├── tools/piper/                 # binarios y modelos Piper\n"
        "├── .env.example                 # plantilla de configuración\n"
        "├── composer.json                # dependencias PHP\n"
        "├── package.json                 # dependencias JS\n"
        "├── vite.config.js\n"
        "└── tailwind.config.js"
    ))

    # 3. MODELOS Y RELACIONES
    c.append(heading("3. MODELOS ELOQUENT", 1))
    c.append(heading("3.1 Relaciones principales", 2))
    c.append(table(
        ["Modelo", "Relación", "Tipo", "Modelo destino"],
        [
            ["User", "servicios()", "belongsToMany (user_servicio)", "Servicio"],
            ["User", "turnos()", "hasMany (asesor_id)", "Turno"],
            ["Servicio", "subservicios()", "hasMany", "Servicio (self)"],
            ["Servicio", "padre()", "belongsTo (servicio_padre_id)", "Servicio (self)"],
            ["Servicio", "turnos()", "hasMany", "Turno"],
            ["Caja", "turnos()", "hasMany", "Turno"],
            ["Caja", "asesor()", "belongsTo (user_id)", "User"],
            ["Turno", "servicio()", "belongsTo", "Servicio"],
            ["Turno", "caja()", "belongsTo", "Caja"],
            ["Turno", "asesor()", "belongsTo (asesor_id)", "User"],
            ["Turno", "historial()", "hasMany (turno_original_id)", "TurnoHistorial"],
        ],
        col_widths=[1800, 2200, 3000, 2405],
    ))

    c.append(heading("3.2 Eventos del modelo Turno (auditoría automática)", 2))
    c.append(code_block(
        "// app/Models/Turno.php\n"
        "protected static function boot()\n"
        "{\n"
        "    parent::boot();\n\n"
        "    static::created(function ($turno) {\n"
        "        TurnoHistorial::crearDesdeturno($turno, 'creacion');\n"
        "    });\n\n"
        "    static::updated(function ($turno) {\n"
        "        TurnoHistorial::crearDesdeturno($turno, 'actualizacion', [\n"
        "            'cambios' => $turno->getChanges(),\n"
        "            'valores_anteriores' => $turno->getOriginal(),\n"
        "        ]);\n"
        "    });\n\n"
        "    static::deleting(function ($turno) {\n"
        "        TurnoHistorial::crearDesdeturno($turno, 'eliminacion', [\n"
        "            'motivo' => 'Turno eliminado del sistema principal',\n"
        "        ]);\n"
        "    });\n"
        "}"
    ))
    c.append(para(
        "Gracias a estos hooks no se necesita un paquete externo de auditoría. "
        "Cualquier consumidor que toque turnos.* genera trazabilidad automática."
    ))

    c.append(heading("3.3 Scopes útiles", 2))
    c.append(bullet("Turno::pendientes() / llamados() / atendidos() / aplazados()."))
    c.append(bullet("Turno::porPrioridad($n), prioridadAlta(), prioridadBaja()."))
    c.append(bullet("Turno::delDia($fecha), delServicio($id), deLaCaja($id)."))
    c.append(bullet("User::activos() (sesión iniciada en los últimos 15 min)."))

    c.append(page_break())

    # 4. AUDITORIA
    c.append(heading("4. AUDITORÍA Y TRAZABILIDAD", 1))
    c.append(heading("4.1 turno_historial", 2))
    c.append(para(
        "Tabla que almacena el snapshot completo del turno en cada evento. "
        "Incluye actor (asesor o sistema), cambios, valores anteriores y motivo. "
        "Es la fuente para reportes históricos de larga duración cuando los "
        "turnos del día se rotan o purgan."
    ))

    c.append(heading("4.2 canal_no_presencial_historial", 2))
    c.append(para(
        "Registra cada inicio/fin de actividad de un asesor en canal "
        "telefónico o virtual (callcenter, whatsapp). Permite los reportes en "
        "/api/graficos/canales-no-presenciales/*."
    ))

    # 5. BROADCASTING
    c.append(heading("5. BROADCASTING EN TIEMPO REAL", 1))
    c.append(para(
        "El driver de broadcasting se configura por .env (BROADCAST_CONNECTION). "
        "En desarrollo el valor por defecto es log (los eventos se vuelcan al "
        "log de Laravel). En producción se recomienda Pusher o Laravel Reverb."
    ))

    c.append(heading("5.1 Eventos emitidos", 2))
    c.append(bullet("turno.llamado: cuando el asesor presiona \"Llamar siguiente\"."))
    c.append(bullet("turno.atendido: cuando el asesor cierra la atención."))
    c.append(bullet("turno.aplazado: cuando el asesor aplaza el turno."))
    c.append(bullet("cola.actualizada: cuando cambia el conteo de la cola."))

    c.append(heading("5.2 Configuración cliente (Echo)", 2))
    c.append(code_block(
        "// resources/js/bootstrap.js\n"
        "import Echo from 'laravel-echo';\n"
        "import Pusher from 'pusher-js';\n\n"
        "window.Pusher = Pusher;\n"
        "window.Echo = new Echo({\n"
        "    broadcaster: 'pusher',\n"
        "    key: import.meta.env.VITE_PUSHER_APP_KEY,\n"
        "    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,\n"
        "    forceTLS: false,\n"
        "    wsHost: import.meta.env.VITE_PUSHER_HOST,\n"
        "    wsPort: import.meta.env.VITE_PUSHER_PORT,\n"
        "    disableStats: true,\n"
        "    enabledTransports: ['ws', 'wss'],\n"
        "});\n\n"
        "// Vista TV\n"
        "Echo.channel('turnos')\n"
        "    .listen('.turno.llamado', (e) => actualizarTurnoEnPantalla(e))\n"
        "    .listen('.cola.actualizada', () => recargarCola());"
    ))

    c.append(heading("5.3 Fallback con polling", 2))
    c.append(para(
        "Las vistas TV y móvil incluyen un polling cada 3-5 segundos como "
        "fallback en caso de que el WebSocket se caiga. Esto garantiza que "
        "la pantalla no se quede desactualizada incluso en intranets con "
        "interrupciones esporádicas."
    ))

    c.append(page_break())

    # 6. SISTEMA DE VOZ
    c.append(heading("6. SISTEMA DE VOZ", 1))
    c.append(heading("6.1 Arquitectura", 2))
    c.append(bullet("Voz pregenerada (números 000-999 + frases comunes) en public/audio/turnero/."))
    c.append(bullet("Voz dinámica: VoiceController::getTurnAudio genera frases puntuales bajo demanda."))
    c.append(bullet("Caché por hash del texto - se reusa el archivo si ya existe."))
    c.append(bullet("Motor principal: Piper TTS (binario local). Opcionalmente Google Cloud TTS."))

    c.append(heading("6.2 Estructura de audios", 2))
    c.append(code_block(
        "public/audio/turnero/\n"
        "├── numeros/\n"
        "│   ├── 001.wav\n"
        "│   ├── 002.wav\n"
        "│   └── ... 999.wav\n"
        "├── servicios/\n"
        "│   ├── medicina_general.wav\n"
        "│   ├── cita_prioritaria.wav\n"
        "│   └── ...\n"
        "└── frases/\n"
        "    ├── turno.wav\n"
        "    ├── caja.wav\n"
        "    └── dirigirse.wav"
    ))

    c.append(heading("6.3 Reproducción", 2))
    c.append(para(
        "El cliente arma la secuencia: \"Turno\" + número + servicio + \"diríjase "
        "a la caja\" + número de caja. Cada archivo se reproduce con una pausa "
        "configurable. El navegador requiere interacción inicial del usuario "
        "para autorizar el audio (limitación de los navegadores modernos)."
    ))

    c.append(heading("6.4 Endpoints del sistema de voz", 2))
    c.append(table(
        ["Método", "Ruta", "Propósito"],
        [
            ["GET", "/voice/status", "Estado del sistema (binario, modelos, audios)"],
            ["GET", "/voice/turn-audio", "Audio compuesto del turno actual"],
            ["POST", "/voice/generate-missing", "Genera archivos faltantes en lote"],
            ["POST", "/voice/generate-specific", "Genera un audio puntual"],
            ["POST", "/voice/test-audio", "Prueba de reproducción"],
            ["GET", "/voice/admin", "Panel administrativo del sistema de voz"],
        ],
        col_widths=[1100, 3200, 5105],
    ))

    c.append(page_break())

    # 7. SCRIPTS AUXILIARES
    c.append(heading("7. SCRIPTS AUXILIARES Y AUTOMATIZACIÓN", 1))
    c.append(table(
        ["Script", "Propósito"],
        [
            ["scripts/setup_piper_tts.py", "Instala Piper TTS en Linux/Mac"],
            ["setup_piper.ps1 / install_piper_simple.ps1", "Instalación de Piper en Windows"],
            ["download_piper.ps1", "Descarga modelos onnx"],
            ["generate_voice_google.py / generate_voice_simple.py", "Generación de WAVs"],
            ["regenerate_voice_louder.py", "Re-generación con mayor volumen"],
            ["generate_more_numbers.py / generate_remaining_numbers.bat", "Backfill de números"],
            ["start-local-server.bat/.sh", "Servidor PHP embebido para desarrollo local"],
            ["start-server-local.bat / start-server-network.bat", "Servidor accesible en intranet"],
            ["switch-env.bat / switch-env.sh", "Alterna entre .env de local y red"],
            ["clear-sessions.bat", "Limpia tabla sessions"],
            ["test-session-config.bat", "Verifica configuración de sesiones"],
            ["fix-session-419.bat", "Resuelve el error 419 (token CSRF expirado)"],
            ["reset_password.php", "Reset administrativo de contraseña"],
        ],
        col_widths=[4400, 5005],
    ))

    # 8. ERRORES Y LOGS
    c.append(heading("8. MANEJO DE ERRORES Y LOGS", 1))
    c.append(heading("8.1 Logs", 2))
    c.append(bullet("Archivo principal: storage/logs/laravel.log."))
    c.append(bullet("LOG_CHANNEL=stack, LOG_STACK=single."))
    c.append(bullet("Para rotación diaria: cambiar a LOG_CHANNEL=daily, LOG_STACK=daily."))
    c.append(bullet("Comando útil en desarrollo: php artisan pail."))

    c.append(heading("8.2 Errores comunes", 2))
    c.append(table(
        ["Síntoma", "Causa probable", "Solución"],
        [
            ["419 Page Expired", "Token CSRF expirado / cookie de sesión perdida", "Refrescar; en kioskos ejecutar fix-session-419.bat"],
            ["Audio no suena", "Navegador bloquea autoplay", "El asesor o pantalla TV debe hacer clic una vez en la página"],
            ["Multimedia 404", "Symlink storage no creado", "php artisan storage:link y verificar permisos"],
            ["TV no actualiza turnos", "Caída del WebSocket", "El polling de respaldo recupera en 3s; verificar BROADCAST_CONNECTION"],
            ["Pantalla en blanco tras login", "Caché de vistas obsoleto", "php artisan optimize:clear"],
            ["Sesión no se mantiene en HTTPS", "SESSION_SECURE_COOKIE mal configurado", "Ajustar SESSION_SECURE_COOKIE=true tras certificado"],
        ],
        col_widths=[2800, 2800, 3805],
    ))

    c.append(page_break())

    # 9. GUIA DE EXTENSION
    c.append(heading("9. GUÍA DE EXTENSIÓN", 1))
    c.append(heading("9.1 Agregar un servicio nuevo", 2))
    c.append(numbered("Ingresar a /servicios como administrador.", 1))
    c.append(numbered("Definir nombre, código (3 letras), descripción y estado activo.", 2))
    c.append(numbered("Si es subservicio, seleccionar servicio padre.", 3))
    c.append(numbered("Ir a /asignacion-servicios y vincular asesores que puedan atenderlo.", 4))
    c.append(numbered("Opcionalmente generar audios TTS para el código nuevo desde /voice/admin.", 5))

    c.append(heading("9.2 Agregar un nuevo controlador", 2))
    c.append(code_block(
        "php artisan make:controller NuevoController\n\n"
        "# routes/web.php\n"
        "Route::middleware(['auth', 'admin.role'])->group(function () {\n"
        "    Route::get('/nuevo', [NuevoController::class, 'index'])->name('admin.nuevo');\n"
        "});"
    ))

    c.append(heading("9.3 Crear una nueva migración", 2))
    c.append(code_block(
        "php artisan make:migration agregar_campo_x_a_turnos\n\n"
        "# database/migrations/...\n"
        "Schema::table('turnos', function (Blueprint $table) {\n"
        "    $table->string('campo_x')->nullable();\n"
        "});\n\n"
        "php artisan migrate"
    ))

    c.append(heading("9.4 Reglas de oro", 2))
    c.append(bullet("No tocar turno_historial manualmente: es inmutable."))
    c.append(bullet("Toda escritura sobre turnos debe pasar por el modelo Turno (para conservar la auditoría)."))
    c.append(bullet("Usar Carbon::today() y Carbon::now() (no funciones nativas)."))
    c.append(bullet("Mantener el código en Arial 11 / Tailwind / sin emojis en producción si la UI los renderiza mal en kioscos antiguos."))

    # 10. TESTING
    c.append(heading("10. TESTING", 1))
    c.append(bullet("Framework: PHPUnit 11."))
    c.append(bullet("Configuración: phpunit.xml en la raíz."))
    c.append(bullet("Comando: composer test (equivale a php artisan test)."))
    c.append(bullet("Para pruebas de UI manuales: composer dev levanta serve + queue + pail + vite simultáneamente."))

    c.append(divider())
    c.append(para("FIN DE LA DOCUMENTACIÓN TÉCNICA ADICIONAL.", bold=True, align="center"))
    c.append(para("Innovación y Desarrollo - Hospital Universitario del Valle", align="center"))

    return "".join(c)


if __name__ == "__main__":
    out = build_docx("DOCUMENTACION_TECNICA_ADICIONAL", build())
    print(f"OK -> {out}")
