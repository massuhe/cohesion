<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('domicilio');
            $table->string('telefono');
            $table->string('observaciones');
            $table->integer('alumno_id')->unsigned()->unique()->nullable();
            //$table->integer('rol_id');
            $table->boolean('activo');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();

            /* Claves Foraneas */
            /* Alumnos */
            $table->foreign('alumno_id')
                ->references('id')->on('alumnos')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
