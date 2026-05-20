<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_informes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('informe_id')->constrained('probeta_informes');
            $table->foreignId('probeta_id')->constrained('probetas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_informes');
    }
};
