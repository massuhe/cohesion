<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesRutinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_rutina', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vueltas');
            $table->string('macro_descanso')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('dia_rutina_id')->unsigned();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('dia_rutina_id')->references('id')->on('dias_rutina')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series_rutina');
    }
}
