<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosFijosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_fijos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->integer('importe');
            $table->date('fecha_efectiva')->nullable();
            $table->string('tipo_movimiento');
            $table->boolean('es_personal');
            $table->integer('mes');
            $table->integer('anio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimientos_fijos');
    }
}
