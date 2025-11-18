<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropForeign(['procedencia_detalle_id']);

            $table->unsignedBigInteger('procedencia_detalle_id')->nullable()->change();

            $table->foreign('procedencia_detalle_id')
                ->references('id')
                ->on('procedencia_detalles')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropForeign(['procedencia_detalle_id']);
            $table->unsignedBigInteger('procedencia_detalle_id')->nullable(false)->change();
            $table->foreign('procedencia_detalle_id')
                ->references('id')
                ->on('procedencia_detalles')
                ->onDelete('restrict');
        });
    }
};
