<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Turnero HUV') }} - Dashboard Administrativo</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js - Load from CDN directly -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>

    <style>
        .bg-hospital-blue {
            background-color: #064b9e;
        }
        
        .bg-hospital-blue-hover:hover {
            background-color: #053a7a;
        }
        
        .text-hospital-blue {
            color: #064b9e;
        }
        
        .border-hospital-blue {
            border-color: #064b9e;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100" x-data="{ sidebarOpen: false }">
    <!-- Header -->
    <header class="bg-hospital-blue text-white px-6 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <!-- Botón hamburguesa para móviles -->
            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-white hover:bg-hospital-blue-hover p-2 rounded">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div class="text-2xl font-bold">
                Turnero<span class="text-gray-300">HUV</span>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <button class="text-white hover:bg-hospital-blue-hover p-2 rounded">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </button>
            <button class="text-white hover:bg-hospital-blue-hover p-2 rounded">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </button>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm hover:text-gray-300 transition-colors">
                    <div>Cerrar</div>
                    <div>Sesión</div>
                </button>
            </form>
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-72 bg-hospital-blue text-white min-h-screen shadow-xl flex flex-col">
            <!-- Header del Sidebar -->
            <div class="p-6 border-b border-white/20 flex-shrink-0">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md p-1">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo HUV" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">HUV Admin</h2>
                        <p class="text-sm text-blue-200">Panel de Control</p>
                    </div>
                </div>
            </div>

            <!-- Información del Usuario -->
            <div class="p-4 border-b border-white/20 bg-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center border border-white/30">
                        <span class="text-sm font-medium">{{ substr($user->nombre_completo, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ $user->nombre_completo }}</p>
                        <p class="text-xs text-blue-200 truncate flex items-center">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            {{ $user->rol }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navegación -->
            <div class="flex-1 p-4 overflow-y-auto sidebar-nav pb-20">
                <nav class="space-y-1">
                    <!-- Inicio -->
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item group w-full flex items-center justify-start bg-white/20 text-white p-3 rounded-lg border-l-4 border-white shadow-md relative">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="text-sm font-medium">Inicio</span>
                        <div class="absolute right-3 w-2 h-2 bg-white rounded-full active-indicator"></div>
                    </a>

                    <!-- Separador -->
                    <div class="py-2">
                        <div class="border-t border-white/20"></div>
                        <p class="text-xs text-blue-200 mt-2 px-3 font-medium uppercase tracking-wider">Gestión Principal</p>
                    </div>

                    <!-- Módulo -->
                    <a href="{{ route('admin.cajas') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="text-sm font-medium">Módulo</span>
                    </a>

                    <!-- Servicios -->
                    <a href="{{ route('admin.servicios') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                        </svg>
                        <span class="text-sm font-medium">Servicios</span>
                    </a>

                    <!-- Asignación de Servicios -->
                    <a href="{{ route('admin.asignacion-servicios') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Asignación de Servicios</span>
                    </a>

                    <!-- Usuarios -->
                    <a href="{{ route('admin.users') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Usuarios</span>
                    </a>

                    <!-- Separador -->
                    <div class="py-2">
                        <div class="border-t border-white/20"></div>
                        <p class="text-xs text-blue-200 mt-2 px-3 font-medium uppercase tracking-wider">Análisis</p>
                    </div>

                    <!-- Gráficos -->
                    <button class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Gráficos</span>
                    </button>

                    <!-- Reportes -->
                    <button class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Reportes</span>
                    </button>

                    <!-- Separador -->
                    <div class="py-2">
                        <div class="border-t border-white/20"></div>
                        <p class="text-xs text-blue-200 mt-2 px-3 font-medium uppercase tracking-wider">Configuración</p>
                    </div>

                    <!-- Configuración -->
                    <button class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Configuración</span>
                    </button>

                    <!-- Config TV -->
                    <a href="{{ route('admin.tv-config') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Config TV</span>
                    </a>

                    <!-- Separador -->
                    <div class="py-2">
                        <div class="border-t border-white/20"></div>
                        <p class="text-xs text-blue-200 mt-2 px-3 font-medium uppercase tracking-wider">Otros</p>
                    </div>

                    <!-- Clientes -->
                    <button class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Clientes</span>
                    </button>

                    <!-- Preguntas -->
                    <button class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Preguntas</span>
                    </button>

                    <!-- Horas -->
                    <button class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Horas</span>
                    </button>
                </nav>
            </div>

            <!-- Footer del Sidebar -->
            <div class="flex-shrink-0 p-4 border-t border-white/20 bg-white/10 mt-auto">
                <div class="text-center">
                    <div class="text-sm font-medium text-white">Turnero HUV®</div>
                    <div class="text-xs text-blue-200">Hospital Universitario del Valle</div>
                    <div class="text-xs text-blue-300 mt-1">"Evaristo García" E.S.E</div>
                </div>

                <!-- Botón de Logout -->
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center text-blue-200 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-all duration-200 text-sm">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Advisor Status Table -->
                <div class="bg-white rounded-lg shadow">
                    <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                        <div class="grid grid-cols-3 gap-4 text-sm font-semibold">
                            <div>ASESOR</div>
                            <div>DISPONIBILIDAD</div>
                            <div>ESTADO</div>
                        </div>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @foreach($advisorData as $advisor)
                        <div class="grid grid-cols-3 gap-4 p-3 text-sm border-b {{ $advisor['availability'] === 'CAJA CERRADA' ? 'bg-blue-50' : 'bg-white' }}">
                            <div>{{ $advisor['name'] }}</div>
                            <div class="{{ $advisor['availability'] === 'DISPONIBLE' ? 'text-hospital-blue' : 'text-blue-800' }}">
                                {{ $advisor['availability'] }}
                            </div>
                            <div class="{{ $advisor['status'] === 'DISPONIBLE' ? 'text-hospital-blue' : 'text-blue-800' }}">
                                {{ $advisor['status'] }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Service Summary -->
                <div class="bg-white rounded-lg shadow">
                    <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                        <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                            <div>SERVICIO</div>
                            <div>TERMINADOS</div>
                        </div>
                    </div>
                    <div>
                        @foreach($serviceData as $service)
                        <div class="grid grid-cols-2 gap-4 p-3 text-sm border-b bg-white">
                            <div>{{ $service['service'] }}</div>
                            <div class="text-hospital-blue">{{ $service['count'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Advisor Terminals -->
                <div class="bg-white rounded-lg shadow">
                    <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                        <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                            <div>ASESOR</div>
                            <div>TERMINADOS</div>
                        </div>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @foreach($advisorTerminals as $advisor)
                        <div class="grid grid-cols-2 gap-4 p-3 text-sm border-b bg-white">
                            <div>{{ $advisor['name'] }}</div>
                            <div class="text-hospital-blue">{{ $advisor['terminals'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Queue Information -->
                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow">
                        <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                                <div>SERVICIO</div>
                                <div>TURNOS AUSENTES</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow">
                        <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                                <div>SERVICIO</div>
                                <div>TURNOS EN COLA</div>
                            </div>
                        </div>
                        <div>
                            @foreach($queueData as $service)
                            <div class="grid grid-cols-2 gap-4 p-3 text-sm border-b bg-white">
                                <div>{{ $service['service'] }}</div>
                                <div class="text-hospital-blue">{{ $service['count'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow">
                        <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                                <div>CALIFICACIÓN</div>
                                <div>CONTEO</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
