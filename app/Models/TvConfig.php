<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TvConfig extends Model
{
    protected $fillable = [
        'ticker_message',
        'ticker_speed',
        'ticker_enabled'
    ];

    protected $casts = [
        'ticker_enabled' => 'boolean',
        'ticker_speed' => 'integer',
    ];

    /**
     * Obtener la configuración actual del TV
     * Si no existe, crear una con valores por defecto
     */
    public static function getCurrentConfig()
    {
        $config = self::first();

        if (!$config) {
            $config = self::create([
                'ticker_message' => '🏥 Bienvenidos al Hospital Universitario del Valle "Evaristo García" E.S.E • Horarios de atención: Lunes a Viernes 6:00 AM - 6:00 PM • Sábados 6:00 AM - 2:00 PM • Para emergencias las 24 horas • Recuerde mantener su distancia y usar tapabocas • Su salud es nuestra prioridad • Gracias por confiar en nosotros 💙',
                'ticker_speed' => 35,
                'ticker_enabled' => true
            ]);
        }

        return $config;
    }
}
