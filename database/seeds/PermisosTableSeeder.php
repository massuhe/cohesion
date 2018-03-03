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
            ['nombre' => 'VER_ACTIVIDADES_HORAS_LIMITE'],
            ['nombre' => 'CANCELAR_CLASE'],
            ['nombre' => 'SUSPENDER_CLASES'],
            ['nombre' => 'RECUPERAR_CLASE'],
            ['nombre' => 'VER_ROLES'],
            ['nombre' => 'VER_ROL'],
            ['nombre' => 'CREAR_ROL'],
            ['nombre' => 'MODIFICAR_ROL'],
            ['nombre' => 'ELIMINAR_ROL'],
            ['nombre' => 'VER_PERMISOS'],
            ['nombre' => 'VER_ITEMS_INVENTARIO'],
            ['nombre' => 'VER_ITEM_INVENTARIO'],
            ['nombre' => 'CREAR_ITEM_INVENTARIO'],
            ['nombre' => 'MODIFICAR_ITEM_INVENTARIO'],
            ['nombre' => 'ELIMINAR_ITEM_INVENTARIO'],
            ['nombre' => 'VER_CUOTAS'],            
            ['nombre' => 'VER_CUOTA'],
            ['nombre' => 'CREAR_CUOTA'],
            ['nombre' => 'MODIFICAR_CUOTA'],
            ['nombre' => 'ELIMINAR_CUOTA']
        ];
        DB::table('permisos')->insert($permisos);
    }
}
