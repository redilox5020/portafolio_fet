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
        Schema::create('programas', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("sufijo");
        });
        Schema::create('procedencias', function (Blueprint $table) {
            $table->id();
            $table->string("opcion");
        });
        Schema::create('tipologias', function (Blueprint $table) {
            $table->id();
            $table->string("opcion");
            $table->string('model_type')->default('proyecto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipologias');
        Schema::dropIfExists('procedencias');
        Schema::dropIfExists('programas');
    }
};
