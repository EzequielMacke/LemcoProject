<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('probetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remision_id')->constrained('remisiones');
            $table->string('concretera');
            $table->integer('fck');
            $table->date('fecha_moldeo');
            $table->time('hora_moldeo');
            $table->string('mixer');
            $table->integer('edad_ensayo');
            $table->string('elemento');
            $table->string('nombre');
            $table->integer('estado');

            // Datos de ensayo (se completan al momento de ensayar)
            $table->date('fecha_ensayo')->nullable();
            $table->string('defecto')->nullable();
            $table->decimal('carga_rotura', 10, 2)->nullable();
            $table->integer('tipo_rotura')->nullable();
            $table->decimal('diametro_superior_1', 6, 2)->nullable();
            $table->decimal('diametro_superior_2', 6, 2)->nullable();
            $table->decimal('diametro_inferior_1', 6, 2)->nullable();
            $table->decimal('diametro_inferior_2', 6, 2)->nullable();
            $table->decimal('altura_1', 6, 2)->nullable();
            $table->decimal('altura_2', 6, 2)->nullable();
            $table->decimal('altura_3', 6, 2)->nullable();

            $table->foreignId('ensayo_por')->nullable()->constrained('usuarios');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('probetas');
    }
};
