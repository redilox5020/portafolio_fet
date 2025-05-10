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
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->enum('driver', FileDriver::values())->default(FileDriver::CLOUDINARY->value);
            $table->string('nombre_original');
            $table->string('file_id');
            $table->string('url');
            $table->string('mime_type');
            $table->unsignedBigInteger('tamanio');
            $table->text('descripcion')->nullable();
            $table->morphs('archivable');
            $table->foreignId('subido_por')->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
