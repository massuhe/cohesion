<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutinas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_rutina');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->integer('total_semanas');
            $table->integer('alumno_id')->unsigned();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
            // Restricciones unicidad
            $table->unique(['numero_rutina', 'alumno_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rutinas');
    }
}
