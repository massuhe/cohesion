<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiasRutinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dias_rutina', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rutina_id')->unsigned();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('rutina_id')->references('id')->on('rutinas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dias_rutina');
    }
}
