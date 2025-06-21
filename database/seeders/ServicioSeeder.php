<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Servicio;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear servicios principales
        $citas = Servicio::create([
            'nombre' => 'CITAS',
            'descripcion' => 'Gestión de citas médicas y programación de consultas',
            'nivel' => 'servicio',
            'estado' => 'activo',
            'codigo' => 'CIT',
            'orden' => 1
        ]);

        $copagos = Servicio::create([
            'nombre' => 'COPAGOS',
            'descripcion' => 'Gestión de copagos y pagos de servicios médicos',
            'nivel' => 'servicio',
            'estado' => 'activo',
            'codigo' => 'COP',
            'orden' => 2
        ]);

        $facturacion = Servicio::create([
            'nombre' => 'FACTURACIÓN',
            'descripcion' => 'Facturación de servicios médicos y administrativos',
            'nivel' => 'servicio',
            'estado' => 'activo',
            'codigo' => 'FAC',
            'orden' => 3
        ]);

        $programacion = Servicio::create([
            'nombre' => 'PROGRAMACIÓN',
            'descripcion' => 'Programación de procedimientos y cirugías',
            'nivel' => 'servicio',
            'estado' => 'activo',
            'codigo' => 'PRO',
            'orden' => 4
        ]);

        // Crear subservicios para CITAS
        Servicio::create([
            'nombre' => 'Citas Medicina General',
            'descripcion' => 'Programación de citas para medicina general',
            'nivel' => 'subservicio',
            'servicio_padre_id' => $citas->id,
            'estado' => 'activo',
            'codigo' => 'CIT-MG',
            'orden' => 1
        ]);

        Servicio::create([
            'nombre' => 'Citas Especialidades',
            'descripcion' => 'Programación de citas para especialidades médicas',
            'nivel' => 'subservicio',
            'servicio_padre_id' => $citas->id,
            'estado' => 'activo',
            'codigo' => 'CIT-ESP',
            'orden' => 2
        ]);

        Servicio::create([
            'nombre' => 'Citas Urgentes',
            'descripcion' => 'Programación de citas urgentes',
            'nivel' => 'subservicio',
            'servicio_padre_id' => $citas->id,
            'estado' => 'activo',
            'codigo' => 'CIT-URG',
            'orden' => 3
        ]);

        // Crear subservicios para COPAGOS
        Servicio::create([
            'nombre' => 'Copago Consulta',
            'descripcion' => 'Pago de copago para consultas médicas',
            'nivel' => 'subservicio',
            'servicio_padre_id' => $copagos->id,
            'estado' => 'activo',
            'codigo' => 'COP-CON',
            'orden' => 1
        ]);

        Servicio::create([
            'nombre' => 'Copago Procedimientos',
            'descripcion' => 'Pago de copago para procedimientos médicos',
            'nivel' => 'subservicio',
            'servicio_padre_id' => $copagos->id,
            'estado' => 'activo',
            'codigo' => 'COP-PRO',
            'orden' => 2
        ]);

        // Crear subservicios para FACTURACIÓN
        Servicio::create([
            'nombre' => 'Facturación Ambulatoria',
            'descripcion' => 'Facturación de servicios ambulatorios',
            'nivel' => 'subservicio',
            'servicio_padre_id' => $facturacion->id,
            'estado' => 'activo',
            'codigo' => 'FAC-AMB',
            'orden' => 1
        ]);

        Servicio::create([
            'nombre' => 'Facturación Hospitalaria',
            'descripcion' => 'Facturación de servicios hospitalarios',
            'nivel' => 'subservicio',
            'servicio_padre_id' => $facturacion->id,
            'estado' => 'activo',
            'codigo' => 'FAC-HOS',
            'orden' => 2
        ]);

        // Crear subservicios para PROGRAMACIÓN
        Servicio::create([
            'nombre' => 'Programación Cirugías',
            'descripcion' => 'Programación de cirugías y procedimientos quirúrgicos',
            'nivel' => 'subservicio',
            'servicio_padre_id' => $programacion->id,
            'estado' => 'activo',
            'codigo' => 'PRO-CIR',
            'orden' => 1
        ]);

        Servicio::create([
            'nombre' => 'Programación Exámenes',
            'descripcion' => 'Programación de exámenes diagnósticos',
            'nivel' => 'subservicio',
            'servicio_padre_id' => $programacion->id,
            'estado' => 'activo',
            'codigo' => 'PRO-EXA',
            'orden' => 2
        ]);
    }
}
