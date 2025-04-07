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
        Schema::table('investigador_proyecto', function (Blueprint $table) {
            $table->dropForeign(['proyecto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investigador_proyecto', function (Blueprint $table) {
            $table->foreign('proyecto_id')
                  ->references('codigo')
                  ->on('proyectos')
                  ->onDelete('cascade');
        });
    }
};
