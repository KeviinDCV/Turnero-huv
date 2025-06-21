<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Dashboard principal del administrador
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Datos de ejemplo para el dashboard
        $advisorData = [
            ['name' => 'Juan Pérez', 'availability' => 'DISPONIBLE', 'status' => 'DISPONIBLE'],
            ['name' => 'María García', 'availability' => 'OCUPADO', 'status' => 'OCUPADO'],
            ['name' => 'Carlos López', 'availability' => 'CAJA CERRADA', 'status' => 'CERRADO'],
        ];

        $serviceData = [
            ['service' => 'CITAS', 'count' => 15],
            ['service' => 'COPAGOS', 'count' => 8],
            ['service' => 'FACTURACIÓN', 'count' => 12],
            ['service' => 'PROGRAMACIÓN', 'count' => 5],
        ];

        $advisorTerminals = [
            ['name' => 'Juan Pérez', 'terminals' => 25],
            ['name' => 'María García', 'terminals' => 18],
            ['name' => 'Carlos López', 'terminals' => 0],
        ];

        $queueData = [
            ['service' => 'CITAS', 'count' => 3],
            ['service' => 'COPAGOS', 'count' => 1],
            ['service' => 'FACTURACIÓN', 'count' => 2],
        ];

        return view('admin.dashboard', compact('user', 'advisorData', 'serviceData', 'advisorTerminals', 'queueData'));
    }
    
    /**
     * Mostrar listado de usuarios con buscador
     */
    public function users(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');
        
        $query = User::query();
        
        // Aplicar filtro de búsqueda si existe
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'like', "%{$search}%")
                  ->orWhere('cedula', 'like', "%{$search}%")
                  ->orWhere('correo_electronico', 'like', "%{$search}%")
                  ->orWhere('nombre_usuario', 'like', "%{$search}%")
                  ->orWhere('rol', 'like', "%{$search}%");
            });
        }
        
        // Obtener usuarios paginados
        $users = $query->paginate(10);
        
        return view('admin.users', compact('user', 'users', 'search'));
    }

    // Ya no necesitamos el método createUser() porque usamos un modal en la misma página
    
    /**
     * Procesar la creación de un nuevo usuario
     */
    public function storeUser(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:users,cedula',
            'correo_electronico' => 'required|email|max:255|unique:users,correo_electronico',
            'nombre_usuario' => 'required|string|max:255|unique:users,nombre_usuario',
            'rol' => 'required|in:Administrador,Asesor',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Crear nuevo usuario
        User::create([
            'nombre_completo' => $validated['nombre_completo'],
            'cedula' => $validated['cedula'],
            'correo_electronico' => $validated['correo_electronico'],
            'nombre_usuario' => $validated['nombre_usuario'],
            'rol' => $validated['rol'],
            'password' => Hash::make($validated['password']),
        ]);
        
        // Redireccionar con mensaje de éxito
        return redirect()->route('admin.users')
            ->with('success', 'Usuario creado correctamente');
    }
    
    /**
     * Obtener datos de un usuario para editar
     */
    public function getUser($id)
    {
        $userToEdit = User::findOrFail($id);
        return response()->json($userToEdit);
    }
    
    /**
     * Actualizar datos de un usuario
     */
    public function updateUser(Request $request, $id)
    {
        $userToUpdate = User::findOrFail($id);
        
        // Validar los datos del formulario
        $rules = [
            'nombre_completo' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:users,cedula,' . $id,
            'correo_electronico' => 'required|email|max:255|unique:users,correo_electronico,' . $id,
            'nombre_usuario' => 'required|string|max:255|unique:users,nombre_usuario,' . $id,
            'rol' => 'required|in:Administrador,Asesor',
        ];
        
        // Si se está cambiando la contraseña, validarla
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }
        
        $validated = $request->validate($rules);
        
        // Preparar datos para actualizar
        $updateData = [
            'nombre_completo' => $validated['nombre_completo'],
            'cedula' => $validated['cedula'],
            'correo_electronico' => $validated['correo_electronico'],
            'nombre_usuario' => $validated['nombre_usuario'],
            'rol' => $validated['rol'],
        ];
        
        // Actualizar contraseña solo si se proporcionó
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }
        
        // Actualizar el usuario
        $userToUpdate->update($updateData);
        
        // Si la petición es AJAX, devolver JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        }

        // Redireccionar con mensaje de éxito para peticiones normales
        return redirect()->route('admin.users')
            ->with('success', 'Usuario actualizado correctamente');
    }
    
    /**
     * Eliminar un usuario
     */
    public function deleteUser($id)
    {
        $userToDelete = User::findOrFail($id);
        
        // Evitar que se elimine a sí mismo
        if (Auth::id() == $id) {
            return redirect()->route('admin.users')
                ->with('error', 'No puedes eliminar tu propio usuario');
        }
        
        $userToDelete->delete();
        
        return redirect()->route('admin.users')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
