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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            $table->string('titulo');
            $table->foreignId('tipologia_id')->constrained('tipologias')->onDelete('cascade');
            $table->text('descripcion')->nullable();
            $table->string('enlace')->nullable();
            $table->timestamps();
        });

        Schema::create('investigador_producto', function (Blueprint $table) {
            $table->foreignId('investigador_id')->constrained('investigadores')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->primary(['investigador_id', 'producto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigador_producto');
        Schema::dropIfExists('productos');
    }
};
