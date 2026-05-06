<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remisiones', function (Blueprint $table) {
            $table->id();
            $table->string('nro');
            $table->foreignId('obra_id')->constrained('obras');
            $table->string('contratista');
            $table->integer('estado');
            $table->string('observacion')->nullable();
            $table->string('entregado_por');
            $table->foreignId('recibio_por')->constrained('usuarios');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remisiones');
    }
};
