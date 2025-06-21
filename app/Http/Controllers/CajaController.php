<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CajaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search');

        $query = Caja::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhere('ubicacion', 'like', "%{$search}%")
                  ->orWhere('numero_caja', 'like', "%{$search}%");
            });
        }

        $cajas = $query->orderBy('numero_caja')->paginate(10);

        return view('admin.cajas', compact('cajas', 'search', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:cajas',
            'descripcion' => 'nullable|string|max:500',
            'ubicacion' => 'nullable|string|max:255',
            'numero_caja' => 'required|integer|unique:cajas|min:1',
            'estado' => 'required|in:activa,inactiva'
        ]);

        Caja::create($request->all());

        // Si es una petición AJAX, devolver JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Caja creada correctamente'
            ]);
        }

        return redirect()->route('admin.cajas')
            ->with('success', 'Caja creada correctamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $caja = Caja::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:cajas,nombre,' . $id,
            'descripcion' => 'nullable|string|max:500',
            'ubicacion' => 'nullable|string|max:255',
            'numero_caja' => 'required|integer|unique:cajas,numero_caja,' . $id . '|min:1',
            'estado' => 'required|in:activa,inactiva'
        ]);

        $caja->update($request->all());

        // Si es una petición AJAX, devolver JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Caja actualizada correctamente'
            ]);
        }

        return redirect()->route('admin.cajas')
            ->with('success', 'Caja actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $caja = Caja::findOrFail($id);
        $caja->delete();

        // Si es una petición AJAX, devolver JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Caja eliminada correctamente'
            ]);
        }

        return redirect()->route('admin.cajas')
            ->with('success', 'Caja eliminada correctamente');
    }
}
