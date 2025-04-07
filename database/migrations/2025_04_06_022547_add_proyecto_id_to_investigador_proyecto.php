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
            $table->unsignedBigInteger('proyecto_id_nuevo')->nullable();

        });
        Schema::table('investigador_proyecto', function (Blueprint $table) {
            DB::statement('
                UPDATE investigador_proyecto ip
                JOIN proyectos p ON ip.proyecto_id = p.codigo
                SET ip.proyecto_id_nuevo = p.id
            ');


            $table->dropColumn('proyecto_id');

            $table->renameColumn('proyecto_id_nuevo', 'proyecto_id');

            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir todo
        Schema::table('investigador_proyecto', function (Blueprint $table) {
            $table->string('proyecto_codigo')->nullable();
        });

        DB::statement('
            UPDATE investigador_proyecto ip
            JOIN proyectos p ON ip.proyecto_id = p.id
            SET ip.proyecto_codigo = p.codigo
        ');

        Schema::table('investigador_proyecto', function (Blueprint $table) {
            $table->dropForeign(['proyecto_id']);
            $table->dropColumn('proyecto_id');
            $table->renameColumn('proyecto_codigo', 'proyecto_id');
            $table->foreign('proyecto_id')->references('codigo')->on('proyectos')->onDelete('cascade');
        });
    }
};
