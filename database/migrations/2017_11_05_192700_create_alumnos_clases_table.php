<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosClasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos_clases', function (Blueprint $table) {
            $table->integer('alumno_id')->unsigned();
            $table->integer('clase_id')->unsigned();

            /* Claves primarias */
            $table->primary(['alumno_id', 'clase_id']);

            /* Claves foráneas */
            /* Alumno */
            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
            /* Clase */
            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnos_clases');
    }
}
