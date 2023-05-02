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
        Schema::create('dias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('circuito_id')->nullable()->constrained('circuitos');
            $table->string('nombre');
            $table->string('horario');
            $table->string('descripcion');
            $table->string('nombre_english');
            $table->string('horario_english');
            $table->string('descripcion_english');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dias');
    }
};
