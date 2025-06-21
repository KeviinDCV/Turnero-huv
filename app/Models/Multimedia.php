<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Multimedia extends Model
{
    protected $table = 'multimedia';

    protected $fillable = [
        'nombre',
        'archivo',
        'tipo',
        'extension',
        'orden',
        'duracion',
        'activo',
        'tamaño'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'duracion' => 'integer',
        'tamaño' => 'integer',
    ];

    /**
     * Obtener multimedia activa ordenada
     */
    public static function getActiveOrdered()
    {
        return self::where('activo', true)
            ->orderBy('orden')
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Obtener URL completa del archivo
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->archivo);
    }

    /**
     * Verificar si es una imagen
     */
    public function esImagen()
    {
        return $this->tipo === 'imagen';
    }

    /**
     * Verificar si es un video
     */
    public function esVideo()
    {
        return $this->tipo === 'video';
    }

    /**
     * Obtener el siguiente orden disponible
     */
    public static function getNextOrder()
    {
        $maxOrder = self::max('orden');
        return $maxOrder ? $maxOrder + 1 : 1;
    }

    /**
     * Formatear tamaño del archivo
     */
    public function getTamañoFormateadoAttribute()
    {
        if (!$this->tamaño) return 'N/A';

        $bytes = $this->tamaño;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
