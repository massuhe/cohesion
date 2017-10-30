<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRangosHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rangos_horarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dia_horario_id')->unsigned();
            $table->timestamps();
            $table->time('hora_desde');
            $table->time('hora_hasta');

            /* Claves foráneas */
            $table->foreign('dia_horario_id')->references('id')->on('dias_horarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rangos_horarios');
    }
}
