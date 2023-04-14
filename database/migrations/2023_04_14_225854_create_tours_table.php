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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lugare_id')->nullable()->constrained('lugares');
            $table->string('titulo');
            $table->text('descripcion_spanish');
            $table->text('descripcion_english');
            $table->text('incluye_spanish');
            $table->text('incluye_english');
            $table->string('duracion');
            $table->string('img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
