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
        Schema::create('investigador_proyectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("investigador_id")->constrained("investigadores").onDelete("cascade");
            $table->foreignId("proyecto_id")->constrained("proyectos").onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigador_proyectos');
    }
};
