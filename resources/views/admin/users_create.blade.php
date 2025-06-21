@extends('layouts.admin')

@section('title', 'Crear Usuario')

@section('content')
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
@endsection