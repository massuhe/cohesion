<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiasHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dias_horarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('actividad_id')->unsigned();
            $table->timestamps();
            $table->string('dia_semana');

            /* Claves foráneas */
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dias_horarios');
    }
}
