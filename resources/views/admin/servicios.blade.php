@extends('layouts.admin')

@section('title', 'Servicios')

{{-- La acción principal de la vista, arriba a la derecha. El <body> ya es un componente de Alpine: $dispatch llega a la ventana. --}}
@section('acciones_pagina')
    <button type="button" class="btn-primario" @click="$dispatch('abrir-servicio', { modo: 'crear' })">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
        Nuevo servicio
    </button>
@endsection

@section('content')
{{-- Servicios en una sola vista: cada sección del kiosco con sus subservicios debajo (ServicioController::index),
     con el código del ticket, los asesores asignados, la cola de hoy y cómo sale en el atril y el TV. --}}
@php $totalServicios = collect($secciones)->sum(fn ($s) => 1 + count($s['hijos'])); @endphp
<div class="servicios-vista" x-data="serviciosVista(@js($secciones), @js($search))">

    <!-- Crear / editar -->
    <div class="envoltorio-modal" x-data="formularioServicio(secciones)" @abrir-servicio.window="abrir($event.detail)" @keydown.escape.window="cerrar()">
        <div class="modal-panel" x-show="abierto" x-cloak x-transition.opacity @click.self="cerrar()">
            <div class="modal-panel__caja servicios-modal" role="dialog" aria-modal="true" aria-labelledby="servicio-form-titulo">
                <div class="modal-panel__cabeza">
                    <h2 id="servicio-form-titulo" x-text="titulo()"></h2>
                    <button type="button" class="accion-icono" aria-label="Cerrar" @click="cerrar()">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
                    </button>
                </div>
                <form class="form-panel" @submit.prevent="guardar()" novalidate>
                    <div class="form-panel__fila form-panel__fila--nombre">
                        <label class="form-campo">Nombre
                            <input type="text" class="campo" x-model="datos.nombre" x-ref="primero" maxlength="255" required :aria-invalid="errores.nombre ? 'true' : null">
                            <small x-show="errores.nombre" x-text="errores.nombre"></small>
                            <span class="form-ayuda form-ayuda--alerta" x-show="avisoUbicacion()">
                                <svg fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3M12 9v4M12 17h.01"/></svg>
                                <span>El ticket de esta sección indica <b x-text="original.ubicacion"></b> según su nombre: si lo cambia, el ticket dejará de indicar a dónde ir.</span>
                            </span>
                        </label>
                        <label class="form-campo">Código
                            <input type="text" class="campo" x-model="datos.codigo" maxlength="10" autocomplete="off" spellcheck="false"
                                   :aria-invalid="errores.codigo ? 'true' : null" @input="datos.codigo = datos.codigo.toUpperCase()">
                            <small x-show="errores.codigo" x-text="errores.codigo"></small>
                            <span class="form-ayuda codigo-ejemplo" x-show="!errores.codigo && codigoValido()">Así sale en el ticket: <b class="codigo-tecla" x-text="datos.codigo.trim().toUpperCase() + '-001'"></b></span>
                            <span class="form-ayuda form-ayuda--alerta" x-show="!errores.codigo && datos.codigo.trim() && !codigoValido()">
                                <svg fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3M12 9v4M12 17h.01"/></svg>
                                <span>Solo letras: la voz del TV las deletrea y luego dice el número.</span>
                            </span>
                        </label>
                    </div>
                    <div class="form-panel__fila">
                        <label class="form-campo">Pertenece a
                            <select class="campo" x-model="datos.servicio_padre_id" :disabled="tieneHijos()">
                                <option value="">Ninguna: es una sección del kiosco</option>
                                <template x-for="p in padresPosibles()" :key="p.id">
                                    <option :value="String(p.id)" x-text="p.nombre + (p.activo ? '' : ' (inactiva)')" :selected="String(p.id) === datos.servicio_padre_id"></option>
                                </template>
                            </select>
                            <small x-show="errores.servicio_padre_id" x-text="errores.servicio_padre_id"></small>
                            <span class="form-ayuda" x-show="tieneHijos()">Tiene subservicios: sigue siendo una sección.</span>
                        </label>
                        <label class="form-campo">Posición en el kiosco
                            <input type="number" class="campo" x-model="datos.orden" min="0" max="9999" placeholder="Al final" :aria-invalid="errores.orden ? 'true' : null">
                            <small x-show="errores.orden" x-text="errores.orden"></small>
                        </label>
                    </div>
                    <fieldset class="opciones-servicio">
                        <legend class="opciones-servicio__titulo">En el kiosco y el TV</legend>
                        <div class="opciones-servicio__lista">
                            <label class="opcion-servicio"><input type="checkbox" class="casilla" x-model="datos.activo">
                                <span class="opcion-servicio__texto"><span class="opcion-servicio__nombre">Activo</span> <span class="form-ayuda">Sale en el kiosco y se puede asignar a los asesores.</span></span>
                            </label>
                            <label class="opcion-servicio"><input type="checkbox" class="casilla" x-model="datos.ocultar_turno">
                                <span class="opcion-servicio__texto"><span class="opcion-servicio__nombre">Oculto en el TV</span> <span class="form-ayuda">Sus turnos no salen en el TV ni se llaman solos; se llaman por código.</span></span>
                            </label>
                            <label class="opcion-servicio" x-show="!tieneHijosActivos()"><input type="checkbox" class="casilla" x-model="datos.requiere_priorizacion">
                                <span class="opcion-servicio__texto"><span class="opcion-servicio__nombre">Pide prioridad en el kiosco</span> <span class="form-ayuda">Al sacar el turno se elige Normal o Alta.</span></span>
                            </label>
                        </div>
                    </fieldset>
                    <label class="form-campo">Descripción
                        <textarea class="campo campo--area" rows="2" x-model="datos.descripcion" maxlength="500" :aria-invalid="errores.descripcion ? 'true' : null"></textarea>
                        <small x-show="errores.descripcion" x-text="errores.descripcion"></small>
                    </label>
                    <div class="aviso aviso--error" role="alert" x-show="errores.general">
                        <svg fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4.5M12 16h.01"/></svg>
                        <p x-text="errores.general"></p>
                    </div>
                    <div class="modal-panel__pie modal-panel__pie--fijo">
                        <button type="button" class="btn-secundario" @click="cerrar()">Cancelar</button>
                        <button type="submit" class="btn-primario" :disabled="guardando" :aria-busy="guardando ? 'true' : null" x-text="guardando ? 'Guardando…' : (modo === 'crear' ? 'Crear servicio' : 'Guardar cambios')"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Eliminar: primero se mira qué se perdería -->
    <div class="envoltorio-modal" x-data="eliminarServicio()" @eliminar-servicio.window="abrir($event.detail)" @keydown.escape.window="cerrar()">
        <div class="modal-panel" x-show="abierto" x-cloak x-transition.opacity @click.self="cerrar()">
            <div class="modal-panel__caja modal-panel__caja--angosta servicios-modal" role="dialog" aria-modal="true" aria-labelledby="servicio-eliminar-titulo" tabindex="-1"
                 x-init="$watch('abierto', v => v && $nextTick(() => $el.focus()))">
                <div class="modal-panel__cabeza">
                    <h2 id="servicio-eliminar-titulo">Eliminar servicio</h2>
                    <button type="button" class="accion-icono" aria-label="Cerrar" @click="cerrar()">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
                    </button>
                </div>
                <div class="form-panel">
                    <!-- Qué se va a eliminar, como sale en la tabla -->
                    <div class="ficha-servicio" x-show="servicio">
                        <span class="ficha-servicio__nombre" x-text="servicio ? servicio.nombre : ''"></span>
                        <span class="codigo-tecla" x-show="servicio && servicio.codigo" x-text="servicio ? servicio.codigo : ''"></span>
                        <span class="estado-chip estado-chip--neutro estado-chip--chico" x-show="servicio && !servicio.activo">Inactivo</span>
                    </div>
                    <div x-show="cargando" class="impacto-esqueleto" role="status">
                        <span class="sr-only">Revisando qué depende de este servicio…</span>
                        <span class="esqueleto" style="width: 92%" aria-hidden="true"></span>
                        <span class="esqueleto" style="width: 80%" aria-hidden="true"></span>
                        <span class="esqueleto" style="width: 55%" aria-hidden="true"></span>
                    </div>
                    <template x-if="!cargando && impacto">
                        <div class="impacto">
                            <template x-if="impacto.hijos > 0">
                                <div class="aviso aviso--alerta" role="alert">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3M12 9v4M12 17h.01"/></svg>
                                    <p>No se puede eliminar: tiene <b x-text="impacto.hijos"></b> subservicio(s). Elimínelos o muévalos a otra sección primero.</p>
                                </div>
                            </template>
                            <template x-if="!impacto.hijos && conHistorial()">
                                <div class="impacto__historial">
                                    <div class="aviso aviso--error" role="alert">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3M12 9v4M12 17h.01"/></svg>
                                        <p>Tiene <b x-text="miles(impacto.turnos || impacto.historial)"></b> turnos registrados. Si lo elimina, se borran también de Reportes y Gráficos.</p>
                                    </div>
                                    <p class="form-texto" x-show="servicio.activo">Desactívelo: deja de salir en el kiosco y conserva su historial.</p>
                                    <p class="form-texto" x-show="!servicio.activo">Ya está inactivo: así conserva su historial.</p>
                                </div>
                            </template>
                            <template x-if="!impacto.hijos && !conHistorial()">
                                <div class="aviso aviso--error" role="alert">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3M12 9v4M12 17h.01"/></svg>
                                    <p>Se eliminará este servicio. <span x-show="impacto.asesores > 0"><b x-text="impacto.asesores"></b> asesor(es) lo tienen asignado y lo perderán.</span>
                                       <b>Esta acción no se puede deshacer.</b></p>
                                </div>
                            </template>
                        </div>
                    </template>
                    <div class="aviso aviso--error" role="alert" x-show="error">
                        <svg fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4.5M12 16h.01"/></svg>
                        <p x-text="error"></p>
                    </div>
                    <div class="modal-panel__pie">
                        <button type="button" class="btn-secundario" @click="cerrar()" x-text="puedeEliminar() || puedeDesactivar() ? 'Cancelar' : 'Cerrar'"></button>
                        <button type="button" class="btn-primario" x-show="puedeDesactivar()" :disabled="trabajando" :aria-busy="trabajando ? 'true' : null" @click="desactivar()" x-text="trabajando ? 'Desactivando…' : 'Desactivar'"></button>
                        <button type="button" class="btn-peligro" x-show="puedeEliminar()" :disabled="trabajando" :aria-busy="trabajando ? 'true' : null" @click="confirmar()" x-text="trabajando ? 'Eliminando…' : 'Eliminar'"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros rápidos y búsqueda: justo encima de la tabla que filtran -->
    <div class="barra-vista">
        <div class="filtros-rapidos" role="group" aria-label="Filtrar servicios">
            @foreach ([3.25, 4.75, 7, 5.5] as $ancho)
                <span class="filtro-rapido" data-esqueleto aria-hidden="true"><span class="esqueleto" style="width: {{ $ancho }}rem"></span></span>
            @endforeach
            <template x-for="f in filtros" :key="f.clave">
                <button type="button" class="filtro-rapido" :class="{ 'is-alerta': f.clave === 'sin_asesor' && contar('sin_asesor') > 0 }" :aria-pressed="(filtro === f.clave).toString()" @click="filtro = f.clave">
                    <span x-text="f.rotulo"></span> <span class="filtro-rapido__n" x-text="contar(f.clave)"></span>
                </button>
            </template>
        </div>
        <div class="buscador">
            <svg class="buscador__icono" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 110-15 7.5 7.5 0 010 15z"/></svg>
            <input type="search" x-model.debounce.150ms="buscar" class="campo" placeholder="Nombre, código o descripción" aria-label="Buscar servicio">
        </div>
    </div>

    <!-- Catálogo: una tabla, una sección por bloque; los subservicios cuelgan de su sección -->
    <div class="superficie catalogo">
        <table class="tabla-panel tabla-servicios">
            <thead>
                <tr>
                    <th scope="col">Servicio</th>
                    <th scope="col" class="col-codigo">Código</th>
                    <th scope="col" class="col-n col-asesores">Asesores</th>
                    <th scope="col" class="col-n col-cola">En cola</th>
                    <th scope="col" class="col-marcas">Atril y TV</th>
                    <th scope="col"><span class="sr-only">Acciones</span></th>
                </tr>
            </thead>
            {{-- Mientras arranca Alpine: la forma de las filas (init() las quita) --}}
            <tbody data-esqueleto aria-hidden="true">
                @for ($i = 0; $i < min($totalServicios, 14); $i++)
                    <tr class="fila-esqueleto">
                        <td style="padding-left: {{ $i % 4 ? '2.75rem' : '1rem' }}"><span class="esqueleto" style="width: {{ [9, 11, 8, 12][$i % 4] }}rem"></span></td>
                        <td><span class="esqueleto" style="width: 2.25rem"></span></td>
                        <td class="col-n"><span class="esqueleto esqueleto--derecha" style="width: 1.25rem"></span></td>
                        <td class="col-n"><span class="esqueleto esqueleto--derecha" style="width: 1.25rem"></span></td>
                        <td><span class="esqueleto" style="width: {{ $i % 3 ? 1 : 5.5 }}rem"></span></td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
            <template x-for="g in visibles()" :key="g.s.id">
                <tbody class="grupo-servicio">
                    <tr class="fila-seccion" :class="{ 'fila--inactiva': !g.s.activo, 'fila--contexto': g.contexto, 'fila-seccion--con-hijos': g.hijos.length }">
                        <td>
                            <div class="celda-servicio">
                                <span class="servicio-nombre" x-text="g.s.nombre"></span>
                                <span class="estado-chip estado-chip--neutro estado-chip--chico" x-show="!g.s.activo">Inactivo</span>
                                <span class="servicio-sub servicio-sub--ubicacion" x-show="g.s.ubicacion" :title="'El ticket de esta sección indica: ' + g.s.ubicacion">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                    <span x-text="g.s.ubicacion"></span>
                                </span>
                                <span class="servicio-sub" x-show="!g.s.ubicacion && g.s.descripcion" x-text="g.s.descripcion" :title="g.s.descripcion"></span>
                            </div>
                        </td>
                        <td x-html="celdaCodigo(g.s)"></td>
                        <td class="col-n" x-html="g.s.hijos.length ? vacio() : celdaAsesores(g.s)"></td>
                        <td class="col-n" x-html="celdaCola(g.s.hijos.length ? g.s.hijos.reduce((n, h) => n + h.en_cola, 0) : g.s.en_cola)"></td>
                        <td x-html="celdaMarcas(g.s, g.s.hijos.length > 0)"></td>
                        <td class="celda-acciones">
                            <div class="acciones-fila">
                                <button type="button" class="accion-icono" title="Agregar subservicio" :aria-label="'Agregar subservicio a ' + g.s.nombre"
                                        x-show="!g.s.padre_id" @click="$dispatch('abrir-servicio', { modo: 'crear', padreId: g.s.id })">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                                </button>
                                <button type="button" class="accion-icono" title="Editar" :aria-label="'Editar ' + g.s.nombre"
                                        @click="$dispatch('abrir-servicio', { modo: 'editar', servicio: g.s })">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.17 6.81a1 1 0 0 0-3.99-3.99L4.84 14.17a2 2 0 0 0-.5.83l-1.32 4.35a.5.5 0 0 0 .62.62l4.35-1.32a2 2 0 0 0 .83-.5zM14.5 5.5l4 4"/></svg>
                                </button>
                                <button type="button" class="accion-icono accion-icono--peligro" title="Eliminar" :aria-label="'Eliminar ' + g.s.nombre"
                                        @click="$dispatch('eliminar-servicio', { servicio: g.s })">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <template x-for="h in g.hijos" :key="h.id">
                        <tr class="fila-hijo" :class="{ 'fila--inactiva': !h.activo }">
                            <td>
                                <div class="celda-servicio">
                                    <span class="servicio-nombre" x-text="h.nombre"></span>
                                    <span class="estado-chip estado-chip--neutro estado-chip--chico" x-show="!h.activo">Inactivo</span>
                                    <span class="servicio-sub" x-show="h.descripcion" x-text="h.descripcion" :title="h.descripcion"></span>
                                </div>
                            </td>
                            <td x-html="celdaCodigo(h)"></td>
                            <td class="col-n" x-html="celdaAsesores(h)"></td>
                            <td class="col-n" x-html="celdaCola(h.en_cola)"></td>
                            <td x-html="celdaMarcas(h, false)"></td>
                            <td class="celda-acciones">
                                <div class="acciones-fila">
                                    <button type="button" class="accion-icono" title="Editar" :aria-label="'Editar ' + h.nombre"
                                            @click="$dispatch('abrir-servicio', { modo: 'editar', servicio: h })">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.17 6.81a1 1 0 0 0-3.99-3.99L4.84 14.17a2 2 0 0 0-.5.83l-1.32 4.35a.5.5 0 0 0 .62.62l4.35-1.32a2 2 0 0 0 .83-.5zM14.5 5.5l4 4"/></svg>
                                    </button>
                                    <button type="button" class="accion-icono accion-icono--peligro" title="Eliminar" :aria-label="'Eliminar ' + h.nombre"
                                            @click="$dispatch('eliminar-servicio', { servicio: h })">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </template>
        </table>
        <div class="vacio" x-show="!visibles().length" x-cloak>
            <p class="vacio__titulo" x-text="secciones.length ? 'Ningún servicio coincide' : 'Todavía no hay servicios'"></p>
            <p class="vacio__texto" x-show="secciones.length">Pruebe con otro nombre o código, o vea todo el catálogo.</p>
            <p class="vacio__texto" x-show="!secciones.length">Cree la primera sección del kiosco con «Nuevo servicio».</p>
            <button type="button" class="enlace-panel" x-show="secciones.length" @click="filtro = 'todos'; buscar = ''">Quitar filtros</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    const SERVICIOS_URL = @json(route('admin.servicios'));
    const ASIGNACION_URL = @json(route('admin.asignacion-servicios'));
    const TOKEN = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const CODIGO_VALIDO = /^[A-Z]{1,10}$/;
    const normal = t => String(t ?? '').normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();
    const esc = t => String(t ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    // Lo que se ve tras guardar y recargar: sileo lo guarda y lo muestra al volver.
    const recargarCon = opciones => sileo.recargarCon(opciones);

    Alpine.data('serviciosVista', (secciones, busquedaInicial) => ({
        secciones,
        filtro: 'todos',
        buscar: busquedaInicial || '',
        filtros: [
            { clave: 'todos', rotulo: 'Todos' },
            { clave: 'inactivos', rotulo: 'Inactivos' },
            { clave: 'ocultos', rotulo: 'Ocultos en el TV' },
            { clave: 'sin_asesor', rotulo: 'Sin asesor' },
        ],
        init() {
            this.$el.querySelectorAll('[data-esqueleto]').forEach(e => e.remove());
        },
        // Lo que recibe turnos del kiosco: un subservicio o una sección sin subservicios.
        esHoja(s) { return !(s.hijos && s.hijos.length); },
        todos() { return this.secciones.flatMap(s => [s, ...s.hijos]); },
        pasa(s, clave) {
            if (clave === 'inactivos') return !s.activo;
            if (clave === 'ocultos') return s.ocultar_turno;
            if (clave === 'sin_asesor') return this.esHoja(s) && s.activo && s.asesores === 0;
            return true;
        },
        contar(clave) { return this.todos().filter(s => this.pasa(s, clave)).length; },
        coincide(s, q) { return !q || [s.nombre, s.codigo, s.descripcion].some(v => normal(v).includes(q)); },
        // Filtra sin romper el árbol: si solo coinciden subservicios, su sección se muestra atenuada como contexto.
        visibles() {
            const q = normal(this.buscar.trim());
            return this.secciones.map(s => {
                // Si coincide el nombre o el código de la sección, se ven todos sus subservicios; por la descripción, no.
                const seccionCoincide = q && [s.nombre, s.codigo].some(v => normal(v).includes(q));
                const hijos = s.hijos.filter(h => this.pasa(h, this.filtro) && (this.coincide(h, q) || seccionCoincide));
                const propia = this.pasa(s, this.filtro) && this.coincide(s, q);
                return (propia || hijos.length) ? { s, hijos, contexto: !propia } : null;
            }).filter(Boolean);
        },
        // Celdas de la tabla (solo presentación): el estado siempre con palabra, nunca solo color.
        celdaCodigo(s) {
            if (!s.codigo) return '<span class="estado-chip estado-chip--error estado-chip--chico">Sin código</span>';
            if (!CODIGO_VALIDO.test(s.codigo)) {
                return '<span class="celda-codigo" title="La voz del TV no lee bien este código: use solo letras"><span class="codigo-tecla">' + esc(s.codigo)
                    + '</span><span class="estado-chip estado-chip--alerta estado-chip--chico">Revisar</span></span>';
            }
            return '<span class="codigo-tecla">' + esc(s.codigo) + '</span>';
        },
        celdaAsesores(s) {
            const url = ASIGNACION_URL + '?servicio=' + s.id;
            if (!s.activo) return '<span class="texto-mudo">' + s.asesores + '</span>';
            if (s.asesores === 0) return '<a class="etiqueta-asignar" href="' + url + '" title="Ningún asesor tiene asignado este servicio">Nadie · Asignar</a>';
            return '<a class="enlace-cifra" href="' + url + '" title="Ver quién lo atiende">' + s.asesores + '</a>';
        },
        vacio() { return '<span class="texto-mudo">—</span>'; },
        celdaCola(n) { return n > 0 ? '<b class="cola-n">' + n + '</b>' : '<span class="texto-mudo">0</span>'; },
        // Atril y TV: solo lo que se sale de lo normal (oculto en el TV, pide prioridad).
        // Una sección con subservicios no da turnos: de ella solo cuenta si está oculta en el TV.
        celdaMarcas(s, soloTv) {
            const marcas = [this.celdaTv(s), soloTv ? '' : this.celdaPrioridad(s)].filter(Boolean);
            return marcas.length ? '<span class="marcas">' + marcas.join('') + '</span>' : this.vacio();
        },
        celdaTv(s) {
            return s.ocultar_turno ? '<span class="estado-chip estado-chip--alerta" title="No sale en el TV ni se llama solo; se llama por código">Oculto en el TV</span>' : '';
        },
        celdaPrioridad(s) { return s.requiere_priorizacion ? '<span class="estado-chip estado-chip--info" title="El kiosco pregunta Normal o Alta">Pide prioridad</span>' : ''; },
    }));

    function enviar(url, datos, metodo) {
        const cuerpo = new FormData();
        Object.entries(datos).forEach(([k, v]) => cuerpo.append(k, typeof v === 'boolean' ? (v ? '1' : '0') : (v ?? '')));
        if (metodo) cuerpo.append('_method', metodo);
        return fetch(url, { method: 'POST', body: cuerpo, headers: { 'X-CSRF-TOKEN': TOKEN(), 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' } })
            .then(async r => ({ ok: r.ok, estado: r.status, datos: await r.json().catch(() => ({})) }));
    }
    const mensajeDe = (estado, datos, porDefecto) => estado === 419 ? 'La sesión expiró. Recargue la página e inténtelo de nuevo.' : (datos.message || porDefecto);
    const datosDe = s => ({
        nombre: s.nombre || '', codigo: s.codigo || '', servicio_padre_id: s.padre_id ? String(s.padre_id) : '',
        orden: s.orden ?? '', activo: !!s.activo, ocultar_turno: !!s.ocultar_turno,
        requiere_priorizacion: !!s.requiere_priorizacion, descripcion: s.descripcion || '',
    });

    Alpine.data('formularioServicio', secciones => ({
        abierto: false, modo: 'crear', id: null, original: {}, guardando: false, errores: {},
        datos: datosDe({ activo: true }),
        abrir({ modo, servicio, padreId }) {
            this.modo = modo; this.errores = {}; this.guardando = false;
            this.id = servicio ? servicio.id : null;
            this.original = servicio || {};
            this.datos = servicio ? datosDe(servicio) : datosDe({ activo: true, padre_id: padreId || null });
            this.abierto = true;
            this.$nextTick(() => this.$refs.primero && this.$refs.primero.focus());
        },
        cerrar() { if (!this.guardando) this.abierto = false; },
        titulo() {
            if (this.modo === 'editar') return 'Editar servicio';
            const padre = secciones.find(s => String(s.id) === this.datos.servicio_padre_id);
            return padre ? 'Nuevo subservicio de ' + padre.nombre : 'Nuevo servicio';
        },
        tieneHijos() { return !!(this.original.hijos && this.original.hijos.length); },
        tieneHijosActivos() { return !!(this.original.hijos && this.original.hijos.some(h => h.activo)); },
        padresPosibles() { return secciones.filter(s => s.id !== this.id && !s.padre_id); },
        codigoValido() { return CODIGO_VALIDO.test(this.datos.codigo.trim().toUpperCase()); },
        avisoUbicacion() { return this.modo === 'editar' && this.original.ubicacion && this.datos.nombre.trim() !== this.original.nombre; },
        guardar() {
            this.guardando = true; this.errores = {};
            const url = this.modo === 'crear' ? SERVICIOS_URL : SERVICIOS_URL + '/' + this.id;
            enviar(url, this.datos, this.modo === 'crear' ? null : 'PUT').then(({ ok, estado, datos }) => {
                if (ok && datos.success !== false) { recargarCon({ title: this.modo === 'crear' ? 'Servicio creado' : 'Cambios guardados' }); return; }
                this.guardando = false;
                const e = datos.errors || {};
                this.errores = Object.fromEntries(Object.entries(e).map(([k, v]) => [k, Array.isArray(v) ? v[0] : v]));
                if (!Object.keys(this.errores).length) this.errores = { general: mensajeDe(estado, datos, 'No se pudo guardar el servicio.') };
            }).catch(() => { this.guardando = false; this.errores = { general: 'No hay conexión con el servidor. Inténtelo de nuevo.' }; });
        },
    }));

    Alpine.data('eliminarServicio', () => ({
        abierto: false, servicio: null, impacto: null, cargando: false, trabajando: false, error: '',
        abrir({ servicio }) {
            this.servicio = servicio; this.impacto = null; this.error = ''; this.trabajando = false; this.cargando = true; this.abierto = true;
            fetch(SERVICIOS_URL + '/' + servicio.id, { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, cache: 'no-store' })
                .then(r => r.ok ? r.json() : Promise.reject(r.status))
                .then(d => { this.impacto = d.impacto; })
                .catch(e => { this.error = e === 419 ? mensajeDe(419, {}) : 'No se pudo revisar el servicio. Inténtelo de nuevo.'; })
                .finally(() => { this.cargando = false; });
        },
        cerrar() { if (!this.trabajando) this.abierto = false; },
        conHistorial() { return !!this.impacto && (this.impacto.turnos > 0 || this.impacto.historial > 0); },
        puedeEliminar() { return !!this.impacto && !this.impacto.hijos && !this.conHistorial(); },
        puedeDesactivar() { return !!this.impacto && !this.impacto.hijos && this.conHistorial() && this.servicio.activo; },
        miles(n) { return Number(n).toLocaleString('es-CO'); },
        confirmar() {
            this.trabajando = true; this.error = '';
            fetch(SERVICIOS_URL + '/' + this.servicio.id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': TOKEN(), 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' } })
                .then(async r => ({ ok: r.ok, estado: r.status, datos: await r.json().catch(() => ({})) }))
                .then(({ ok, estado, datos }) => {
                    if (ok && datos.success !== false) { recargarCon({ title: 'Servicio eliminado' }); return; }
                    this.trabajando = false; this.error = mensajeDe(estado, datos, 'No se pudo eliminar el servicio.');
                })
                .catch(() => { this.trabajando = false; this.error = 'No hay conexión con el servidor. Inténtelo de nuevo.'; });
        },
        desactivar() {
            this.trabajando = true; this.error = '';
            enviar(SERVICIOS_URL + '/' + this.servicio.id, { ...datosDe(this.servicio), activo: false }, 'PUT').then(({ ok, estado, datos }) => {
                if (ok && datos.success !== false) { recargarCon({ title: 'Servicio desactivado', description: 'Ya no sale en el kiosco.' }); return; }
                this.trabajando = false;
                const e = datos.errors ? Object.values(datos.errors)[0] : null;
                this.error = e ? (Array.isArray(e) ? e[0] : e) : mensajeDe(estado, datos, 'No se pudo desactivar el servicio.');
            }).catch(() => { this.trabajando = false; this.error = 'No hay conexión con el servidor. Inténtelo de nuevo.'; });
        },
    }));
});
</script>

@push('estilos')
<style>
/* ===== Servicios (2026-11, «La sala»): el catálogo del kiosco como un árbol sereno; ver DESIGN.md ===== */
[x-cloak] { display: none !important; }
/* Los modales van en envoltorios sin caja: sus hijos entran directo en la columna de la vista */
.envoltorio-modal { display: contents; }
.servicios-vista { display: flex; flex-direction: column; gap: 1rem; font-variant-numeric: tabular-nums; }

/* ---------- Catálogo ---------- */
.catalogo { overflow-x: auto; }
.tabla-servicios td { height: 2.75rem; padding-top: .25rem; padding-bottom: .25rem; white-space: nowrap; }
/* max-width: 0 deja que la primera columna recorte la descripción en vez de ensanchar la tabla */
/* El nombre se queda con el espacio que sobra; las demás columnas tienen su medida */
.tabla-servicios td:first-child { max-width: 0; }
.tabla-servicios .col-codigo { width: 8rem; }
.tabla-servicios .col-asesores { width: 8.5rem; }
.tabla-servicios .col-cola { width: 6rem; }
.tabla-servicios .col-marcas { width: 10rem; padding-left: 1.75rem; }
.tabla-servicios td:nth-child(5) { padding-left: 1.75rem; }
.tabla-servicios .col-n { text-align: right; }
.tabla-servicios th:last-child { width: 1%; }

/* Cada sección abre su bloque con su nombre en 650 y una línea entera encima; la fila mide lo mismo que las demás (44 px) */
.tabla-servicios .grupo-servicio + .grupo-servicio .fila-seccion > td { border-top: 1px solid var(--linea); }
.celda-servicio { display: flex; align-items: baseline; gap: .625rem; min-width: 0; overflow: hidden; }
.celda-servicio .estado-chip { align-self: center; }
.servicio-nombre { flex: 0 0 auto; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-weight: 500; color: var(--tinta); }
.fila-seccion .servicio-nombre { font-weight: 650; letter-spacing: .005em; }
.servicio-sub { flex: 0 1 auto; min-width: 0; font-size: .8125rem; color: var(--tinta-tenue); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.servicio-sub--ubicacion { display: inline-flex; align-items: baseline; gap: .3125rem; color: var(--tinta-suave); }
.servicio-sub svg { flex-shrink: 0; align-self: center; color: var(--icono); }

/* Árbol: los subservicios cuelgan de su sección con una guía fina que termina en codo en el último */
.fila-hijo > td:first-child { position: relative; padding-left: 2.875rem; }
.fila-hijo > td:first-child::before,
.fila-hijo > td:first-child::after { content: ""; position: absolute; left: 1.4375rem; pointer-events: none; }
.fila-hijo > td:first-child::before { top: -1px; bottom: 0; width: 1px; background: #cfd9e6; }
.fila-hijo > td:first-child::after { top: 50%; width: .75rem; height: 1px; background: #cfd9e6; }
.fila-hijo:last-of-type > td:first-child::before { bottom: calc(50% + .375rem); }
/* La línea entre subservicios empieza después de la guía, para no cruzarla */
.tabla-servicios .fila-hijo > td:first-child,
.tabla-servicios .fila-hijo:hover > td:first-child {
    border-top-color: transparent; background-image: linear-gradient(var(--linea-suave), var(--linea-suave));
    background-repeat: no-repeat; background-origin: border-box; background-position: right top; background-size: calc(100% - 2.875rem) 1px;
}
.tabla-servicios .fila-hijo:hover > td:first-child { background-color: #f6f9fd; }
.fila-hijo:last-of-type > td:first-child::after {
    top: calc(50% - .375rem); height: calc(.375rem + 1px); background: none;
    border-left: 1px solid #cfd9e6; border-bottom: 1px solid #cfd9e6; border-bottom-left-radius: .375rem;
}

.fila--inactiva .servicio-nombre { color: var(--tinta-tenue); }
.fila--inactiva .codigo-tecla { color: var(--tinta-tenue); background: transparent; }
.fila--contexto .servicio-nombre { color: var(--tinta-tenue); font-weight: 600; }
.fila--contexto .codigo-tecla { color: var(--tinta-tenue); }

/* Código del ticket: la .codigo-tecla del layout; en ámbar cuando la voz del TV no lo lee bien */
.celda-codigo { display: inline-flex; align-items: center; gap: .375rem; }

/* Asesores y cola */
/* La cifra queda al ras de la columna; su zona de clic se extiende hacia el margen de la celda */
.enlace-cifra {
    display: inline-block; min-width: 1.75rem; margin: -.3125rem -.5rem; padding: .3125rem .5rem; border-radius: .375rem; text-align: right;
    color: var(--azul); font-weight: 650; text-underline-offset: 3px;
}
.enlace-cifra:hover { background: var(--azul-claro); text-decoration: underline; }
.enlace-cifra:focus-visible { outline: 2px solid var(--azul); outline-offset: 2px; }
.cola-n { font-weight: 650; color: var(--tinta); }
.marcas { display: inline-flex; flex-wrap: nowrap; gap: .3125rem; }

/* Acciones de fila: siempre visibles */
.tabla-servicios .celda-acciones { width: 1%; padding-right: .75rem; }
.acciones-fila { display: flex; justify-content: flex-end; gap: .125rem; }

.fila-esqueleto > td { height: 2.75rem; }
.esqueleto--derecha { margin-left: auto; }

/* ---------- Modales de la vista (sobre .modal-panel del layout) ---------- */
.servicios-modal:focus { outline: none; }
.servicios-modal .form-texto { margin: 0; }
.form-panel__fila--nombre { grid-template-columns: minmax(0, 1fr) 11rem; }
@media (max-width: 639px) { .form-panel__fila--nombre { grid-template-columns: minmax(0, 1fr); } }

/* Advertencia en línea (DESIGN.md · Inputs): ícono de 15 px y el texto en tinta de alerta */
.form-ayuda--alerta { display: flex; align-items: flex-start; gap: .375rem; color: var(--alerta-tinta); font-weight: 500; }
.form-ayuda--alerta svg { width: .9375rem; height: .9375rem; flex: none; margin-top: .0625rem; }
.form-ayuda--alerta b { font-weight: 650; }
.codigo-ejemplo { display: flex; flex-wrap: wrap; align-items: center; gap: .375rem; }

/* Opciones del servicio: una lista con su etiqueta, cada opción con su nombre y lo que hace */
.opciones-servicio { min-width: 0; margin: 0; padding: 0; border: 0; }
.opciones-servicio__titulo { padding: 0; margin-bottom: .375rem; font-size: .8125rem; font-weight: 600; color: var(--tinta-2); }
.opciones-servicio__lista { border-radius: .625rem; box-shadow: inset 0 0 0 1px var(--linea); overflow: hidden; }
.opcion-servicio {
    display: flex; align-items: flex-start; gap: .75rem; padding: .6875rem .875rem; cursor: pointer;
    transition: background-color .15s ease-out;
}
.opcion-servicio + .opcion-servicio { border-top: 1px solid var(--linea-suave); }
.opcion-servicio:hover { background: #f5f8fc; }
.opcion-servicio__texto { display: flex; flex-direction: column; gap: .125rem; min-width: 0; }
.opcion-servicio__nombre { font-size: .875rem; font-weight: 600; color: var(--tinta); }
/* La .casilla del layout baja al centro de la primera línea del nombre */
.opcion-servicio .casilla { margin-top: .125rem; }
@media (prefers-reduced-motion: reduce) { .opcion-servicio { transition: none; } }

/* Eliminar servicio: qué se elimina y qué depende de él */
.ficha-servicio {
    display: flex; flex-wrap: wrap; align-items: center; gap: .5rem; padding: .75rem .875rem; border-radius: .75rem; background: #f5f8fc;
}
.ficha-servicio__nombre { min-width: 0; font-size: .875rem; font-weight: 650; color: var(--tinta); overflow-wrap: anywhere; }
.impacto { display: flex; flex-direction: column; gap: .5rem; }
.impacto__historial { display: flex; flex-direction: column; gap: .625rem; }
.impacto-esqueleto { display: flex; flex-direction: column; gap: .625rem; padding: .375rem 0; }
</style>
@endpush
@endsection
