<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuspensionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspensiones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clase_id')->unsigned();
            $table->date('fecha_hasta');
            $table->string('motivo');

            // Claves foráneas
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
        Schema::dropIfExists('suspensiones');
    }
}
