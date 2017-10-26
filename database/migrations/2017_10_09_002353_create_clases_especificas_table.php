<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasesEspecificasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clases_especificas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->boolean('suspendida');
            $table->string('motivo')->nullable();
            $table->integer('descripcion_clase')->unsigned();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('descripcion_clase')->references('id')->on('clases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clases_especificas');
    }
}
