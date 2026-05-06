<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nick')->unique();
            $table->string('contrasena');
            $table->integer('estado');
            $table->integer('envio')->default(0);
            $table->foreignId('area_id')->nullable()->constrained('areas');
            $table->foreignId('persona_id')->nullable()->constrained('personas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
