@php
    $user = auth()->user();
    $currentRoute = request()->route()?->getName();
    $displayName = $user->nombre_completo ?? $user->nombre_usuario ?? 'Usuario';
    $userInitial = mb_strtoupper(mb_substr($displayName, 0, 1));

    $navSections = [
        [
            'title' => null,
            'items' => [
                ['label' => 'Inicio', 'route' => 'admin.dashboard', 'icon' => 'home', 'hint' => 'Vista general'],
            ],
        ],
        [
            'title' => 'Operación',
            'items' => [
                ['label' => 'Turnos', 'route' => 'admin.turnos', 'icon' => 'ticket', 'hint' => 'Control diario'],
                ['label' => 'Módulos', 'route' => 'admin.cajas', 'icon' => 'building', 'hint' => 'Puntos de atención'],
                ['label' => 'Servicios', 'route' => 'admin.servicios', 'icon' => 'heart', 'hint' => 'Catálogo HUV'],
                ['label' => 'Asignación', 'route' => 'admin.asignacion-servicios', 'icon' => 'link', 'hint' => 'Servicios por asesor'],
            ],
        ],
        [
            'title' => 'Administración',
            'items' => [
                ['label' => 'Usuarios', 'route' => 'admin.users', 'icon' => 'users', 'hint' => 'Roles y accesos'],
            ],
        ],
        [
            'title' => 'Análisis',
            'items' => [
                ['label' => 'Gráficos', 'route' => 'admin.graficos', 'icon' => 'chart', 'hint' => 'Indicadores'],
                ['label' => 'Reportes', 'route' => 'admin.reportes', 'icon' => 'report', 'hint' => 'Exportaciones'],
            ],
        ],
        [
            'title' => 'Pantallas',
            'items' => [
                ['label' => 'Config TV', 'route' => 'admin.tv-config', 'icon' => 'monitor', 'hint' => 'Pantalla pública'],
            ],
        ],
        [
            'title' => 'Ayuda',
            'items' => [
                ['label' => 'Soporte', 'route' => 'admin.soporte', 'icon' => 'help', 'hint' => 'Asistencia'],
            ],
        ],
    ];
@endphp

<aside class="sidebar-responsive sidebar-shell text-white shadow-xl flex flex-col sidebar-full-height fixed inset-y-0 left-0 z-30 transform md:transform-none transition-transform duration-200 ease-out md:transition-none"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    <div class="sidebar-header px-4 py-4 border-b border-white/10 flex-shrink-0">
        <div class="flex items-center justify-between gap-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center min-w-0 gap-3" title="Turnero HUV">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm p-1 flex-shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo HUV" class="w-full h-full object-contain">
                </div>
                <div class="min-w-0 sidebar-label" x-show="!sidebarCollapsed">
                    <h2 class="text-base font-semibold leading-tight truncate">Turnero HUV</h2>
                    <p class="text-xs text-blue-100/80 truncate">Panel administrativo</p>
                </div>
            </a>

            <button type="button"
                    @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('huvSidebarCollapsed', sidebarCollapsed ? '1' : '0')"
                    class="hidden md:inline-flex h-8 w-8 items-center justify-center rounded-lg text-blue-100 hover:bg-white/10 hover:text-white transition-colors"
                    title="Alternar menú compacto">
                <svg class="h-4 w-4 transition-transform duration-200" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button type="button" @click="sidebarOpen = false" class="md:hidden h-9 w-9 inline-flex items-center justify-center rounded-lg text-white hover:bg-white/10 transition-colors" title="Cerrar menú">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="sidebar-user px-4 py-3 border-b border-white/10 bg-white/[0.06]">
        <div class="flex items-center gap-3" :class="sidebarCollapsed ? 'justify-center' : ''">
            <div class="w-9 h-9 rounded-lg bg-white/15 border border-white/20 flex items-center justify-center flex-shrink-0 shadow-sm">
                <span class="text-sm font-semibold">{{ $userInitial }}</span>
            </div>
            <div class="min-w-0 sidebar-label" x-show="!sidebarCollapsed">
                <p class="text-sm font-medium truncate">{{ $displayName }}</p>
                <p class="text-xs text-blue-100/80 truncate flex items-center mt-0.5">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-2 flex-shrink-0"></span>
                    {{ $user->rol ?? 'Sin rol' }}
                </p>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto sidebar-nav">
        <nav class="px-3 py-3 space-y-3 pb-6">
            @foreach($navSections as $section)
                <div>
                    @if($section['title'])
                        <div class="sidebar-section-title px-3 mb-1" x-show="!sidebarCollapsed">
                            {{ $section['title'] }}
                        </div>
                        <div class="hidden md:block mx-3 mb-2 border-t border-white/10" x-show="sidebarCollapsed"></div>
                    @endif

                    <div class="space-y-1">
                        @foreach($section['items'] as $item)
                            @php
                                $isActive = $currentRoute === $item['route'];
                            @endphp

                            <a href="{{ route($item['route']) }}"
                               title="{{ $item['label'] }}"
                               class="sidebar-item group relative flex min-h-10 items-center rounded-lg transition-all duration-200 {{ $isActive ? 'sidebar-item-active text-white shadow-sm' : 'text-blue-100/80 hover:text-white hover:bg-white/[0.08]' }}"
                               :class="sidebarCollapsed ? 'justify-center px-2' : 'justify-start px-3'">
                                <span class="sidebar-icon flex h-8 w-8 items-center justify-center rounded-lg flex-shrink-0 {{ $isActive ? 'bg-white text-hospital-blue' : 'bg-white/[0.08] text-blue-100/90 group-hover:bg-white/[0.14] group-hover:text-white' }} transition-colors">
                                    @switch($item['icon'])
                                        @case('home')
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                            @break
                                        @case('ticket')
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                            @break
                                        @case('building')
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            @break
                                        @case('heart')
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                            @break
                                        @case('link')
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                            @break
                                        @case('users')
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            @break
                                        @case('chart')
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                            @break
                                        @case('report')
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            @break
                                        @case('monitor')
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            @break
                                        @default
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @endswitch
                                </span>

                                <span class="sidebar-label ml-3 min-w-0 flex-1" x-show="!sidebarCollapsed">
                                    <span class="block text-sm font-medium truncate">{{ $item['label'] }}</span>
                                    <span class="block text-[11px] leading-tight text-blue-100/60 truncate group-hover:text-blue-50/80">{{ $item['hint'] }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>
    </div>

    <div class="flex-shrink-0 px-3 py-3 border-t border-white/10 bg-white/[0.06]">
        <div class="sidebar-label px-2 pb-3" x-show="!sidebarCollapsed">
            <div class="text-xs font-semibold text-white truncate">Hospital Universitario del Valle</div>
            <div class="text-[11px] text-blue-100/70 truncate">"Evaristo García" E.S.E</div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center min-h-10 rounded-lg text-blue-100/80 hover:text-white hover:bg-white/[0.08] transition-colors"
                    :class="sidebarCollapsed ? 'justify-center px-2' : 'justify-start px-3'"
                    title="Cerrar sesión">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/[0.08] flex-shrink-0">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </span>
                <span class="sidebar-label ml-3 text-sm font-medium" x-show="!sidebarCollapsed">Cerrar sesión</span>
            </button>
        </form>
    </div>
</aside>