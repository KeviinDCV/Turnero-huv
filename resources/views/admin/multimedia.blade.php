<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Multimedia - Turnero HUV</title>
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

        /* Estilo para modal overlay */
        .modal-overlay {
            background-color: rgba(100, 116, 139, 0.25) !important;
            backdrop-filter: blur(2px) !important;
            -webkit-backdrop-filter: blur(2px) !important;
        }

        /* Estilos para drag and drop */
        .drag-over {
            border-color: #064b9e !important;
            background-color: rgba(6, 75, 158, 0.1) !important;
        }

        .sortable-item {
            cursor: move;
        }

        .sortable-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Estilos para preview de archivos */
        .file-preview {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }

        .video-preview {
            max-width: 100px;
            max-height: 100px;
        }

        /* Animaciones */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .pulse-success {
            animation: pulseSuccess 0.6s ease-in-out;
        }

        @keyframes pulseSuccess {
            0%, 100% { background-color: rgb(34, 197, 94); }
            50% { background-color: rgb(22, 163, 74); }
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

                <!-- Config TV -->
                <a href="{{ route('admin.tv-config') }}" class="sidebar-item group w-full flex items-center justify-start text-blue-200 hover:text-white hover:bg-white/10 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                    <svg class="mr-3 h-5 w-5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-medium">Config TV</span>
                </a>

                <!-- Multimedia - ACTIVO -->
                <a href="{{ route('admin.multimedia') }}" class="sidebar-item group w-full flex items-center justify-start text-white bg-white/20 p-3 rounded-lg transition-all duration-200 hover:translate-x-1">
                    <svg class="mr-3 h-5 w-5 text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V1a1 1 0 011-1h2a1 1 0 011 1v3m0 0h8m-8 0V1"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-medium">Multimedia</span>
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
                <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Gestión de Multimedia</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('tv.display') }}" target="_blank" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Ver TV
                            </a>
                            <button onclick="showUploadModal()" class="bg-hospital-blue hover:bg-hospital-blue-hover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Subir Archivo
                            </button>
                        </div>
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
                                    <button onclick="showUploadModal()" class="bg-hospital-blue hover:bg-hospital-blue-hover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        Subir primer archivo
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>

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

                <form id="uploadForm" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Nombre del archivo -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre del archivo
                        </label>
                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-hospital-blue"
                            placeholder="Ej: Promoción servicios médicos"
                        >
                    </div>

                    <!-- Archivo -->
                    <div>
                        <label for="archivo" class="block text-sm font-medium text-gray-700 mb-1">
                            Seleccionar archivo
                        </label>
                        <input
                            type="file"
                            id="archivo"
                            name="archivo"
                            accept=".jpg,.jpeg,.png,.gif,.mp4,.mov,.avi"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-hospital-blue"
                        >
                        <p class="mt-1 text-xs text-gray-500">Máximo 50MB. Formatos: JPG, PNG, GIF, MP4, MOV, AVI</p>
                    </div>

                    <!-- Duración (para imágenes) -->
                    <div>
                        <label for="duracion" class="block text-sm font-medium text-gray-700 mb-1">
                            Duración en pantalla (segundos)
                        </label>
                        <input
                            type="number"
                            id="duracion"
                            name="duracion"
                            min="1"
                            max="300"
                            value="10"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-hospital-blue focus:border-hospital-blue"
                        >
                        <p class="mt-1 text-xs text-gray-500">Para imágenes: tiempo que se mostrará. Para videos: se ignora (usa duración del video)</p>
                    </div>

                    <!-- Progress bar -->
                    <div id="uploadProgress" class="hidden">
                        <div class="bg-gray-200 rounded-full h-2">
                            <div id="progressBar" class="bg-hospital-blue h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
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
                    <h3 class="mt-3 text-lg font-medium text-center text-gray-900" id="successTitle">Operación Exitosa</h3>
                    <p class="mt-2 text-sm text-center text-gray-500" id="successMessage">
                        La operación se ha completado correctamente.
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
        // Variables globales
        let deleteItemId = null;
        let sortable = null;

        // Inicializar cuando la página carga
        document.addEventListener('DOMContentLoaded', function() {
            initializeSortable();
        });

        // Inicializar funcionalidad de ordenamiento
        function initializeSortable() {
            const list = document.getElementById('multimediaList');
            if (!list || list.children.length === 0) return;

            // Implementación simple de drag and drop
            let draggedElement = null;

            list.addEventListener('dragstart', function(e) {
                if (e.target.classList.contains('sortable-item')) {
                    draggedElement = e.target;
                    e.target.style.opacity = '0.5';
                }
            });

            list.addEventListener('dragend', function(e) {
                if (e.target.classList.contains('sortable-item')) {
                    e.target.style.opacity = '';
                    draggedElement = null;
                }
            });

            list.addEventListener('dragover', function(e) {
                e.preventDefault();
            });

            list.addEventListener('drop', function(e) {
                e.preventDefault();
                if (draggedElement && e.target.classList.contains('sortable-item')) {
                    const afterElement = getDragAfterElement(list, e.clientY);
                    if (afterElement == null) {
                        list.appendChild(draggedElement);
                    } else {
                        list.insertBefore(draggedElement, afterElement);
                    }
                    updateOrder();
                }
            });

            // Hacer elementos arrastrables
            const items = list.querySelectorAll('.sortable-item');
            items.forEach(item => {
                item.draggable = true;
            });
        }

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.sortable-item:not(.dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }

        // Actualizar orden en el servidor
        function updateOrder() {
            const items = document.querySelectorAll('.sortable-item');
            const orderData = [];

            items.forEach((item, index) => {
                orderData.push({
                    id: parseInt(item.dataset.id),
                    orden: index + 1
                });
            });

            fetch('/multimedia/order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ items: orderData })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('Orden actualizado', 'El orden de los archivos se ha actualizado correctamente.');
                } else {
                    alert('Error al actualizar el orden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión al actualizar el orden');
            });
        }

        // Mostrar modal de subida
        function showUploadModal() {
            document.getElementById('uploadModal').style.display = 'flex';
        }

        // Cerrar modal de subida
        function closeUploadModal() {
            document.getElementById('uploadModal').style.display = 'none';
            document.getElementById('uploadForm').reset();
            hideUploadProgress();
        }

        // Subir archivo
        function uploadFile() {
            const form = document.getElementById('uploadForm');
            const formData = new FormData(form);
            const uploadBtn = document.getElementById('uploadBtn');
            const uploadBtnText = document.getElementById('uploadBtnText');
            const uploadBtnLoading = document.getElementById('uploadBtnLoading');

            // Mostrar estado de carga
            uploadBtn.disabled = true;
            uploadBtnText.classList.add('hidden');
            uploadBtnLoading.classList.remove('hidden');
            showUploadProgress();

            fetch('/multimedia', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeUploadModal();
                    showSuccess('Archivo subido', 'El archivo se ha subido correctamente.');
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    alert('Error al subir el archivo: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión al subir el archivo');
            })
            .finally(() => {
                // Restaurar estado del botón
                uploadBtn.disabled = false;
                uploadBtnText.classList.remove('hidden');
                uploadBtnLoading.classList.add('hidden');
                hideUploadProgress();
            });
        }

        // Mostrar progreso de subida
        function showUploadProgress() {
            document.getElementById('uploadProgress').classList.remove('hidden');
            // Simular progreso (en una implementación real usarías XMLHttpRequest para progreso real)
            let progress = 0;
            const interval = setInterval(() => {
                progress += 10;
                document.getElementById('progressBar').style.width = progress + '%';
                if (progress >= 90) {
                    clearInterval(interval);
                }
            }, 200);
        }

        // Ocultar progreso de subida
        function hideUploadProgress() {
            document.getElementById('uploadProgress').classList.add('hidden');
            document.getElementById('progressBar').style.width = '0%';
        }

        // Activar/desactivar archivo
        function toggleActive(id) {
            fetch(`/multimedia/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('Estado actualizado', data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    alert('Error al cambiar el estado');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión');
            });
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

            fetch(`/multimedia/${deleteItemId}`, {
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
                    showSuccess('Archivo eliminado', 'El archivo se ha eliminado correctamente.');
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    alert('Error al eliminar el archivo');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión');
            });
        }

        // Mostrar modal de éxito
        function showSuccess(title, message) {
            document.getElementById('successTitle').textContent = title;
            document.getElementById('successMessage').textContent = message;
            document.getElementById('successModal').style.display = 'flex';
        }

        // Cerrar modal de éxito
        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
        }

        // Auto-completar nombre basado en el archivo seleccionado
        document.getElementById('archivo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const nombreInput = document.getElementById('nombre');

            if (file && !nombreInput.value) {
                // Extraer nombre sin extensión
                const fileName = file.name.replace(/\.[^/.]+$/, "");
                nombreInput.value = fileName;
            }
        });
    </script>

</body>
</html>
