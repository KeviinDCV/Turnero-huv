<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Turnero HUV') }} - Crear Usuario</title>
    
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
        <aside class="w-72 bg-hospital-blue text-white min-h-screen shadow-xl flex flex-col"
               :class="{ 'fixed inset-y-0 left-0 z-50 transform transition-transform duration-300 ease-in-out': true,
                        'translate-x-0': sidebarOpen,
                        '-translate-x-full': !sidebarOpen }"
               x-show="sidebarOpen || window.innerWidth >= 768"
               @click.away="if (window.innerWidth < 768) sidebarOpen = false">

            <!-- Header del Sidebar -->
            <div class="p-6 border-b border-white/20 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md p-1">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo HUV" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">HUV Admin</h2>
                            <p class="text-sm text-blue-200">Panel de Control</p>
                        </div>
                    </div>
                    <!-- Botón cerrar para móviles -->
                    <button @click="sidebarOpen = false" class="md:hidden text-white hover:bg-white/10 p-2 rounded">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenido del Sidebar -->
            <div class="flex-1 p-4 pb-20 overflow-y-auto">
                <h3 class="text-sm font-semibold text-blue-200 uppercase tracking-wider mb-4">{{ strtoupper($user->rol) }}</h3>
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Inicio
                    </a>
                    <button class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        Módulo
                    </button>
                    <button class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Servicios
                    </button>
                    <button class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Asignación de Servicios
                    </button>
                    <a href="{{ route('admin.users') }}" class="w-full flex items-center justify-start text-white bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Usuarios
                    </a>
                    <button class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Configuración
                    </button>
                    <button class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Gráficos
                    </button>
                    <button class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Reportes
                    </button>
                    <button class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        ConfigTv
                    </button>
                    <button class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Clientes
                    </button>
                    <button class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Preguntas
                    </button>
                    <button class="w-full flex items-center justify-start text-white hover:bg-hospital-blue-hover p-3 rounded transition-colors">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Horas
                    </button>
                </nav>
            </div>

            <!-- Footer del Sidebar -->
            <div class="p-4 border-t border-white/20 flex-shrink-0">
                <div class="text-sm text-blue-200">
                    <div class="font-semibold">Turnero HUV®</div>
                    <div class="text-xs">Hospital Universitario del Valle</div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Crear Nuevo Usuario</h1>
                    <a href="{{ route('admin.users') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition-colors">
                        Volver
                    </a>
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
                
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre Completo -->
                        <div>
                            <label for="nombre_completo" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                            <input 
                                type="text" 
                                id="nombre_completo" 
                                name="nombre_completo" 
                                value="{{ old('nombre_completo') }}" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                required
                            >
                        </div>

                        <!-- Cédula -->
                        <div>
                            <label for="cedula" class="block text-sm font-medium text-gray-700 mb-1">Cédula</label>
                            <input 
                                type="text" 
                                id="cedula" 
                                name="cedula" 
                                value="{{ old('cedula') }}" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                required
                            >
                        </div>
                        
                        <!-- Correo Electrónico -->
                        <div>
                            <label for="correo_electronico" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                            <input 
                                type="email" 
                                id="correo_electronico" 
                                name="correo_electronico" 
                                value="{{ old('correo_electronico') }}" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                required
                            >
                        </div>
                        
                        <!-- Nombre de Usuario -->
                        <div>
                            <label for="nombre_usuario" class="block text-sm font-medium text-gray-700 mb-1">Nombre de Usuario</label>
                            <input 
                                type="text" 
                                id="nombre_usuario" 
                                name="nombre_usuario" 
                                value="{{ old('nombre_usuario') }}" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                required
                            >
                        </div>
                        
                        <!-- Rol -->
                        <div>
                            <label for="rol" class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                            <select 
                                id="rol" 
                                name="rol" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                required
                            >
                                <option value="">Seleccionar rol</option>
                                <option value="Administrador" {{ old('rol') === 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="Asesor" {{ old('rol') === 'Asesor' ? 'selected' : '' }}>Asesor</option>
                            </select>
                        </div>
                        
                        <!-- Contraseña -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                required
                            >
                            <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres</p>
                        </div>
                        
                        <!-- Confirmar Contraseña -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hospital-blue"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-hospital-blue text-white px-6 py-2 rounded hover:bg-hospital-blue-hover transition-colors">
                            Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html> 