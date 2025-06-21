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
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Nombre de la caja (ej: "Caja 1", "Caja Principal")
            $table->string('descripcion')->nullable(); // Descripción opcional
            $table->enum('estado', ['activa', 'inactiva'])->default('activa'); // Estado de la caja
            $table->string('ubicacion')->nullable(); // Ubicación física de la caja
            $table->integer('numero_caja')->unique(); // Número identificador de la caja
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
