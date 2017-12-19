<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesPermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_permisos', function (Blueprint $table) {
            $table->integer('rol_id')->unsigned();
            $table->integer('permiso_id')->unsigned();

            /* Claves primarias */
            $table->primary(['rol_id', 'permiso_id']);

            /* Claves foráneas */
            /* Alumno */
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');
            /* Clase */
            $table->foreign('permiso_id')->references('id')->on('permisos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_permisos');
    }
}
