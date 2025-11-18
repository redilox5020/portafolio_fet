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
        Schema::table('procedencia_codigos', function (Blueprint $table) {
            $table->unsignedBigInteger('procedencia_id')
                ->after('id')
                ->nullable();
        });

        $modalidadGradoId = DB::table('procedencias')->where('opcion', 'Modalidad de Grado')->value('id');
        $grupoInvestigacionId = DB::table('procedencias')->where('opcion', 'Grupo de Investigación')->value('id');
        $semilleroId = DB::table('procedencias')->where('opcion', 'Semillero de Investigación')->value('id');
        $extensionId = DB::table('procedencias')->where('opcion', 'Extensión')->value('id');

        // Asignar Modalidad de Grado
        DB::table('procedencia_codigos')
            ->where('opcion', 'Proyecto de Grado')
            ->update(['procedencia_id' => $modalidadGradoId]);

        DB::table('procedencia_codigos')
            ->where('opcion', 'Pasantía')
            ->update(['procedencia_id' => $modalidadGradoId]);

        DB::table('procedencia_codigos')
            ->where('opcion', 'Seminario de Profundización')
            ->update(['procedencia_id' => $modalidadGradoId]);

        // Asignar Grupo de Investigación
        DB::table('procedencia_codigos')
            ->where('opcion', 'GIIFET')
            ->update(['procedencia_id' => $grupoInvestigacionId]);

        DB::table('procedencia_codigos')
            ->where('opcion', 'GISST')
            ->update(['procedencia_id' => $grupoInvestigacionId]);

        // Asignar a Semillero
        DB::table('procedencia_codigos')
            ->where('opcion', 'ASST')
            ->update(['procedencia_id' => $semilleroId]);

        DB::table('procedencia_codigos')
            ->where('opcion', 'Dirección de I+D+i')
            ->update(['procedencia_id' => $extensionId]);

        Schema::table('procedencia_codigos', function (Blueprint $table) {
            $table->unsignedBigInteger('procedencia_id')->nullable(false)->change();

            $table->foreign('procedencia_id')
                ->references('id')
                ->on('procedencias')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procedencia_codigos', function (Blueprint $table) {
            $table->dropForeign(['procedencia_id']);
            $table->dropColumn('procedencia_id');
        });
    }
};
