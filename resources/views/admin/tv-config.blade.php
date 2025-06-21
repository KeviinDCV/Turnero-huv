<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración TV - Turnero HUV</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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

        /* Estilo para modal overlay - igual que en users.blade.php */
        .modal-overlay {
            background-color: rgba(100, 116, 139, 0.25) !important;
            backdrop-filter: blur(2px) !important;
            -webkit-backdrop-filter: blur(2px) !important;
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
            50% { opacity: 0.5; }
        }

        /* Estilos para el formulario */
        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(6, 75, 158, 0.15);
        }

        /* Estilos para tabs */
        .tab-content {
            display: block;
        }

        .tab-content.hidden {
            display: none;
        }

        /* Estilos para multimedia */
        .file-preview {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }

        .video-preview {
            max-width: 100px;
            max-height: 100px;
        }

        .sortable-item {
            cursor: move;
        }

        .sortable-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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
            <span class="text-sm">Bienvenido, <span class="font-semibold">{{ $user->nombre_completo }}</span></span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-medium transition-colors">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="bg-hospital-blue text-white w-64 min-h-screen p-4 fixed md:relative z-30 transform transition-transform duration-300 ease-in-out"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            
            <!-- Overlay para móviles -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" 
                 class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"></div>

            <div class="space-y-2 relative z-30">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                    <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>

                <!-- Separador -->
                <div class="py-2">
                    <div class="border-t border-white/20"></div>
                    <p class="text-xs text-blue-200 mt-2 px-3 font-medium uppercase tracking-wider">Gestión</p>
                </div>

                <!-- Usuarios -->
                <a href="{{ route('admin.users') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                    <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">Usuarios</span>
                </a>

                <!-- Cajas -->
                <a href="{{ route('admin.cajas') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                    <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-sm font-medium">Cajas</span>
                </a>

                <!-- Servicios -->
                <a href="{{ route('admin.servicios') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                    <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="text-sm font-medium">Servicios</span>
                </a>

                <!-- Asignación de Servicios -->
                <a href="{{ route('admin.asignacion-servicios') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                    <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">Asignación Servicios</span>
                </a>

                <!-- Separador -->
                <div class="py-2">
                    <div class="border-t border-white/20"></div>
                    <p class="text-xs text-blue-200 mt-2 px-3 font-medium uppercase tracking-wider">Sistema</p>
                </div>

                <!-- Reportes -->
                <button class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                    <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm font-medium">Reportes</span>
                </button>

                <!-- Config TV - ACTIVO -->
                <a href="{{ route('admin.tv-config') }}" class="sidebar-item group w-full flex items-center justify-start text-white bg-white/20 p-3 rounded-lg transition-all duration-200 hover:translate-x-1 active-indicator">
                    <svg class="mr-3 h-5 w-5 text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-medium">Config TV</span>
                </a>

                <!-- Separador -->
                <div class="py-2">
                    <div class="border-t border-white/20"></div>
                    <p class="text-xs text-blue-200 mt-2 px-3 font-medium uppercase tracking-wider">Otros</p>
                </div>

                <!-- Configuración -->
                <button class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                    <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">Configuración</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-0">
            <div class="p-4 md:p-6">
                <div class="bg-white rounded-lg shadow-md p-4 md:p-6 max-w-4xl mx-auto">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Configuración del TV</h1>
                        <a href="{{ route('tv.display') }}" target="_blank" class="bg-hospital-blue hover:bg-hospital-blue-hover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Ver TV
                        </a>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button onclick="showTab('ticker')" id="ticker-tab" class="tab-button border-b-2 border-hospital-blue text-hospital-blue py-2 px-1 text-sm font-medium">
                                Mensaje Ticker
                            </button>
                            <button onclick="showTab('multimedia')" id="multimedia-tab" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2 px-1 text-sm font-medium">
                                Multimedia
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content: Ticker -->
                    <div id="ticker-content" class="tab-content">
                        <!-- Formulario de configuración del ticker -->
                        <form id="tvConfigForm" method="POST" action="{{ route('admin.tv-config.update') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Mensaje del ticker -->
                        <div>
                            <label for="ticker_message" class="block text-sm font-medium text-gray-700 mb-2">
                                Mensaje del Ticker
                            </label>
                            <textarea 
                                id="ticker_message" 
                                name="ticker_message" 
                                rows="4" 
                                class="form-input w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-hospital-blue"
                                placeholder="Ingrese el mensaje que aparecerá en el ticker del TV..."
                                required
                            >{{ old('ticker_message', $tvConfig->ticker_message) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Este mensaje se mostrará corriendo de derecha a izquierda en la parte inferior del TV.</p>
                        </div>

                        <!-- Velocidad del ticker -->
                        <div>
                            <label for="ticker_speed" class="block text-sm font-medium text-gray-700 mb-2">
                                Velocidad del Ticker (segundos)
                            </label>
                            <div class="flex items-center space-x-4">
                                <input 
                                    type="range" 
                                    id="ticker_speed" 
                                    name="ticker_speed" 
                                    min="10" 
                                    max="120" 
                                    value="{{ old('ticker_speed', $tvConfig->ticker_speed) }}"
                                    class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                    oninput="updateSpeedValue(this.value)"
                                >
                                <span id="speed_value" class="text-sm font-medium text-gray-700 min-w-[60px]">{{ $tvConfig->ticker_speed }}s</span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Controla qué tan rápido se mueve el mensaje. Menor valor = más rápido.</p>
                        </div>

                        <!-- Estado del ticker -->
                        <div>
                            <label class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    name="ticker_enabled" 
                                    value="1"
                                    {{ old('ticker_enabled', $tvConfig->ticker_enabled) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-hospital-blue shadow-sm focus:border-hospital-blue focus:ring focus:ring-hospital-blue focus:ring-opacity-50"
                                >
                                <span class="ml-2 text-sm font-medium text-gray-700">Activar ticker</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Desmarque para ocultar completamente el ticker del TV.</p>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-3 pt-4 border-t">
                            <button 
                                type="button" 
                                onclick="resetForm()"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-hospital-blue transition-colors"
                            >
                                Restablecer
                            </button>
                            <button
                                type="submit"
                                id="submitBtn"
                                class="px-4 py-2 bg-hospital-blue hover:bg-hospital-blue-hover text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-hospital-blue transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span id="submitText">Guardar Configuración</span>
                                <span id="loadingText" class="hidden">Guardando...</span>
                            </button>
                        </div>
                        </form>
                    </div>

                    <!-- Tab Content: Multimedia -->
                    <div id="multimedia-content" class="tab-content hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-semibold text-gray-800">Gestión de Multimedia</h2>
                            @if($multimedia->count() > 0)
                            <button onclick="showUploadModal()" class="bg-hospital-blue hover:bg-hospital-blue-hover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Subir Archivo
                            </button>
                            @endif
                        </div>

                        <!-- Lista de multimedia -->
                        <div id="multimediaList" class="space-y-4">
                            @forelse($multimedia as $item)
                                <div class="sortable-item bg-gray-50 border border-gray-200 rounded-lg p-4 transition-all duration-200" data-id="{{ $item->id }}" data-order="{{ $item->orden }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <!-- Drag handle -->
                                            <div class="cursor-move text-gray-400 hover:text-gray-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                                </svg>
                                            </div>

                                            <!-- Preview -->
                                            <div class="flex-shrink-0">
                                                @if($item->tipo === 'imagen')
                                                    <img src="{{ $item->url }}" alt="{{ $item->nombre }}" class="file-preview rounded border">
                                                @else
                                                    <video class="video-preview rounded border" muted>
                                                        <source src="{{ $item->url }}" type="video/{{ $item->extension }}">
                                                    </video>
                                                @endif
                                            </div>

                                            <!-- Info -->
                                            <div class="flex-1">
                                                <h3 class="font-medium text-gray-900">{{ $item->nombre }}</h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ ucfirst($item->tipo) }} • {{ $item->extension }} • {{ $item->tamaño_formateado }}
                                                    @if($item->tipo === 'imagen')
                                                        • {{ $item->duracion }}s
                                                    @endif
                                                </p>
                                                <p class="text-xs text-gray-400">Orden: {{ $item->orden }}</p>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center space-x-2">
                                            <!-- Toggle activo -->
                                            <button onclick="toggleActive({{ $item->id }})"
                                                    class="px-3 py-1 rounded text-xs font-medium transition-colors {{ $item->activo ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                                {{ $item->activo ? 'Activo' : 'Inactivo' }}
                                            </button>

                                            <!-- Eliminar -->
                                            <button onclick="confirmDelete({{ $item->id }}, '{{ addslashes($item->nombre) }}')"
                                                    class="px-3 py-1 bg-red-100 text-red-800 rounded text-xs font-medium hover:bg-red-200 transition-colors">
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V1a1 1 0 011-1h2a1 1 0 011 1v3m0 0h8m-8 0V1"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay archivos multimedia</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comience subiendo imágenes o videos para mostrar en el TV.</p>
                                    <div class="mt-6">
                                        <button onclick="showUploadModal()" class="bg-hospital-blue hover:bg-hospital-blue-hover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center mx-auto">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Subir Archivo
                                        </button>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal de éxito -->
    <div id="successModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md">
            <div class="p-6">
                <div class="mb-4">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="mt-3 text-lg font-medium text-center text-gray-900">Configuración Guardada</h3>
                    <p class="mt-2 text-sm text-center text-gray-500">
                        La configuración del TV se ha actualizado correctamente.
                    </p>
                </div>

                <div class="mt-6 flex justify-center">
                    <button onclick="closeSuccessModal()" class="px-4 py-2 bg-hospital-blue text-white rounded hover:bg-hospital-blue-hover transition-colors cursor-pointer">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variable global para almacenar el ID del elemento a eliminar
        let deleteItemId = null;

        // Actualizar valor de velocidad en tiempo real
        function updateSpeedValue(value) {
            document.getElementById('speed_value').textContent = value + 's';
        }

        // Restablecer formulario
        function resetForm() {
            document.getElementById('tvConfigForm').reset();
            updateSpeedValue({{ $tvConfig->ticker_speed }});
        }

        // Mostrar modal de éxito
        function showSuccessModal() {
            document.getElementById('successModal').style.display = 'flex';
        }

        // Cerrar modal de éxito
        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
        }

        // Función para mostrar pestañas
        function showTab(tabName) {
            // Ocultar todos los contenidos de pestañas
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Remover clases activas de todos los botones de pestañas
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('border-hospital-blue', 'text-hospital-blue');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Mostrar el contenido de la pestaña seleccionada
            const selectedContent = document.getElementById(tabName + '-content');
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }

            // Activar el botón de la pestaña seleccionada
            const selectedButton = document.getElementById(tabName + '-tab');
            if (selectedButton) {
                selectedButton.classList.remove('border-transparent', 'text-gray-500');
                selectedButton.classList.add('border-hospital-blue', 'text-hospital-blue');
            }
        }

        // Función para mostrar modal de subida de archivos
        function showUploadModal() {
            document.getElementById('uploadModal').style.display = 'flex';
        }

        // Cerrar modal de subida
        function closeUploadModal() {
            document.getElementById('uploadModal').style.display = 'none';
            document.getElementById('uploadForm').reset();
            hideUploadProgress();
            hideFilePreview();
        }

        // Subir archivo
        function uploadFile() {
            const form = document.getElementById('uploadForm');

            // Validar que todos los campos estén llenos antes de enviar
            const archivo = document.getElementById('archivo').files[0];
            const nombre = document.getElementById('nombre').value.trim();
            const duracion = document.getElementById('duracion').value;

            if (!archivo) {
                showUploadErrorModal('Por favor seleccione un archivo');
                return;
            }

            if (!nombre) {
                showUploadErrorModal('Por favor ingrese un nombre para el archivo');
                return;
            }

            if (!duracion || duracion < 1 || duracion > 300) {
                showUploadErrorModal('La duración debe estar entre 1 y 300 segundos');
                return;
            }

            const formData = new FormData(form);

            // Debug: Mostrar datos que se están enviando
            console.log('Datos del formulario:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            showUploadProgress();

            fetch('{{ route("admin.tv-config.multimedia.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    closeUploadModal();
                    showUploadSuccessModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    hideUploadProgress();
                    let errorMessage = data.message || 'Error al subir el archivo';

                    // Si hay errores de validación específicos, mostrarlos
                    if (data.errors) {
                        const errorList = Object.values(data.errors).flat();
                        errorMessage = 'Errores de validación: ' + errorList.join(', ');
                    }

                    console.error('Error del servidor:', data);
                    showUploadErrorModal(errorMessage);
                }
            })
            .catch(error => {
                hideUploadProgress();
                console.error('Error:', error);
                showUploadErrorModal('Error de conexión al subir el archivo: ' + error.message);
            });
        }

        // Mostrar progreso de subida
        function showUploadProgress() {
            document.getElementById('uploadProgress').style.display = 'block';
            document.getElementById('uploadBtn').disabled = true;
            document.getElementById('uploadBtnText').style.display = 'none';
            document.getElementById('uploadBtnLoading').style.display = 'inline';
        }

        // Ocultar progreso de subida
        function hideUploadProgress() {
            document.getElementById('uploadProgress').style.display = 'none';
            document.getElementById('uploadBtn').disabled = false;
            document.getElementById('uploadBtnText').style.display = 'inline';
            document.getElementById('uploadBtnLoading').style.display = 'none';
        }

        // Mostrar modal de éxito de subida
        function showUploadSuccessModal() {
            document.getElementById('uploadSuccessModal').style.display = 'flex';
        }

        // Cerrar modal de éxito de subida
        function closeUploadSuccessModal() {
            document.getElementById('uploadSuccessModal').style.display = 'none';
        }

        // Mostrar modal de error de subida
        function showUploadErrorModal(message) {
            document.getElementById('uploadErrorMessage').textContent = message;
            document.getElementById('uploadErrorModal').style.display = 'flex';
        }

        // Cerrar modal de error de subida
        function closeUploadErrorModal() {
            document.getElementById('uploadErrorModal').style.display = 'none';
        }

        // Confirmar eliminación
        function confirmDelete(id, nombre) {
            deleteItemId = id;
            document.getElementById('deleteFileName').textContent = nombre;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        // Cerrar modal de eliminación
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            deleteItemId = null;
        }

        // Eliminar archivo
        function deleteFile() {
            if (!deleteItemId) return;

            fetch(`{{ url('/tv-config/multimedia') }}/${deleteItemId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeDeleteModal();
                    showDeleteSuccessModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showDeleteErrorModal(data.message || 'Error al eliminar el archivo');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showDeleteErrorModal('Error de conexión al eliminar el archivo');
            });
        }

        // Mostrar modal de éxito de eliminación
        function showDeleteSuccessModal() {
            document.getElementById('deleteSuccessModal').style.display = 'flex';
        }

        // Cerrar modal de éxito de eliminación
        function closeDeleteSuccessModal() {
            document.getElementById('deleteSuccessModal').style.display = 'none';
        }

        // Mostrar modal de error de eliminación
        function showDeleteErrorModal(message) {
            document.getElementById('deleteErrorMessage').textContent = message;
            document.getElementById('deleteErrorModal').style.display = 'flex';
        }

        // Cerrar modal de error de eliminación
        function closeDeleteErrorModal() {
            document.getElementById('deleteErrorModal').style.display = 'none';
        }

        // Manejar selección de archivo
        function handleFileSelect(input) {
            const file = input.files[0];
            if (!file) {
                hideFilePreview();
                // Limpiar campo nombre también
                document.getElementById('nombre').value = '';
                return;
            }

            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
            const fileExtension = fileName.split('.').pop().toLowerCase();

            // Determinar si es imagen o video
            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            const videoExtensions = ['mp4', 'mov', 'avi'];

            const isImage = imageExtensions.includes(fileExtension);
            const isVideo = videoExtensions.includes(fileExtension);

            if (!isImage && !isVideo) {
                alert('Formato de archivo no válido. Use: JPG, PNG, GIF, MP4, MOV, AVI');
                input.value = '';
                hideFilePreview();
                document.getElementById('nombre').value = '';
                return;
            }

            // Llenar automáticamente el campo nombre con el nombre del archivo (sin extensión)
            const fileNameWithoutExtension = fileName.substring(0, fileName.lastIndexOf('.'));
            document.getElementById('nombre').value = fileNameWithoutExtension;

            // Mostrar preview
            showFilePreview(file, fileName, fileSize, isImage, isVideo);

            // Configurar campo de duración según el tipo
            if (isImage) {
                setupImageDuration();
            } else if (isVideo) {
                setupVideoDuration(file);
            }
        }

        // Mostrar preview del archivo
        function showFilePreview(file, fileName, fileSize, isImage, isVideo) {
            const preview = document.getElementById('filePreview');
            const container = document.getElementById('previewContainer');
            const nameElement = document.getElementById('fileName');
            const infoElement = document.getElementById('fileInfo');

            nameElement.textContent = fileName;
            infoElement.textContent = `${fileSize} MB • ${isImage ? 'Imagen' : 'Video'}`;

            // Crear preview visual
            container.innerHTML = '';

            if (isImage) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'w-12 h-12 object-cover rounded';
                img.onload = () => URL.revokeObjectURL(img.src);
                container.appendChild(img);
            } else {
                const videoIcon = document.createElement('div');
                videoIcon.className = 'w-12 h-12 bg-blue-100 rounded flex items-center justify-center';
                videoIcon.innerHTML = `
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                `;
                container.appendChild(videoIcon);
            }

            preview.classList.remove('hidden');
        }

        // Ocultar preview del archivo
        function hideFilePreview() {
            document.getElementById('filePreview').classList.add('hidden');
            resetDurationField();
        }

        // Configurar duración para imágenes
        function setupImageDuration() {
            const duracionInput = document.getElementById('duracion');
            const duracionLabel = document.getElementById('duracionLabel');
            const duracionHelp = document.getElementById('duracionHelp');

            duracionLabel.textContent = 'Duración (segundos)';
            duracionHelp.textContent = 'Entre 1 y 300 segundos - Tiempo que se mostrará la imagen';

            duracionInput.disabled = false;
            duracionInput.readOnly = false;
            duracionInput.value = 10;
            duracionInput.min = 1;
            duracionInput.max = 300;
            duracionInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-transparent';
        }

        // Configurar duración para videos
        function setupVideoDuration(file) {
            const duracionInput = document.getElementById('duracion');
            const duracionLabel = document.getElementById('duracionLabel');
            const duracionHelp = document.getElementById('duracionHelp');

            duracionLabel.textContent = 'Duración (automática)';
            duracionHelp.textContent = 'La duración se detectará automáticamente del video';

            // Crear elemento video temporal para obtener duración
            const video = document.createElement('video');
            video.preload = 'metadata';

            video.onloadedmetadata = function() {
                const duration = Math.ceil(video.duration);
                duracionInput.value = duration;
                // NO deshabilitar el campo para que se envíe en el formulario
                duracionInput.readOnly = true;
                duracionInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed';

                duracionHelp.textContent = `Duración detectada: ${duration} segundos`;

                // Limpiar objeto URL
                URL.revokeObjectURL(video.src);
            };

            video.onerror = function() {
                duracionHelp.textContent = 'No se pudo detectar la duración. Ingrese manualmente.';
                duracionInput.readOnly = false;
                duracionInput.value = 30;
                duracionInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-transparent';
                URL.revokeObjectURL(video.src);
            };

            video.src = URL.createObjectURL(file);
        }

        // Resetear campo de duración
        function resetDurationField() {
            const duracionInput = document.getElementById('duracion');
            const duracionLabel = document.getElementById('duracionLabel');
            const duracionHelp = document.getElementById('duracionHelp');

            duracionLabel.textContent = 'Duración (segundos)';
            duracionHelp.textContent = 'Entre 1 y 300 segundos';

            duracionInput.disabled = false;
            duracionInput.readOnly = false;
            duracionInput.value = 10;
            duracionInput.min = 1;
            duracionInput.max = 300;
            duracionInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-transparent';
        }

        // Inicializar la primera pestaña como activa al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            showTab('ticker');
        });

        // Manejar envío del formulario
        document.getElementById('tvConfigForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingText = document.getElementById('loadingText');

            // Mostrar estado de carga
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            loadingText.classList.remove('hidden');

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showSuccessModal();
                } else {
                    alert('Error al guardar la configuración: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión: ' + error.message);
            })
            .finally(() => {
                // Restaurar estado del botón
                submitBtn.disabled = false;
                submitText.classList.remove('hidden');
                loadingText.classList.add('hidden');
            });
        });

        // Mostrar mensaje de éxito si viene de redirección
        @if(session('success'))
            showSuccessModal();
        @endif
    </script>

    <!-- Modal de subida de archivos -->
    <div id="uploadModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md">
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-center text-gray-900">Subir Archivo Multimedia</h3>
                    <p class="mt-2 text-sm text-center text-gray-500">
                        Sube imágenes (JPG, PNG, GIF) o videos (MP4, MOV, AVI) para mostrar en el TV.
                    </p>
                </div>

                <form id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="archivo" class="block text-sm font-medium text-gray-700 mb-1">Archivo</label>
                            <input type="file" id="archivo" name="archivo" accept=".jpg,.jpeg,.png,.gif,.mp4,.mov,.avi" required
                                   onchange="handleFileSelect(this)"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Máximo 50MB. Formatos: JPG, PNG, GIF, MP4, MOV, AVI</p>

                            <!-- Preview del archivo -->
                            <div id="filePreview" class="mt-3 hidden">
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-md">
                                    <div id="previewContainer" class="flex-shrink-0"></div>
                                    <div class="flex-1">
                                        <p id="fileName" class="text-sm font-medium text-gray-900"></p>
                                        <p id="fileInfo" class="text-xs text-gray-500"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                            <input type="text" id="nombre" name="nombre" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-transparent"
                                   placeholder="Nombre descriptivo del archivo">
                        </div>

                        <div>
                            <label for="duracion" class="block text-sm font-medium text-gray-700 mb-1">
                                <span id="duracionLabel">Duración (segundos)</span>
                            </label>
                            <input type="number" id="duracion" name="duracion" min="1" max="300" value="10" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-transparent"
                                   placeholder="Tiempo de visualización en segundos">
                            <p id="duracionHelp" class="mt-1 text-xs text-gray-500">Entre 1 y 300 segundos</p>
                        </div>
                    </div>

                    <!-- Barra de progreso -->
                    <div id="uploadProgress" class="mt-4" style="display: none;">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-hospital-blue h-2 rounded-full animate-pulse" style="width: 100%"></div>
                        </div>
                        <p id="progressText" class="text-sm text-gray-600 mt-1">Subiendo archivo...</p>
                    </div>
                </form>

                <div class="mt-6 flex justify-center space-x-3">
                    <button onclick="closeUploadModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-hospital-blue transition-colors">
                        Cancelar
                    </button>
                    <button onclick="uploadFile()" id="uploadBtn" class="px-4 py-2 bg-hospital-blue text-white rounded-md text-sm font-medium hover:bg-hospital-blue-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-hospital-blue transition-colors">
                        <span id="uploadBtnText">Subir Archivo</span>
                        <span id="uploadBtnLoading" class="hidden">Subiendo...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de éxito de subida -->
    <div id="uploadSuccessModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md">
            <div class="p-6">
                <div class="mb-4">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-center text-gray-900 mt-2">¡Archivo subido!</h3>
                    <p class="mt-2 text-sm text-center text-gray-500">
                        El archivo se ha subido correctamente y estará disponible en el TV.
                    </p>
                </div>

                <div class="mt-6 flex justify-center">
                    <button onclick="closeUploadSuccessModal()" class="px-4 py-2 bg-hospital-blue text-white rounded hover:bg-hospital-blue-hover transition-colors cursor-pointer">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de error de subida -->
    <div id="uploadErrorModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md">
            <div class="p-6">
                <div class="mb-4">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-center text-gray-900 mt-2">Error al subir archivo</h3>
                    <p id="uploadErrorMessage" class="mt-2 text-sm text-center text-gray-500">
                        Ha ocurrido un error al subir el archivo.
                    </p>
                </div>

                <div class="mt-6 flex justify-center">
                    <button onclick="closeUploadErrorModal()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors cursor-pointer">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div id="deleteModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md">
            <div class="p-6">
                <div class="mb-4">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-lg font-medium text-center text-gray-900">¿Eliminar este archivo?</h3>
                    <p class="mt-2 text-sm text-center text-gray-500">
                        Estás a punto de eliminar el archivo <span class="font-medium" id="deleteFileName"></span>.<br>
                        Esta acción no se puede deshacer.
                    </p>
                </div>

                <div class="mt-6 flex justify-center space-x-4">
                    <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition-colors cursor-pointer">
                        Cancelar
                    </button>
                    <button onclick="deleteFile()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors cursor-pointer">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de éxito de eliminación -->
    <div id="deleteSuccessModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md">
            <div class="p-6">
                <div class="mb-4">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-center text-gray-900 mt-2">¡Archivo eliminado!</h3>
                    <p class="mt-2 text-sm text-center text-gray-500">
                        El archivo se ha eliminado correctamente.
                    </p>
                </div>

                <div class="mt-6 flex justify-center">
                    <button onclick="closeDeleteSuccessModal()" class="px-4 py-2 bg-hospital-blue text-white rounded hover:bg-hospital-blue-hover transition-colors cursor-pointer">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de error de eliminación -->
    <div id="deleteErrorModal" class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md">
            <div class="p-6">
                <div class="mb-4">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-center text-gray-900 mt-2">Error al eliminar archivo</h3>
                    <p id="deleteErrorMessage" class="mt-2 text-sm text-center text-gray-500">
                        Ha ocurrido un error al eliminar el archivo.
                    </p>
                </div>

                <div class="mt-6 flex justify-center">
                    <button onclick="closeDeleteErrorModal()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors cursor-pointer">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
