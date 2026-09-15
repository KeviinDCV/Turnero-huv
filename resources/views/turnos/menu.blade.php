<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preload" href="{{ asset('fonts/InterVariable.woff2') }}" as="font" type="font/woff2" crossorigin>
    <title>Generar turno · {{ config('app.name', 'Turnero HUV') }}</title>
    @include('components.favicon')

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* KIOSCO 2026-09 — lo usa el asesor: fichas grandes para el dedo y lectura rápida */
        @font-face {
            font-family: 'Inter';
            src: url('{{ asset('fonts/InterVariable.woff2') }}') format('woff2');
            font-weight: 100 900; font-style: normal; font-display: block;
        }
        :root { --azul: #064b9e; --azul-hover: #053d7a; --tinta: #0f1f3d; --mudo: #5b6b82; --linea: #d9e1ec; --fondo: #f3f6fb; --rojo: #b42318; }
        * { -webkit-tap-highlight-color: transparent; }
        html, body { height: 100%; }
        body { font-family: 'Inter', 'Segoe UI', system-ui, sans-serif; font-feature-settings: 'cv05'; color: var(--tinta); background: var(--fondo); overflow: hidden; user-select: none; -webkit-user-select: none; }
        button { cursor: pointer; }

        .kiosco { height: 100vh; height: 100dvh; display: grid; grid-template-rows: auto minmax(0, 1fr) auto; }
        .barra { display: flex; align-items: center; gap: clamp(.8rem, 1.6vw, 1.6rem); padding: clamp(.7rem, 1.6vh, 1.2rem) clamp(1.25rem, 3vw, 3rem); background: #fff; box-shadow: inset 0 -1px 0 var(--linea); }
        .barra img { height: clamp(46px, 7vh, 80px); width: auto; flex: none; }
        .barra-nombre { font-size: clamp(1rem, 1.6vw, 1.5rem); font-weight: 700; line-height: 1.15; color: var(--azul); }
        .barra-unidad { margin-top: .15rem; font-size: clamp(.8rem, 1.1vw, 1.05rem); color: var(--mudo); }
        .barra-reloj { margin-left: auto; text-align: right; }
        .barra-hora { font-size: clamp(1.6rem, 3vw, 2.8rem); font-weight: 700; line-height: 1; letter-spacing: -.02em; font-variant-numeric: tabular-nums; }
        .barra-fecha { margin-top: .25rem; font-size: clamp(.8rem, 1.05vw, 1.05rem); color: var(--mudo); }

        .contenido { min-height: 0; overflow-y: auto; padding: clamp(1.5rem, 4.5vh, 3.75rem) clamp(1.25rem, 5vw, 6rem); }
        .antetitulo { font-size: clamp(.9rem, 1.3vw, 1.2rem); font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: var(--azul); }
        .encabezado h1 { margin-top: .6vh; font-size: clamp(2rem, 3.8vw, 3.6rem); font-weight: 800; line-height: 1.08; letter-spacing: -.025em; }
        .encabezado .sub { margin-top: 1vh; font-size: clamp(1.05rem, 1.7vw, 1.55rem); color: var(--mudo); }
        .opciones { margin-top: clamp(1.5rem, 4.5vh, 3.25rem); display: grid; grid-template-columns: repeat(var(--columnas, 2), minmax(0, 1fr)); gap: clamp(.9rem, 2.2vh, 1.6rem); }
        @media (max-width: 900px) and (orientation: landscape) { .opciones { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        .opcion { display: flex; align-items: center; gap: 1.2rem; min-height: clamp(90px, 13vh, 150px); padding: 1.2rem clamp(1.4rem, 2.4vw, 2.4rem); border: 0; border-radius: 22px;
                  background: var(--azul); color: #fff; text-align: left; box-shadow: 0 16px 32px -20px rgba(6, 75, 158, .75); transition: background .15s, transform .1s; }
        .opcion:active { transform: scale(.985); background: var(--azul-hover); }
        .opcion:focus-visible { outline: 4px solid rgba(6, 75, 158, .35); outline-offset: 4px; }
        .opcion-texto { flex: 1; min-width: 0; }
        .opcion-nombre { display: block; font-size: clamp(1.35rem, 2.3vw, 2.3rem); font-weight: 750; line-height: 1.15; letter-spacing: .01em; overflow-wrap: anywhere; }
        .opcion-nota { display: block; margin-top: .45rem; font-size: clamp(.95rem, 1.25vw, 1.2rem); font-weight: 500; color: #bfdbfe; }
        .opcion-flecha { flex: none; width: clamp(50px, 5vw, 66px); height: clamp(50px, 5vw, 66px); display: grid; place-items: center; border-radius: 50%; background: rgba(255, 255, 255, .15); }
        .opcion-flecha svg { width: 46%; height: 46%; }
        .vacio { padding: 3rem 1rem; text-align: center; font-size: clamp(1.1rem, 1.6vw, 1.5rem); color: var(--mudo); }

        .pie { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: clamp(.8rem, 2vh, 1.4rem) clamp(1.25rem, 3vw, 3rem); background: #fff; box-shadow: inset 0 1px 0 var(--linea); }
        .volver { height: clamp(58px, 7.5vh, 78px); padding: 0 clamp(1.4rem, 2vw, 2.2rem); display: inline-flex; align-items: center; gap: .6rem; border-radius: 16px; border: 2px solid #c9d5e6;
                  background: #fff; color: var(--azul); font-size: clamp(1.1rem, 1.6vw, 1.45rem); font-weight: 700; }
        .volver:active { background: #eef3fb; }
        .volver svg { width: 1.2em; height: 1.2em; }
        .firma { font-size: .75rem; color: #9aa6b8; }

        /* Ventanas */
        .velo { position: fixed; inset: 0; z-index: 50; display: flex; align-items: center; justify-content: center; padding: 3vh 4vw; background: rgba(7, 20, 40, .55); }
        .dialogo { width: 100%; max-width: 40rem; max-height: 94vh; overflow-y: auto; border-radius: 26px; background: #fff; padding: clamp(1.6rem, 4.5vh, 3rem) clamp(1.5rem, 3.2vw, 3rem);
                   text-align: center; box-shadow: 0 30px 80px -30px rgba(7, 20, 40, .6); animation: aparecer .18s ease-out; }
        .dialogo--ancho { max-width: 60rem; }
        @keyframes aparecer { from { opacity: 0; transform: translateY(10px) scale(.985); } }
        .dialogo h2 { font-size: clamp(1.6rem, 2.9vw, 2.7rem); font-weight: 800; line-height: 1.12; letter-spacing: -.02em; }
        .dialogo .sub { margin-top: .7rem; font-size: clamp(1.05rem, 1.6vw, 1.45rem); line-height: 1.45; color: var(--mudo); }
        .icono-dialogo { width: clamp(64px, 7vw, 84px); height: clamp(64px, 7vw, 84px); margin: 0 auto 1.2rem; display: grid; place-items: center; border-radius: 50%; background: #e3ecf9; color: var(--azul); }
        .icono-dialogo--alerta { background: #fdecec; color: var(--rojo); }
        .icono-dialogo svg { width: 48%; height: 48%; }
        .tipos { margin-top: clamp(1.4rem, 3.5vh, 2.6rem); display: grid; grid-template-columns: 1fr 1fr; gap: clamp(.9rem, 1.6vw, 1.4rem); }
        .tipo { display: flex; flex-direction: column; align-items: center; justify-content: flex-start; gap: .75rem; min-height: clamp(190px, 27vh, 310px); padding: clamp(1.6rem, 4vh, 2.6rem) 1.4rem 1.4rem;
                border: 0; border-radius: 22px; color: #fff; transition: transform .1s, filter .15s; }
        .tipo:active { transform: scale(.985); filter: brightness(.92); }
        .tipo svg { width: clamp(46px, 5vw, 66px); height: clamp(46px, 5vw, 66px); }
        .tipo-nombre { font-size: clamp(1.4rem, 2.4vw, 2.2rem); font-weight: 800; }
        .tipo-nota { max-width: 22rem; font-size: clamp(.98rem, 1.35vw, 1.25rem); line-height: 1.35; opacity: .92; }
        .btn-prioridad-normal { background: var(--azul); }
        .btn-prioridad-alta { background: var(--rojo); }
        .botones { display: flex; justify-content: center; flex-wrap: wrap; gap: .9rem; margin-top: clamp(1.3rem, 3vh, 2.2rem); }
        .primario, .secundario { min-width: 11rem; height: clamp(58px, 7vh, 72px); padding: 0 2rem; border-radius: 16px; font-size: clamp(1.1rem, 1.6vw, 1.4rem); font-weight: 700; }
        .primario { border: 0; background: var(--azul); color: #fff; }
        .primario:active { background: var(--azul-hover); }
        .secundario { border: 2px solid #c9d5e6; background: #fff; color: #33415c; }
        .secundario:active { background: #eef3fb; }

        .cargando { position: fixed; inset: 0; z-index: 60; flex-direction: column; align-items: center; justify-content: center; gap: 1.3rem; padding: 6vw; background: var(--fondo); text-align: center; }
        .giro { width: clamp(70px, 8vw, 100px); height: clamp(70px, 8vw, 100px); border-radius: 50%; border: 7px solid #d6e2f3; border-top-color: var(--azul); animation: giro .8s linear infinite; }
        @keyframes giro { to { transform: rotate(360deg); } }
        #loadingMessage { font-size: clamp(1.7rem, 3.2vw, 3rem); font-weight: 800; letter-spacing: -.02em; color: var(--azul); }
        #loadingSubMessage { font-size: clamp(1.1rem, 1.7vw, 1.55rem); color: var(--mudo); }
        #errorOverlay { z-index: 61; }

        @media (orientation: portrait) {
            .opciones { grid-template-columns: 1fr; }
            .opcion { min-height: clamp(110px, 10.5vh, 190px); }
            .opcion-nombre { font-size: clamp(1.5rem, 4.4vw, 2.6rem); }
            .encabezado h1 { font-size: clamp(2.2rem, 6.6vw, 4rem); }
            .tipos { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @php
        $ahoraKiosco = \Carbon\Carbon::now('America/Bogota');
        $fechaKiosco = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'][$ahoraKiosco->dayOfWeek] . ' ' . $ahoraKiosco->day . ' de '
            . ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'][$ahoraKiosco->month - 1];
        $enSubservicios = isset($mostrandoSubservicios) && $mostrandoSubservicios;
    @endphp
    <div class="kiosco">
        <header class="barra">
            <img src="{{ asset('images/logo.png') }}" alt="">
            <div>
                <div class="barra-nombre">Hospital Universitario del Valle</div>
                <div class="barra-unidad">{{ config('panel.unidad_nombre') }} · “Evaristo García” E.S.E.</div>
            </div>
            <div class="barra-reloj" aria-hidden="true">
                <div class="barra-hora" id="reloj-hora">{{ $ahoraKiosco->format('H:i') }}</div>
                <div class="barra-fecha" id="reloj-fecha">{{ $fechaKiosco }}</div>
            </div>
        </header>

        <main class="contenido">
            <div class="encabezado">
                @if($enSubservicios)
                    <div class="antetitulo">{{ mb_strtoupper($servicioSeleccionado->nombre) }}</div>
                    <h1>Elija la opción</h1>
                    <p class="sub">Al tocarla se imprime el turno para entregarlo al paciente.</p>
                @else
                    <div class="antetitulo">Generar turno</div>
                    <h1>Elija el servicio</h1>
                    <p class="sub">Al tocarlo se imprime el turno para entregarlo al paciente; si tiene opciones, primero se elige la opción.</p>
                @endif
            </div>

            @php
                $cantidadFichas = $enSubservicios ? max($subservicios->count(), 1) : $servicios->count();
            @endphp
            <div class="opciones" style="--columnas: {{ $cantidadFichas <= 4 ? 2 : 3 }}">
                @if($enSubservicios)
                    @forelse($subservicios as $subservicio)
                        <button type="button" class="opcion btn-service" onclick="seleccionarSubservicio({{ $subservicio->id }}, @js($subservicio->nombre))">
                            <span class="opcion-texto"><span class="opcion-nombre">{{ mb_strtoupper($subservicio->nombre) }}</span><span class="opcion-nota">Imprimir turno</span></span>
                            <span class="opcion-flecha" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.6" d="M9 5l7 7-7 7"/></svg></span>
                        </button>
                    @empty
                        <button type="button" class="opcion btn-service" onclick="seleccionarServicio({{ $servicioSeleccionado->id }}, @js($servicioSeleccionado->nombre))">
                            <span class="opcion-texto"><span class="opcion-nombre">{{ mb_strtoupper($servicioSeleccionado->nombre) }}</span><span class="opcion-nota">Imprimir turno</span></span>
                            <span class="opcion-flecha" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.6" d="M9 5l7 7-7 7"/></svg></span>
                        </button>
                    @endforelse
                @else
                    @forelse($servicios as $servicio)
                        @php
                            $opcionesActivas = $servicio->subservicios()->where('estado', 'activo')->count();
                        @endphp
                        @if($opcionesActivas > 0)
                            <button type="button" class="opcion btn-service" onclick="navegarASubservicios({{ $servicio->id }})">
                            <span class="opcion-texto"><span class="opcion-nombre">{{ mb_strtoupper($servicio->nombre) }}</span><span class="opcion-nota">{{ $opcionesActivas }} {{ $opcionesActivas === 1 ? 'opción' : 'opciones' }}</span></span>
                            <span class="opcion-flecha" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.6" d="M9 5l7 7-7 7"/></svg></span>
                        </button>
                        @else
                            <button type="button" class="opcion btn-service" onclick="seleccionarServicio({{ $servicio->id }}, @js($servicio->nombre))">
                            <span class="opcion-texto"><span class="opcion-nombre">{{ mb_strtoupper($servicio->nombre) }}</span><span class="opcion-nota">Imprimir turno</span></span>
                            <span class="opcion-flecha" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.6" d="M9 5l7 7-7 7"/></svg></span>
                        </button>
                        @endif
                    @empty
                        <p class="vacio">No hay servicios disponibles en este momento.</p>
                    @endforelse
                @endif
            </div>
        </main>

        <footer class="pie">
            <button type="button" class="volver" onclick="window.location.href='{{ $enSubservicios ? route('turnos.menu') : route('turnos.inicio') }}'">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.6" d="M15 19l-7-7 7-7"/></svg>
                Volver
            </button>
            <span class="firma">Turnero HUV · Innovación y desarrollo</span>
        </footer>
    </div>

    <!-- Tipo de turno (servicios con prioridad) -->
    <div id="prioridadModal" class="velo" style="display: none;" role="dialog" aria-modal="true" aria-labelledby="prioridadModalTitle">
        <div class="dialogo dialogo--ancho">
            <h2 id="prioridadModalTitle">Tipo de turno</h2>
            <p id="prioridadServicioNombre" class="sub"></p>
            <div class="tipos">
                <button type="button" onclick="seleccionarPrioridad('normal')" class="tipo btn-prioridad-normal">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="tipo-nombre">General</span>
                    <span class="tipo-nota">Atención en orden de llegada</span>
                </button>
                <button type="button" onclick="seleccionarPrioridad('alta')" class="tipo btn-prioridad-alta">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.48 3.5a.56.56 0 011.04 0l2.13 4.9 5.32.46c.5.04.7.66.32.98l-4.03 3.5 1.2 5.2c.11.49-.42.87-.85.61L12 16.4l-4.61 2.75c-.43.26-.96-.12-.85-.61l1.2-5.2-4.03-3.5c-.38-.32-.18-.94.32-.98l5.32-.46 2.13-4.9z"/></svg>
                    <span class="tipo-nombre">Prioritario</span>
                    <span class="tipo-nota">Adultos mayores, mujeres embarazadas y personas con discapacidad</span>
                </button>
            </div>
            <div class="botones">
                <button type="button" class="secundario" onclick="cerrarPrioridadModal()">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- Aviso -->
    <div id="confirmModal" class="velo" style="display: none;" role="dialog" aria-modal="true" aria-labelledby="confirmModalTitle">
        <div class="dialogo">
            <div class="icono-dialogo"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            <h2 id="confirmModalTitle">Aviso</h2>
            <p id="confirmMessage" class="sub"></p>
            <div class="botones"><button type="button" class="primario" onclick="cerrarModal()">Aceptar</button></div>
        </div>
    </div>

    <!-- Generando / imprimiendo el turno -->
    <div id="loadingOverlay" class="cargando" style="display: none;" role="status" aria-live="polite">
        <div class="giro" aria-hidden="true"></div>
        <p id="loadingMessage">Generando turno...</p>
        <p id="loadingSubMessage">Por favor espere</p>
    </div>

    <script>
        // Hora del kiosco (Colombia)
        (function () {
            const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
            function pintar() {
                const d = new Date(new Date().toLocaleString('en-US', { timeZone: 'America/Bogota' }));
                document.getElementById('reloj-hora').textContent = String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
                document.getElementById('reloj-fecha').textContent = dias[d.getDay()] + ' ' + d.getDate() + ' de ' + meses[d.getMonth()];
            }
            pintar();
            setInterval(pintar, 15000);
        })();
    </script>

    <script>
        // Configurar CSRF token para peticiones AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Variables para almacenar datos del servicio seleccionado
        let servicioSeleccionadoId = null;
        let servicioSeleccionadoNombre = '';

        // Aviso a pantalla completa mientras se crea el turno (también evita un segundo toque)
        function mostrarLoading(mensaje = 'Generando turno...', submensaje = 'Por favor espere') {
            document.getElementById('loadingMessage').textContent = mensaje;
            document.getElementById('loadingSubMessage').textContent = submensaje;
            document.getElementById('loadingOverlay').style.display = 'flex';
        }
        function ocultarLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        // Función para navegar a subservicios
        function navegarASubservicios(servicioId) {
            if (navigator.vibrate) navigator.vibrate(30);
            window.location.href = `{{ route('turnos.menu') }}?servicio_id=${servicioId}`;
        }

        // Función para seleccionar un servicio principal (sin subservicios)
        function seleccionarServicio(servicioId, nombreServicio) {
            if (navigator.vibrate) navigator.vibrate(30);
            mostrarLoading('Generando turno...', nombreServicio);

            fetch('{{ route('turnos.seleccionar') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    servicio_id: servicioId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Verificar si requiere priorización
                    if (data.requiere_priorizacion) {
                        servicioSeleccionadoId = data.servicio_id;
                        servicioSeleccionadoNombre = data.servicio_nombre;
                        mostrarPrioridadModal(data.servicio_nombre);
                    } else {
                        // Redirigir al ticket del turno
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url;
                        } else {
                            mostrarModal(data.message);
                        }
                    }
                } else {
                    mostrarModal(data.message || 'Error al procesar la solicitud');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarModal('Error de conexión');
            });
        }

        // Función para seleccionar un subservicio
        function seleccionarSubservicio(subservicioId, nombreSubservicio) {
            if (navigator.vibrate) navigator.vibrate(30);
            mostrarLoading('Generando turno...', nombreSubservicio);

            fetch('{{ route('turnos.seleccionar') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    subservicio_id: subservicioId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Verificar si requiere priorización
                    if (data.requiere_priorizacion) {
                        servicioSeleccionadoId = data.servicio_id;
                        servicioSeleccionadoNombre = data.servicio_nombre;
                        mostrarPrioridadModal(data.servicio_nombre);
                    } else {
                        // Redirigir al ticket del turno
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url;
                        } else {
                            mostrarModal(data.message);
                        }
                    }
                } else {
                    mostrarModal(data.message || 'Error al procesar la solicitud');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarModal('Error de conexión');
            });
        }

        // Mostrar modal de selección de prioridad
        function mostrarPrioridadModal(nombreServicio) {
            ocultarLoading();
            document.getElementById('prioridadServicioNombre').textContent = `Servicio: ${nombreServicio}`;
            document.getElementById('prioridadModal').style.display = 'flex';
        }

        // Cerrar modal de prioridad
        function cerrarPrioridadModal() {
            document.getElementById('prioridadModal').style.display = 'none';
            servicioSeleccionadoId = null;
            servicioSeleccionadoNombre = '';
        }

        // Seleccionar prioridad y crear turno
        function seleccionarPrioridad(prioridad) {
            if (navigator.vibrate) navigator.vibrate(30);
            mostrarLoading('Generando turno...', servicioSeleccionadoNombre);
            
            if (!servicioSeleccionadoId) {
                mostrarModal('Error: No hay servicio seleccionado');
                return;
            }

            fetch('{{ route('turnos.crear-con-prioridad') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    servicio_id: servicioSeleccionadoId,
                    prioridad: prioridad
                })
            })
            .then(response => response.json())
            .then(data => {
                cerrarPrioridadModal();
                
                if (data.success) {
                    // Redirigir al ticket del turno
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        mostrarModal(data.message);
                    }
                } else {
                    mostrarModal(data.message || 'Error al generar el turno');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                cerrarPrioridadModal();
                mostrarModal('Error de conexión');
            });
        }

        // Función para mostrar el modal personalizado
        function mostrarModal(mensaje) {
            ocultarLoading();
            document.getElementById('confirmMessage').textContent = mensaje;
            document.getElementById('confirmModal').style.display = 'flex';
        }

        // Función para cerrar el modal
        function cerrarModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }

        // Cerrar modales visibles con la tecla Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const prioridadModal = document.getElementById('prioridadModal');
                if (prioridadModal && prioridadModal.style.display !== 'none') {
                    cerrarPrioridadModal();
                }
                const confirmModal = document.getElementById('confirmModal');
                if (confirmModal && confirmModal.style.display !== 'none') {
                    cerrarModal();
                }
            }
        });

        // Agregar efecto de vibración en dispositivos móviles al tocar botones
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function() {
                if (navigator.vibrate) {
                    navigator.vibrate(30);
                }
            });
        });

        // Prevenir zoom en dispositivos táctiles
        document.addEventListener('touchstart', function(event) {
            if (event.touches.length > 1) {
                event.preventDefault();
            }
        });

        let lastTouchEnd = 0;
        document.addEventListener('touchend', function(event) {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    </script>
</body>
</html>
