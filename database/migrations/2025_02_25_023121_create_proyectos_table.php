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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->string("codigo")->primary();
            $table->string("nombre");
            $table->string("objetivo_general");
            $table->foreignId("programa_id")->constrained('programas')->onDelete("cascade");
            $table->foreignId("procedencia_id")->constrained('procedencias')->onDelete("cascade");
            $table->foreignId("procedencia_codigo_id")->constrained("procedencia_codigos")->onDelete("cascade");
            $table->foreignId("tipologia_id")->constrained("tipologias")->onDelete("cascade");
            $table->date("fecha_inicio");
            $table->date("fecha_fin");
            $table->decimal("costo", 15, 7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
