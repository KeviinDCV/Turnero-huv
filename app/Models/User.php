<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre_completo',
        'correo_electronico',
        'rol',
        'cedula',
        'nombre_usuario',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function esAdministrador(): bool
    {
        return $this->rol === 'Administrador';
    }

    /**
     * Verificar si el usuario es asesor
     */
    public function esAsesor(): bool
    {
        return $this->rol === 'Asesor';
    }

    /**
     * Obtener el nombre de usuario para autenticación
     */
    public function getAuthIdentifierName()
    {
        return 'id'; // Laravel usa 'id' por defecto
    }

    /**
     * Obtener el nombre del campo de usuario para login
     */
    public function username()
    {
        return 'nombre_usuario';
    }

    /**
     * Obtener el identificador único para autenticación
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Obtener el email para notificaciones
     */
    public function getEmailForPasswordReset()
    {
        return $this->correo_electronico;
    }

    /**
     * Relación muchos a muchos con servicios
     */
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'user_servicio')->withTimestamps();
    }

    /**
     * Verificar si el usuario tiene asignado un servicio específico
     */
    public function tieneServicio($servicioId)
    {
        return $this->servicios()->where('servicio_id', $servicioId)->exists();
    }

    /**
     * Obtener servicios activos asignados al usuario
     */
    public function serviciosActivos()
    {
        return $this->servicios()->where('estado', 'activo');
    }
}
