<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Cajas - Turnero HUV</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
        
        [x-cloak] {
            display: none !important;
        }

        /* Estilos adicionales para la sidebar */
        .sidebar-item {
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }
        
        .sidebar-item:hover::before {
            left: 100%;
        }

        /* Animación suave para el indicador activo */
        .active-indicator {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Mejora del scroll en la sidebar */
        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }
        
        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
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
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="text-sm font-medium">Inicio</span>
                    </a>

                    <!-- Separador -->
                    <div class="py-2">
                        <div class="border-t border-white/20"></div>
                        <p class="text-xs text-blue-200 mt-2 px-3 font-medium uppercase tracking-wider">Gestión Principal</p>
                    </div>

                    <!-- Módulo - Página Activa -->
                    <a href="{{ route('admin.cajas') }}" class="sidebar-item group w-full flex items-center justify-start bg-white/20 text-white p-3 rounded-lg border-l-4 border-white shadow-md relative">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="text-sm font-medium">Módulo</span>
                        <div class="absolute right-3 w-2 h-2 bg-white rounded-full active-indicator"></div>
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

                    <!-- ConfigTv -->
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
        <main class="flex-1 p-6">
            <div class="bg-white rounded-lg shadow-md p-6 max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6" x-data="{ openModal: false }">
                    <h1 class="text-2xl font-bold text-gray-800">Gestión de Cajas</h1>
                    <button @click="openModal = true" class="bg-hospital-blue text-white px-4 py-2 rounded hover:bg-hospital-blue-hover transition-colors cursor-pointer">
                        Nueva Caja
                    </button>

                    <!-- Modal para crear caja -->
                    <div
                        x-show="openModal"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4"
                        style="display: none;"
                    >
                        <div
                            @click.away="openModal = false"
                            class="bg-white rounded-lg shadow-2xl w-full max-w-2xl overflow-y-auto max-h-[90vh]"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                        >
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-800">Crear Nueva Caja</h2>
                                    <button @click="openModal = false" class="text-gray-500 hover:text-gray-700 cursor-pointer">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                @if ($errors->any())
                                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                                    <div class="font-bold">Por favor corrige los siguientes errores:</div>
                                    <ul class="list-disc ml-5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form action="{{ route('admin.cajas.store') }}" method="POST">
                                    @csrf

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Nombre -->
                                        <div>
                                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Caja</label>
                                            <input
                                                type="text"
                                                id="nombre"
                                                name="nombre"
                                                value="{{ old('nombre') }}"
                                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                                placeholder="Ej: Caja Principal"
                                                required
                                            >
                                        </div>

                                        <!-- Número de Caja -->
                                        <div>
                                            <label for="numero_caja" class="block text-sm font-medium text-gray-700 mb-1">Número de Caja</label>
                                            <input
                                                type="number"
                                                id="numero_caja"
                                                name="numero_caja"
                                                value="{{ old('numero_caja') }}"
                                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                                placeholder="1"
                                                min="1"
                                                required
                                            >
                                        </div>

                                        <!-- Ubicación -->
                                        <div>
                                            <label for="ubicacion" class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                                            <input
                                                type="text"
                                                id="ubicacion"
                                                name="ubicacion"
                                                value="{{ old('ubicacion') }}"
                                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                                placeholder="Ej: Primer piso - Área de facturación"
                                            >
                                        </div>

                                        <!-- Estado -->
                                        <div>
                                            <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                            <select
                                                id="estado"
                                                name="estado"
                                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                                required
                                            >
                                                <option value="activa" {{ old('estado') === 'activa' ? 'selected' : '' }}>Activa</option>
                                                <option value="inactiva" {{ old('estado') === 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                                            </select>
                                        </div>

                                        <!-- Descripción -->
                                        <div class="md:col-span-2">
                                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                            <textarea
                                                id="descripcion"
                                                name="descripcion"
                                                rows="3"
                                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                                placeholder="Descripción opcional de la caja..."
                                            >{{ old('descripcion') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="mt-8 flex justify-end space-x-3">
                                        <button type="button" @click="openModal = false" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition-colors cursor-pointer">
                                            Cancelar
                                        </button>
                                        <button type="submit" class="bg-hospital-blue text-white px-6 py-2 rounded hover:bg-hospital-blue-hover transition-colors cursor-pointer">
                                            Guardar Caja
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Aplicación Alpine.js para búsqueda en tiempo real y modal -->
                <div x-data="{
                    search: '{{ $search ?? '' }}',
                    cajas: {{ json_encode($cajas->items()) }},
                    allCajas: {{ json_encode($cajas->items()) }},

                    init() {
                        this.$watch('search', value => {
                            if (value === '') {
                                this.cajas = this.allCajas;
                                return;
                            }

                            value = value.toLowerCase();
                            this.cajas = this.allCajas.filter(caja => {
                                return caja.nombre.toLowerCase().includes(value) ||
                                       caja.descripcion?.toLowerCase().includes(value) ||
                                       caja.ubicacion?.toLowerCase().includes(value) ||
                                       caja.numero_caja.toString().includes(value) ||
                                       caja.estado.toLowerCase().includes(value);
                            });
                        });

                        // Abrir modal automáticamente si hay errores de validación
                        @if($errors->any())
                            this.$nextTick(() => {
                                this.$dispatch('open-modal');
                            });
                        @endif
                    }
                }">
                    <!-- Buscador -->
                    <div class="mb-6">
                        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden shadow-sm search-container">
                            <div class="px-3 py-2 bg-gray-50">
                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input
                                type="text"
                                x-model="search"
                                placeholder="Buscar por nombre, número, ubicación, estado o descripción..."
                                class="w-full px-4 py-2 focus:outline-none focus:border-hospital-blue"
                            >
                            <template x-if="search">
                                <button @click="search = ''" class="px-3 py-2 text-gray-500 hover:text-gray-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Tabla de Cajas -->
                    <div class="overflow-x-auto flex justify-center">
                        <table class="w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                            <thead>
                                <tr class="bg-hospital-blue text-white">
                                    <th class="py-3 px-4 text-left font-semibold">NÚMERO</th>
                                    <th class="py-3 px-4 text-left font-semibold">NOMBRE</th>
                                    <th class="py-3 px-4 text-left font-semibold">UBICACIÓN</th>
                                    <th class="py-3 px-4 text-left font-semibold">ESTADO</th>
                                    <th class="py-3 px-4 text-left font-semibold">DESCRIPCIÓN</th>
                                    <th class="py-3 px-4 text-center font-semibold">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <template x-if="cajas.length === 0">
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-gray-500">
                                            No se encontraron cajas.
                                        </td>
                                    </tr>
                                </template>
                                <template x-for="(caja, index) in cajas" :key="index">
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 whitespace-nowrap font-medium" x-text="caja.numero_caja"></td>
                                        <td class="py-3 px-4 whitespace-nowrap" x-text="caja.nombre"></td>
                                        <td class="py-3 px-4 whitespace-nowrap" x-text="caja.ubicacion || '-'"></td>
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 rounded text-sm"
                                                :class="caja.estado === 'activa' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                                x-text="caja.estado === 'activa' ? 'Activa' : 'Inactiva'">
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 max-w-xs truncate" x-text="caja.descripcion || '-'"></td>
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            <div class="flex justify-center space-x-2">
                                                <button class="p-1 text-blue-600 hover:text-blue-800 transition-colors cursor-pointer"
                                                        title="Editar"
                                                        @click="$store.modals.editCaja.openModal(caja.id)">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                </button>
                                                <button class="p-1 text-red-600 hover:text-red-800 transition-colors cursor-pointer"
                                                        title="Eliminar"
                                                        @click="$store.modals.deleteCaja.openModal(caja.id, caja.nombre)">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-4">
                        <form id="searchForm" action="{{ route('admin.cajas') }}" method="GET" class="hidden">
                            <input type="text" name="search" :value="search">
                        </form>
                        {{ $cajas->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal para Editar Caja -->
    <div
        x-data="editCajaModal()"
        x-cloak
        @keydown.escape.window="isOpen = false"
    >
        <div
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4"
            style="display: none;"
        >
            <div
                @click.away="isOpen = false"
                class="bg-white rounded-lg shadow-2xl w-full max-w-2xl overflow-y-auto max-h-[90vh]"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
            >
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Editar Caja</h2>
                        <button @click="isOpen = false" class="text-gray-500 hover:text-gray-700 cursor-pointer">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Indicador de Carga -->
                    <div x-show="loading" class="flex justify-center items-center py-4">
                        <svg class="animate-spin h-8 w-8 text-hospital-blue" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    <!-- Errores de Validación -->
                    <div x-show="Object.keys(errors).length > 0" class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                        <div class="font-bold">Por favor corrige los siguientes errores:</div>
                        <ul class="list-disc ml-5">
                            <template x-for="(messages, field) in errors" :key="field">
                                <template x-for="(message, i) in messages" :key="i">
                                    <li x-text="message"></li>
                                </template>
                            </template>
                        </ul>
                    </div>

                    <!-- Formulario -->
                    <div x-show="!loading" class="mt-4">
                        <form @submit.prevent="submitForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nombre -->
                                <div>
                                    <label for="edit_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Caja</label>
                                    <input
                                        type="text"
                                        id="edit_nombre"
                                        x-model="cajaData.nombre"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none"
                                        required
                                    >
                                </div>

                                <!-- Número de Caja -->
                                <div>
                                    <label for="edit_numero_caja" class="block text-sm font-medium text-gray-700 mb-1">Número de Caja</label>
                                    <input
                                        type="number"
                                        id="edit_numero_caja"
                                        x-model="cajaData.numero_caja"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none"
                                        min="1"
                                        required
                                    >
                                </div>

                                <!-- Ubicación -->
                                <div>
                                    <label for="edit_ubicacion" class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                                    <input
                                        type="text"
                                        id="edit_ubicacion"
                                        x-model="cajaData.ubicacion"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none"
                                    >
                                </div>

                                <!-- Estado -->
                                <div>
                                    <label for="edit_estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                    <select
                                        id="edit_estado"
                                        x-model="cajaData.estado"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none"
                                        required
                                    >
                                        <option value="activa">Activa</option>
                                        <option value="inactiva">Inactiva</option>
                                    </select>
                                </div>

                                <!-- Descripción -->
                                <div class="md:col-span-2">
                                    <label for="edit_descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                    <textarea
                                        id="edit_descripcion"
                                        x-model="cajaData.descripcion"
                                        rows="3"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none"
                                    ></textarea>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end space-x-3">
                                <button type="button" @click="isOpen = false" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition-colors cursor-pointer">
                                    Cancelar
                                </button>
                                <button type="submit" :disabled="loading" class="bg-hospital-blue text-white px-6 py-2 rounded hover:bg-hospital-blue-hover transition-colors cursor-pointer disabled:opacity-50">
                                    <span x-show="!loading">Guardar Cambios</span>
                                    <span x-show="loading">Guardando...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Eliminar Caja -->
    <div
        x-data="deleteCajaModal()"
        x-cloak
        @keydown.escape.window="isOpen = false"
    >
        <div
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4"
            style="display: none;"
        >
            <div
                @click.away="isOpen = false"
                class="bg-white rounded-lg shadow-2xl w-full max-w-md"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
            >
                <div class="p-6">
                    <div class="mb-4">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="mt-3 text-lg font-medium text-center text-gray-900">¿Eliminar esta caja?</h3>
                        <p class="mt-2 text-sm text-center text-gray-500">
                            Estás a punto de eliminar la caja <span class="font-medium" x-text="cajaNombre"></span>.<br>
                            Esta acción no se puede deshacer.
                        </p>
                    </div>

                    <div class="mt-6 flex justify-center space-x-4">
                        <button @click="isOpen = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition-colors cursor-pointer">
                            Cancelar
                        </button>
                        <button @click="deleteCaja()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors cursor-pointer">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Alpine.js -->
    <script>
        // Store global para los modales
        document.addEventListener('alpine:init', () => {
            Alpine.store('modals', {
                editCaja: {
                    openModal(cajaId) {
                        // Buscar la caja en los datos
                        const cajaData = @json($cajas->items());
                        const caja = cajaData.find(c => c.id === cajaId);

                        if (caja) {
                            // Disparar evento para abrir modal de edición
                            window.dispatchEvent(new CustomEvent('open-edit-caja-modal', {
                                detail: { caja }
                            }));
                        }
                    }
                },
                deleteCaja: {
                    openModal(cajaId, cajaNombre) {
                        // Disparar evento para abrir modal de eliminación
                        window.dispatchEvent(new CustomEvent('open-delete-caja-modal', {
                            detail: { cajaId, cajaNombre }
                        }));
                    }
                }
            });
        });

        // Componente para el modal de edición
        function editCajaModal() {
            return {
                isOpen: false,
                loading: false,
                errors: {},
                cajaId: null,
                cajaData: {
                    nombre: '',
                    numero_caja: '',
                    ubicacion: '',
                    estado: 'activa',
                    descripcion: ''
                },

                init() {
                    // Escuchar evento para abrir modal
                    window.addEventListener('open-edit-caja-modal', (event) => {
                        const { caja } = event.detail;
                        this.cajaId = caja.id;
                        this.cajaData = { ...caja };
                        this.errors = {};
                        this.isOpen = true;
                    });
                },

                submitForm() {
                    // Limpiar errores previos
                    this.errors = {};
                    this.loading = true;

                    // Crear FormData
                    const formData = new FormData();
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Añadir los campos al FormData
                    formData.append('nombre', this.cajaData.nombre);
                    formData.append('numero_caja', this.cajaData.numero_caja);
                    formData.append('ubicacion', this.cajaData.ubicacion || '');
                    formData.append('estado', this.cajaData.estado);
                    formData.append('descripcion', this.cajaData.descripcion || '');
                    formData.append('_method', 'PUT');

                    // Enviar la petición
                    fetch(`/cajas/${this.cajaId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => {
                        this.loading = false;
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            this.isOpen = false;
                            window.location.reload();
                        } else {
                            console.error('Error en la respuesta:', data);
                        }
                    })
                    .catch(error => {
                        this.loading = false;
                        console.error('Error completo:', error);
                        if (error.errors) {
                            this.errors = error.errors;
                        } else if (error.message) {
                            this.errors = { general: [error.message] };
                        } else {
                            this.errors = { general: ['Error al actualizar la caja'] };
                        }
                    });
                }
            }
        }

        // Componente para el modal de eliminación
        function deleteCajaModal() {
            return {
                isOpen: false,
                cajaId: null,
                cajaNombre: '',

                init() {
                    // Escuchar evento para abrir modal
                    window.addEventListener('open-delete-caja-modal', (event) => {
                        const { cajaId, cajaNombre } = event.detail;
                        this.cajaId = cajaId;
                        this.cajaNombre = cajaNombre;
                        this.isOpen = true;
                    });
                },

                deleteCaja() {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/cajas/${this.cajaId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            throw new Error('Error al eliminar caja');
                        }
                    })
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Error al eliminar caja');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al eliminar caja');
                    });
                }
            }
        }
    </script>
</body>
</html>
