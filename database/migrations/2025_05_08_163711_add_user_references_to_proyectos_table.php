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
            $table->foreignId('registered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('last_modified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('registered_by_name')->nullable();
            $table->string('registered_by_email')->nullable();
            $table->string('last_modified_by_name')->nullable();
            $table->string('last_modified_by_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropForeign(['registered_by']);
            $table->dropForeign(['last_modified_by']);
            
            $table->dropColumn([
                'registered_by',
                'last_modified_by',
                'registered_by_name',
                'registered_by_email',
                'last_modified_by_name',
                'last_modified_by_email',
            ]);
        });
    }
};
