<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Mostrar la página de inicio de turnos
     */
    public function inicio()
    {
        return view('turnos.inicio');
    }

    /**
     * Mostrar el menú de servicios
     */
    public function menu(Request $request)
    {
        $servicioId = $request->get('servicio_id');
        
        if ($servicioId) {
            // Mostrar subservicios del servicio seleccionado
            $servicioSeleccionado = Servicio::with('subservicios')
                ->where('id', $servicioId)
                ->where('estado', 'activo')
                ->first();
                
            if (!$servicioSeleccionado) {
                return redirect()->route('turnos.menu');
            }
            
            $subservicios = $servicioSeleccionado->subservicios()
                ->where('estado', 'activo')
                ->orderBy('orden')
                ->get();
                
            return view('turnos.menu', [
                'servicioSeleccionado' => $servicioSeleccionado,
                'subservicios' => $subservicios,
                'mostrandoSubservicios' => true
            ]);
        } else {
            // Mostrar servicios principales
            $servicios = Servicio::where('nivel', 'servicio')
                ->where('estado', 'activo')
                ->orderBy('orden')
                ->get();
                
            return view('turnos.menu', [
                'servicios' => $servicios,
                'mostrandoSubservicios' => false
            ]);
        }
    }

    /**
     * Procesar la selección de un servicio o subservicio
     */
    public function seleccionarServicio(Request $request)
    {
        $servicioId = $request->get('servicio_id');
        $subservicioId = $request->get('subservicio_id');
        
        // Aquí se implementará la lógica para generar el turno
        // Por ahora, solo mostrar un mensaje
        
        if ($subservicioId) {
            $subservicio = Servicio::find($subservicioId);
            $mensaje = "Turno solicitado para: " . $subservicio->nombre_completo;
        } else {
            $servicio = Servicio::find($servicioId);
            $mensaje = "Turno solicitado para: " . $servicio->nombre;
        }
        
        return response()->json([
            'success' => true,
            'message' => $mensaje
        ]);
    }
}
