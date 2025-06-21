<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'nombre_completo' => 'Administrador HUV',
            'correo_electronico' => 'admin@huv.gov.co',
            'rol' => 'Administrador',
            'cedula' => '12345678',
            'nombre_usuario' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Crear usuario asesor
        User::create([
            'nombre_completo' => 'Asesor de Prueba',
            'correo_electronico' => 'asesor@huv.gov.co',
            'rol' => 'Asesor',
            'cedula' => '87654321',
            'nombre_usuario' => 'asesor',
            'password' => Hash::make('asesor123'),
        ]);
    }
}
