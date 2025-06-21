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
        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('archivo'); // Ruta del archivo
            $table->enum('tipo', ['imagen', 'video']); // Tipo de archivo
            $table->string('extension'); // jpg, png, mp4, etc.
            $table->integer('orden')->default(0); // Orden de reproducción
            $table->integer('duracion')->default(10); // Duración en segundos (para imágenes)
            $table->boolean('activo')->default(true);
            $table->bigInteger('tamaño')->nullable(); // Tamaño del archivo en bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multimedia');
    }
};
