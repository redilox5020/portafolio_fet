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
            $table->timestamp('created_at')
                ->nullable()
                ->after('proyecto_id')
                ->useCurrent();

            $table->timestamp('deleted_at')
                ->nullable()
                ->after('created_at');

            $table->index('investigador_id', 'investigador_proyecto_investigador_id_index');
            $table->index('proyecto_id', 'investigador_proyecto_proyecto_id_index');
            $table->index(['proyecto_id', 'deleted_at'], 'investigador_proyecto_proyecto_deleted_index');

            $table->unique(
                ['investigador_id', 'proyecto_id', 'deleted_at'],
                'invest_proyecto_unique'
            );
        });

        DB::statement('UPDATE investigador_proyecto SET created_at = NOW()');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investigador_proyecto', function (Blueprint $table) {
            $table->dropUnique('investigador_proyecto_unique_relation');

            $table->dropIndex('investigador_proyecto_investigador_id_index');
            $table->dropIndex('investigador_proyecto_proyecto_id_index');
            $table->dropIndex('investigador_proyecto_proyecto_deleted_index');

            $table->dropColumn(['created_at', 'deleted_at']);
        });
    }
};
