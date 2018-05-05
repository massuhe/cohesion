<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrosSemanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros_semana', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('semana');
            $table->string('repeticiones');
            $table->integer('item_serie_rutina_id')->unsigned();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('item_serie_rutina_id')->references('id')->on('items_serie_rutina')->onDelete('cascade');
            // Restricciones unicidad
            $table->unique(['semana', 'item_serie_rutina_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametros_semana');
    }
}
