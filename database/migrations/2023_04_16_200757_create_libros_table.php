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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->char('dni',8);
            $table->char('telefono', 9);
            $table->string('email');
            $table->char('padre')->nullable();
            $table->string('domicilio');
            $table->string('pais');
            $table->string('relacion');
            $table->string('monto_reclamado');
            $table->string('moneda_tipo');
            $table->string('descripcion');
            $table->string('accion');
            $table->text('detalle');
            $table->text('pedido');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
