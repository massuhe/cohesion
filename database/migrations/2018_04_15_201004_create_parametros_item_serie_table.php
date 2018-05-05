<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrosItemSerieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros_item_serie', function (Blueprint $table) {
            $table->increments('id');
            $table->string('carga');
            $table->integer('clase_especifica_id')->unsigned();
            $table->integer('parametro_semana_id')->unsigned();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('parametro_semana_id')->references('id')->on('parametros_semana')->onDelete('cascade');
            $table->foreign('clase_especifica_id')->references('id')->on('clases_especificas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametros_item_serie');
    }
}
