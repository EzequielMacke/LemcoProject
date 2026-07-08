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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('abreviacion')->nullable();
            $table->foreignId('marca_id')->nullable()->constrained('marcas');
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('observacion')->nullable();
            $table->integer('estado')->default(1);
            $table->foreignId('categoria_id')->nullable()->constrained('categorias');
            $table->foreignId('tipo_equipo_id')->nullable()->constrained('tipo_equipos');
            $table->string('codigo_qr')->nullable()->unique();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
