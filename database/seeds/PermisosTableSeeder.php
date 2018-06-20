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
            ['nombre' => 'VER_USUARIOS'],               // id = 1
            ['nombre' => 'VER_USUARIO'],
            ['nombre' => 'CREAR_USUARIO'],
            ['nombre' => 'ELIMINAR_USUARIO'],
            ['nombre' => 'MODIFICAR_USUARIO'],
            ['nombre' => 'VER_CLASES'],
            ['nombre' => 'VER_CLASE'],
            ['nombre' => 'CREAR_CLASE'],
            ['nombre' => 'MODIFICAR_CLASE'],
            ['nombre' => 'ELIMINAR_CLASE'],             // id = 10
            ['nombre' => 'VER_CLASES_ESPECIFICAS'],
            ['nombre' => 'VER_CLASE_ESPECIFICA'],
            ['nombre' => 'VER_LISTADO_CLASES_ESPECIFICAS'],
            ['nombre' => 'VER_LISTADO_CLASES_ESPECIFICAS_ALUMNO'],
            ['nombre' => 'MODIFICAR_CLASE_ESPECIFICA'],
            ['nombre' => 'VER_ACTIVIDADES'],
            ['nombre' => 'VER_ACTIVIDAD'],
            ['nombre' => 'VER_LISTADO_ACTIVIDADES'],
            ['nombre' => 'CREAR_ACTIVIDAD'],
            ['nombre' => 'MODIFICAR_ACTIVIDAD'],        // id = 20
            ['nombre' => 'ELIMINAR_ACTIVIDAD'],
            ['nombre' => 'VER_ACTIVIDADES_HORAS_LIMITE'],
            ['nombre' => 'CANCELAR_CLASE'],
            ['nombre' => 'SUSPENDER_CLASES'],
            ['nombre' => 'RECUPERAR_CLASE'],
            ['nombre' => 'VER_ROLES'],
            ['nombre' => 'VER_ROL'],
            ['nombre' => 'CREAR_ROL'],
            ['nombre' => 'MODIFICAR_ROL'],
            ['nombre' => 'ELIMINAR_ROL'],               // id = 30
            ['nombre' => 'VER_PERMISOS'],
            ['nombre' => 'VER_ITEMS_INVENTARIO'],
            ['nombre' => 'VER_ITEM_INVENTARIO'],
            ['nombre' => 'CREAR_ITEM_INVENTARIO'],
            ['nombre' => 'MODIFICAR_ITEM_INVENTARIO'],
            ['nombre' => 'ELIMINAR_ITEM_INVENTARIO'],
            ['nombre' => 'VER_CUOTAS'],            
            ['nombre' => 'VER_CUOTA'],
            ['nombre' => 'CREAR_CUOTA'],
            ['nombre' => 'MODIFICAR_CUOTA'],            // id = 40
            ['nombre' => 'ELIMINAR_CUOTA'],
            ['nombre' => 'LISTADO_ALUMNOS'],
            ['nombre' => 'VER_MOVIMIENTOS'],
            ['nombre' => 'VER_MOVIMIENTO'],
            ['nombre' => 'CREAR_MOVIMIENTO'],
            ['nombre' => 'REPORTE_INGRESOS_ALUMNOS'],
            ['nombre' => 'VER_RUTINAS'],
            ['nombre' => 'VER_RUTINA'],
            ['nombre' => 'CREAR_RUTINA'],
            ['nombre' => 'MODIFICAR_RUTINA'],           // id = 50
            ['nombre' => 'ELIMINAR_RUTINA'],
            ['nombre' => 'VER_RUTINA_ALUMNO'],
            ['nombre' => 'CARGAR_DETALLES'],
            ['nombre' => 'CARGAR_DETALLES_ALUMNO'],
            ['nombre' => 'VER_CLASES_ESPECIFICAS_ALUMNO'],
            ['nombre' => 'VER_EJERCICIOS'],
            ['nombre' => 'VER_PERFIL'],
            ['nombre' => 'VER_PERFIL_ALUMNO'],
            ['nombre' => 'MODIFICAR_ALUMNO'],
            ['nombre' => 'VER_LISTADO_PAGOS']           // id = 60
        ];
        DB::table('permisos')->insert($permisos);
    }
}
