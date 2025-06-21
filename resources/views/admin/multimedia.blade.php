@extends('layouts.admin')

@section('title', 'Gestión Multimedia')
@section('styles')
    <style>
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
@endsection

@section('content')

    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 max-w-7xl mx-auto">
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
@endsection

@section('scripts')
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
@endsection
