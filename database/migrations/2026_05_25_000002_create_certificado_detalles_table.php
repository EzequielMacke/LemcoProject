<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificado_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificado_id')->constrained('certificados');

            // Tipo 1 (por remisión): se llena remision_id, informe_id queda null
            $table->foreignId('remision_id')
                  ->nullable()
                  ->constrained('remisiones');

            // Tipo 2 (por informe): se llena informe_id, remision_id queda null
            $table->foreignId('informe_id')
                  ->nullable()
                  ->constrained('probeta_informes');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificado_detalles');
    }
};
