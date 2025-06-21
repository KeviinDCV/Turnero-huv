<?php

namespace App\Http\Controllers;

use App\Models\TvConfig;
use App\Models\Multimedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TvConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar la página de configuración del TV
     */
    public function index()
    {
        $user = Auth::user();
        $tvConfig = TvConfig::getCurrentConfig();
        $multimedia = Multimedia::orderBy('orden')->orderBy('created_at')->get();

        return view('admin.tv-config', compact('user', 'tvConfig', 'multimedia'));
    }

    /**
     * Actualizar la configuración del TV
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'ticker_message' => 'required|string|max:1000',
                'ticker_speed' => 'required|integer|min:10|max:120',
                'ticker_enabled' => 'boolean'
            ]);

            $tvConfig = TvConfig::getCurrentConfig();

            $tvConfig->update([
                'ticker_message' => $validated['ticker_message'],
                'ticker_speed' => $validated['ticker_speed'],
                'ticker_enabled' => $request->has('ticker_enabled')
            ]);

            // Si es una petición AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Configuración del TV actualizada correctamente'
                ]);
            }

            return redirect()->route('admin.tv-config')
                ->with('success', 'Configuración del TV actualizada correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ], 500);
            }
            throw $e;
        }
    }

    /**
     * Mostrar la página del TV con configuración
     */
    public function show()
    {
        $tvConfig = TvConfig::getCurrentConfig();
        return view('tv.display', compact('tvConfig'));
    }

    /**
     * Subir archivo multimedia
     */
    public function storeMultimedia(Request $request)
    {
        try {
            $request->validate([
                'archivo' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:51200', // 50MB max
                'nombre' => 'required|string|max:255',
                'duracion' => 'required|integer|min:1|max:300' // 1-300 segundos
            ]);

            $archivo = $request->file('archivo');
            $extension = $archivo->getClientOriginalExtension();
            $tipo = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']) ? 'imagen' : 'video';

            // Generar nombre único para el archivo
            $nombreArchivo = Str::uuid() . '.' . $extension;

            // Guardar archivo en storage/app/public/multimedia
            $rutaArchivo = $archivo->storeAs('multimedia', $nombreArchivo, 'public');

            // Crear registro en base de datos
            $multimedia = Multimedia::create([
                'nombre' => $request->nombre,
                'archivo' => $rutaArchivo,
                'tipo' => $tipo,
                'extension' => $extension,
                'orden' => Multimedia::getNextOrder(),
                'duracion' => $request->duracion,
                'activo' => true,
                'tamaño' => $archivo->getSize()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Archivo subido correctamente',
                'multimedia' => $multimedia
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar orden de multimedia
     */
    public function updateMultimediaOrder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|integer|exists:multimedia,id',
                'items.*.orden' => 'required|integer|min:1'
            ]);

            foreach ($request->items as $item) {
                Multimedia::where('id', $item['id'])
                    ->update(['orden' => $item['orden']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Orden actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el orden'
            ], 500);
        }
    }

    /**
     * Activar/desactivar multimedia
     */
    public function toggleMultimedia(Request $request, $id)
    {
        try {
            $multimedia = Multimedia::findOrFail($id);
            $multimedia->activo = !$multimedia->activo;
            $multimedia->save();

            return response()->json([
                'success' => true,
                'message' => $multimedia->activo ? 'Archivo activado' : 'Archivo desactivado',
                'activo' => $multimedia->activo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado'
            ], 500);
        }
    }

    /**
     * Eliminar multimedia
     */
    public function destroyMultimedia($id)
    {
        try {
            $multimedia = Multimedia::findOrFail($id);

            // Eliminar archivo del storage
            if (Storage::disk('public')->exists($multimedia->archivo)) {
                Storage::disk('public')->delete($multimedia->archivo);
            }

            // Eliminar registro de la base de datos
            $multimedia->delete();

            return response()->json([
                'success' => true,
                'message' => 'Archivo eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el archivo'
            ], 500);
        }
    }

    /**
     * Obtener la configuración actual para la página del TV
     */
    public function getConfig()
    {
        $tvConfig = TvConfig::getCurrentConfig();

        return response()->json([
            'ticker_message' => $tvConfig->ticker_message,
            'ticker_speed' => $tvConfig->ticker_speed,
            'ticker_enabled' => $tvConfig->ticker_enabled
        ]);
    }

    /**
     * Obtener multimedia activa para el TV
     */
    public function getActiveMultimedia()
    {
        $multimedia = Multimedia::getActiveOrdered();

        return response()->json([
            'multimedia' => $multimedia->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'url' => $item->url,
                    'tipo' => $item->tipo,
                    'duracion' => $item->duracion,
                    'orden' => $item->orden
                ];
            })
        ]);
    }
}
