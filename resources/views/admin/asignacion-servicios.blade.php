<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Turnero HUV') }} - Asignación de Servicios</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js - Load from CDN directly -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>

    <style>
        :root {
            --hospital-blue: #064b9e;
            --hospital-blue-hover: #053d7a;
        }

        .bg-hospital-blue {
            background-color: var(--hospital-blue);
        }

        .bg-hospital-blue-hover {
            background-color: var(--hospital-blue-hover);
        }

        .text-hospital-blue {
            color: var(--hospital-blue);
        }

        .text-hospital-blue-hover {
            color: var(--hospital-blue-hover);
        }

        .border-hospital-blue {
            border-color: var(--hospital-blue);
        }

        .ring-hospital-blue {
            --tw-ring-color: var(--hospital-blue);
        }

        .focus\:ring-hospital-blue:focus {
            --tw-ring-color: var(--hospital-blue);
        }

        .focus\:border-hospital-blue:focus {
            border-color: var(--hospital-blue);
        }

        .hover\:bg-hospital-blue:hover {
            background-color: var(--hospital-blue);
        }

        .hover\:bg-hospital-blue-hover:hover {
            background-color: var(--hospital-blue-hover);
        }

        .hover\:text-hospital-blue:hover {
            color: var(--hospital-blue);
        }

        .hover\:text-hospital-blue-hover:hover {
            color: var(--hospital-blue-hover);
        }

        .hover\:border-hospital-blue:hover {
            border-color: var(--hospital-blue);
        }

        /* Sidebar styles */
        .sidebar-nav {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .sidebar-item {
            transition: all 0.2s ease;
        }

        .sidebar-item:hover {
            transform: translateX(4px);
        }

        .active-indicator {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        /* Modal styles */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        /* Service item hover effects */
        .service-item {
            transition: all 0.2s ease;
        }

        .service-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Loading animation - CSS Spinner */
        .spinner {
            border: 4px solid #f3f4f6;
            border-top: 4px solid var(--hospital-blue);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        /* Alpine.js cloak */
        [x-cloak] {
            display: none !important;
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
            <div class="text-sm">
                <span class="opacity-75">Bienvenido,</span>
                <span class="font-medium">{{ $user->nombre_completo }}</span>
            </div>
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

                    <!-- Asignación de Servicios - Página Activa -->
                    <a href="{{ route('admin.asignacion-servicios') }}" class="sidebar-item group w-full flex items-center justify-start bg-white/20 text-white p-3 rounded-lg border-l-4 border-white shadow-md relative">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Asignación de Servicios</span>
                        <div class="absolute right-3 w-2 h-2 bg-white rounded-full active-indicator"></div>
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
                    <button class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                        <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Config TV</span>
                    </button>

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
            <div class="bg-white rounded-lg shadow-md p-6 max-w-7xl mx-auto" x-data="asignacionData()">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Asignación de Servicios</h1>
                    <p class="text-gray-600">Gestiona la asignación de servicios a los usuarios asesores</p>
                </div>

                <!-- Selector de usuario -->
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Seleccionar Usuario</h2>
                    <div class="max-w-md">
                        <label for="usuario_select" class="block text-sm font-medium text-gray-700 mb-2">Usuario Asesor</label>
                        <select id="usuario_select" x-model="selectedUserId" @change="loadUserServices()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-transparent">
                            <option value="">Seleccionar usuario...</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->nombre_completo }} ({{ $usuario->cedula }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Contenedor de servicios (solo se muestra cuando hay un usuario seleccionado) -->
                <div x-show="selectedUserId && !loading" x-transition class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Servicios Disponibles -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="p-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                            <h3 class="text-lg font-semibold text-gray-900">Servicios Disponibles</h3>
                            <p class="text-sm text-gray-600 mt-1">Servicios que pueden ser asignados al usuario</p>
                        </div>
                        <div class="p-4 max-h-96 overflow-y-auto">
                            <div x-show="serviciosDisponibles.length === 0" class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p>No hay servicios disponibles para asignar</p>
                            </div>
                            <div class="space-y-2">
                                <template x-for="servicio in serviciosDisponibles" :key="servicio.id">
                                    <div class="service-item p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-hospital-blue hover:bg-blue-50"
                                         @click="asignarServicio(servicio.id)">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900" x-text="servicio.nombre"></h4>
                                                <p class="text-sm text-gray-500" x-show="servicio.servicio_padre" x-text="servicio.servicio_padre?.nombre"></p>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span class="inline-block px-2 py-1 text-xs rounded-full"
                                                          :class="servicio.nivel === 'servicio' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'"
                                                          x-text="servicio.nivel.charAt(0).toUpperCase() + servicio.nivel.slice(1)">
                                                    </span>
                                                    <span class="text-xs text-gray-400" x-show="servicio.codigo" x-text="'(' + servicio.codigo + ')'"></span>
                                                </div>
                                            </div>
                                            <button class="text-hospital-blue hover:text-hospital-blue-hover p-1 rounded hover:bg-blue-100">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios Asignados -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="p-4 border-b border-gray-200 bg-hospital-blue text-white rounded-t-lg">
                            <h3 class="text-lg font-semibold">Servicios Asignados</h3>
                            <p class="text-sm opacity-90 mt-1">Servicios actualmente asignados al usuario</p>
                        </div>
                        <div class="p-4 max-h-96 overflow-y-auto">
                            <div x-show="serviciosAsignados.length === 0" class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p>No hay servicios asignados</p>
                            </div>
                            <div class="space-y-2">
                                <template x-for="servicio in serviciosAsignados" :key="servicio.id">
                                    <div class="service-item p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-red-400 hover:bg-red-50"
                                         @click="desasignarServicio(servicio.id)">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900" x-text="servicio.nombre"></h4>
                                                <p class="text-sm text-gray-500" x-show="servicio.servicio_padre" x-text="servicio.servicio_padre?.nombre"></p>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span class="inline-block px-2 py-1 text-xs rounded-full"
                                                          :class="servicio.nivel === 'servicio' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'"
                                                          x-text="servicio.nivel.charAt(0).toUpperCase() + servicio.nivel.slice(1)">
                                                    </span>
                                                    <span class="text-xs text-gray-400" x-show="servicio.codigo" x-text="'(' + servicio.codigo + ')'"></span>
                                                </div>
                                            </div>
                                            <button class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-100">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading state con spinner CSS -->
                <div x-show="loading" x-transition class="text-center py-12">
                    <div class="inline-flex items-center">
                        <div class="spinner mr-3"></div>
                        <span class="text-lg text-gray-600">Cargando servicios...</span>
                    </div>
                </div>
        </main>
    </div>

    <!-- Modal de Error/Éxito -->
    <div
        x-data="modalData()"
        x-cloak
        @keydown.escape.window="showModal = false"
    >
        <div
            x-show="showModal"
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
                @click.away="showModal = false"
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
                        <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-full"
                             :class="modalType === 'success' ? 'bg-green-100' : 'bg-red-100'">
                            <svg class="w-6 h-6" :class="modalType === 'success' ? 'text-green-600' : 'text-red-600'"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="modalType === 'success'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                <path x-show="modalType === 'error'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="mt-3 text-lg font-medium text-center text-gray-900" x-text="modalTitle"></h3>
                        <p class="mt-2 text-sm text-center text-gray-500" x-text="modalMessage"></p>
                    </div>

                    <div class="mt-6 flex justify-center">
                        <button @click="showModal = false" class="px-4 py-2 bg-hospital-blue text-white rounded hover:bg-hospital-blue-hover transition-colors cursor-pointer">
                            Entendido
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para el modal de mensajes
        function modalData() {
            return {
                showModal: false,
                modalType: 'success', // 'success' o 'error'
                modalTitle: '',
                modalMessage: '',
                init() {
                    // Escuchar eventos globales para mostrar modales
                    window.addEventListener('show-success', (event) => {
                        this.modalType = 'success';
                        this.modalTitle = event.detail.title;
                        this.modalMessage = event.detail.message;
                        this.showModal = true;
                    });

                    window.addEventListener('show-error', (event) => {
                        this.modalType = 'error';
                        this.modalTitle = event.detail.title;
                        this.modalMessage = event.detail.message;
                        this.showModal = true;
                    });
                }
            }
        }

        // Función principal para la asignación de servicios
        function asignacionData() {
            return {
                selectedUserId: '',
                selectedUser: null,
                serviciosAsignados: [],
                serviciosDisponibles: [],
                loading: false,

                async loadUserServices() {
                    if (!this.selectedUserId) {
                        this.serviciosAsignados = [];
                        this.serviciosDisponibles = [];
                        this.selectedUser = null;
                        return;
                    }

                    this.loading = true;

                    try {
                        const response = await fetch(`/asignacion-servicios/usuario/${this.selectedUserId}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error('Error al cargar los servicios del usuario');
                        }

                        const data = await response.json();
                        this.selectedUser = data.usuario;
                        this.serviciosAsignados = data.serviciosAsignados;
                        this.serviciosDisponibles = data.serviciosDisponibles;

                    } catch (error) {
                        console.error('Error:', error);
                        window.dispatchEvent(new CustomEvent('show-error', {
                            detail: {
                                title: 'Error de conexión',
                                message: 'No se pudieron cargar los servicios del usuario. Verifique su conexión a internet.'
                            }
                        }));
                    } finally {
                        this.loading = false;
                    }
                },

                async asignarServicio(servicioId) {
                    if (!this.selectedUserId) return;

                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const response = await fetch('/asignacion-servicios/asignar', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                user_id: this.selectedUserId,
                                servicio_id: servicioId
                            })
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            // Recargar los servicios para actualizar las listas
                            await this.loadUserServices();

                            window.dispatchEvent(new CustomEvent('show-success', {
                                detail: {
                                    title: 'Servicio asignado',
                                    message: result.message
                                }
                            }));
                        } else {
                            window.dispatchEvent(new CustomEvent('show-error', {
                                detail: {
                                    title: 'Error al asignar servicio',
                                    message: result.message || 'Error desconocido'
                                }
                            }));
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        window.dispatchEvent(new CustomEvent('show-error', {
                            detail: {
                                title: 'Error de conexión',
                                message: 'No se pudo asignar el servicio. Verifique su conexión a internet.'
                            }
                        }));
                    }
                },

                async desasignarServicio(servicioId) {
                    if (!this.selectedUserId) return;

                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const response = await fetch('/asignacion-servicios/desasignar', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                user_id: this.selectedUserId,
                                servicio_id: servicioId
                            })
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            // Recargar los servicios para actualizar las listas
                            await this.loadUserServices();

                            window.dispatchEvent(new CustomEvent('show-success', {
                                detail: {
                                    title: 'Servicio desasignado',
                                    message: result.message
                                }
                            }));
                        } else {
                            window.dispatchEvent(new CustomEvent('show-error', {
                                detail: {
                                    title: 'Error al desasignar servicio',
                                    message: result.message || 'Error desconocido'
                                }
                            }));
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        window.dispatchEvent(new CustomEvent('show-error', {
                            detail: {
                                title: 'Error de conexión',
                                message: 'No se pudo desasignar el servicio. Verifique su conexión a internet.'
                            }
                        }));
                    }
                }
            }
        }
    </script>
</body>
</html>
