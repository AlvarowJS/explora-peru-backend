<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('lugares');
            $table->text('descripcion_spanish');
            $table->text('descripcion_english');
            $table->text('incluye_spanish');
            $table->text('incluye_english');
            $table->text('no_incluye_spanish');
            $table->text('no_incluye_english');
            $table->string('duracion');
            $table->string('img');
            $table->string('archivo_english')->nullable();
            $table->string('archivo_spanish')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
