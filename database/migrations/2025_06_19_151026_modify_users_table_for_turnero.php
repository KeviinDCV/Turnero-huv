<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregar nuevos campos para el sistema de turnero
            $table->string('nombre_completo')->nullable()->after('id');
            $table->string('correo_electronico')->nullable()->after('nombre_completo');
            $table->enum('rol', ['Administrador', 'Asesor'])->default('Asesor')->after('correo_electronico');
            $table->string('cedula')->nullable()->after('rol');
            $table->string('nombre_usuario')->nullable()->after('cedula');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir cambios
            $table->dropColumn(['nombre_completo', 'correo_electronico', 'rol', 'cedula', 'nombre_usuario']);
        });
    }
};
