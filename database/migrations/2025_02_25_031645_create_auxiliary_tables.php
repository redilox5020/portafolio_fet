<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\FileDriver;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pivote Investigador - Proyecto (Con soft deletes y timestamps)
        Schema::create('investigador_proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId("investigador_id")->constrained("investigadores")->onDelete("cascade");
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            // Índices optimizados
            $table->unique(['investigador_id', 'proyecto_id', 'deleted_at'], 'invest_proyecto_unique');
        });

        // Pivote Investigador - Producto
        Schema::create('investigador_producto', function (Blueprint $table) {
            $table->foreignId('investigador_id')->constrained('investigadores')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->primary(['investigador_id', 'producto_id']);
        });

        // Archivos (Polimórfica)
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->enum('driver', FileDriver::values())->default(FileDriver::CLOUDINARY->value);
            $table->string('nombre_original');
            $table->string('file_id');
            $table->string('url');
            $table->string('mime_type');
            $table->unsignedBigInteger('tamanio');
            $table->text('descripcion')->nullable();

            $table->morphs('archivable'); // Crea archivable_id y archivable_type
            $table->foreignId('subido_por')->constrained('users');

            $table->timestamps();
        });

        Schema::create('route_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('route_name')->unique();
            $table->string('permission_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_permissions');
        Schema::dropIfExists('archivos');
        Schema::dropIfExists('investigador_producto');
        Schema::dropIfExists('investigador_proyecto');
    }
};
