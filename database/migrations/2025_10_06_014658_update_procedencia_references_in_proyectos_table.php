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
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropForeign(['procedencia_codigo_id']);

            $table->renameColumn('procedencia_codigo_id', 'procedencia_detalle_id');
        });

        Schema::table('proyectos', function (Blueprint $table) {
            $table->foreign('procedencia_detalle_id')
                ->references('id')
                ->on('procedencia_detalles')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropForeign(['procedencia_detalle_id']);
            $table->renameColumn('procedencia_detalle_id', 'procedencia_codigo_id');
        });

        Schema::table('proyectos', function (Blueprint $table) {
            $table->foreign('procedencia_codigo_id')
                ->references('id')
                ->on('procedencia_codigos')
                ->onDelete('restrict');
        });
    }
};
