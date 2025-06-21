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
        Schema::create('tv_configs', function (Blueprint $table) {
            $table->id();
            $table->text('ticker_message')->default('🏥 Bienvenidos al Hospital Universitario del Valle "Evaristo García" E.S.E • Horarios de atención: Lunes a Viernes 6:00 AM - 6:00 PM • Sábados 6:00 AM - 2:00 PM • Para emergencias las 24 horas • Recuerde mantener su distancia y usar tapabocas • Su salud es nuestra prioridad • Gracias por confiar en nosotros 💙');
            $table->integer('ticker_speed')->default(35); // Velocidad en segundos
            $table->boolean('ticker_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tv_configs');
    }
};
