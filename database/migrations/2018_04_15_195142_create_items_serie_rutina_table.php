<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsSerieRutinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_serie_rutina', function (Blueprint $table) {
            $table->increments('id');
            $table->string('micro_descanso')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('serie_rutina_id')->unsigned();
            $table->integer('ejercicio_id')->unsigned();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('serie_rutina_id')->references('id')->on('series_rutina')->onDelete('cascade');
            $table->foreign('ejercicio_id')->references('id')->on('ejercicios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_serie_rutina');
    }
}
