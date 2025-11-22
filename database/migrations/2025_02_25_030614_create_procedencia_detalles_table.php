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
        Schema::create('procedencia_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procedencia_id')->constrained('procedencias')->onDelete('cascade');
            $table->string("opcion");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedencia_detalles');
    }
};
