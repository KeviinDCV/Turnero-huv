<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'ubicacion',
        'numero_caja'
    ];

    protected $casts = [
        'estado' => 'string',
    ];

    // Scope para cajas activas
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    // Scope para cajas inactivas
    public function scopeInactivas($query)
    {
        return $query->where('estado', 'inactiva');
    }
}
