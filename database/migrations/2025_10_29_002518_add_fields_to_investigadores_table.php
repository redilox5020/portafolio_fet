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
        Schema::table('investigadores', function (Blueprint $table) {


            $table->string('email')->nullable()->after('nombre');
            $table->string('tipo_documento', 5)->nullable()->after('email');
            $table->string('documento', 50)->nullable()->after('tipo_documento');
            $table->string('telefono', 20)->nullable()->after('documento');

            if (!Schema::hasColumn('investigadores', 'created_at')) {
                $table->timestamps();
            }

            $table->index('nombre');
            $table->index('email');
            $table->index('documento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investigadores', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['documento']);

            $table->dropColumn([
                'email',
                'tipo_documento',
                'documento',
                'telefono'
            ]);

            $table->dropTimestamps();
        });
    }
};
