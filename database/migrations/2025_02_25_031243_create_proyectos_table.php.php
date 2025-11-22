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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string("codigo", 100)->unique();

            $table->string("nombre");
            $table->text("objetivo_general");
            $table->year('anio');
            $table->date("fecha_inicio");
            $table->date("fecha_fin");
            $table->decimal("costo", 15, 2);
            $table->string('pdf_url')->nullable();

            // Relaciones
            $table->foreignId("programa_id")->constrained('programas')->onDelete("cascade");
            $table->foreignId("procedencia_id")->constrained('procedencias')->onDelete("cascade");

            $table->foreignId("procedencia_detalle_id")
                    ->nullable()
                    ->constrained("procedencia_detalles")
                    ->onDelete("set null");

            $table->foreignId("tipologia_id")->constrained("tipologias")->onDelete("cascade");

            // Auditoría
            $table->foreignId('registered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('last_modified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('registered_by_name')->nullable();
            $table->string('registered_by_email')->nullable();
            $table->string('last_modified_by_name')->nullable();
            $table->string('last_modified_by_email')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
