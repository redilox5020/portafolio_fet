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
        Schema::create('investigador_proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId("investigador_id")->constrained("investigadores")->onDelete("cascade");
            $table->string("proyecto_id");
            $table->foreign("proyecto_id")->references("codigo")->on("proyectos")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigador_proyecto');
    }
};
