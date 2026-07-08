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
        Schema::create('detalle_retiros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retiro_id')->constrained('retiros');
            $table->foreignId('equipo_id')->constrained('equipos');
            $table->date('fecha_retiro');
            $table->date('fecha_devolucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_retiros');
    }
};
