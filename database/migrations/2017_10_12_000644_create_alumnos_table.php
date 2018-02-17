<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id')->unsigned()->unique();
            $table->boolean('tiene_antec_deportivos');
            $table->string('observaciones_antec_deportivos')->nullable();
            $table->boolean('tiene_antec_medicos');
            $table->string('observaciones_antec_medicos')->nullable();
            $table->string('imagen_perfil')->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
}
