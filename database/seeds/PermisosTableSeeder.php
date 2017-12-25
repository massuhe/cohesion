<?php

use Illuminate\Database\Seeder;

class PermisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permisos = [
            ['nombre' => 'VER_USUARIOS'],
            ['nombre' => 'VER_USUARIO'],
            ['nombre' => 'CREAR_USUARIO'],
            ['nombre' => 'ELIMINAR_USUARIO'],
            ['nombre' => 'MODIFICAR_USUARIO'],
            ['nombre' => 'VER_CLASES'],
            ['nombre' => 'VER_CLASE'],
            ['nombre' => 'CREAR_CLASE'],
            ['nombre' => 'MODIFICAR_CLASE'],
            ['nombre' => 'ELIMINAR_CLASE'],
            ['nombre' => 'VER_CLASES_ESPECIFICAS'],
            ['nombre' => 'VER_CLASE_ESPECIFICA'],
            ['nombre' => 'VER_LISTADO_CLASES_ESPECIFICAS'],
            ['nombre' => 'VER_LISTADO_CLASES_ESPECIFICAS_ALUMNO'],
            ['nombre' => 'MODIFICAR_CLASE_ESPECIFICA'],
            ['nombre' => 'VER_ACTIVIDADES'],
            ['nombre' => 'VER_ACTIVIDAD'],
            ['nombre' => 'VER_LISTADO_ACTIVIDADES'],
            ['nombre' => 'CREAR_ACTIVIDAD'],
            ['nombre' => 'MODIFICAR_ACTIVIDAD'],
            ['nombre' => 'ELIMINAR_ACTIVIDAD'],
            ['nombre' => 'VER_ACTIVIDADES_HORAS_LIMITE']
        ];
        DB::table('permisos')->insert($permisos);
    }
}
