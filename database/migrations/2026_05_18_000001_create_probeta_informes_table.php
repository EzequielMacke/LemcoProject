<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('probeta_informes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obra_id')->constrained('obras');
            $table->foreignId('recepcion_id')->constrained('remisiones');
            $table->integer('estado')->default(1);
            $table->integer('enviado')->default(0);
            $table->integer('verificado')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('probeta_informes');
    }
};
