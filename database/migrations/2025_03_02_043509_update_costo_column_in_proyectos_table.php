<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCostoColumnInProyectosTable extends Migration
{
    public function up()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->decimal('costo', 15, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->decimal('costo', 15, 7)->change();
        });
    }
}
