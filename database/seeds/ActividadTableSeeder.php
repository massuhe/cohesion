<?php

use Business\Actividades\Models\Actividad;
use Illuminate\Database\Seeder;

class ActividadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actividades = [[
            'nombre' => 'Musculacion',
            'descripcion' => 'Pa levantar minitas',
            'duracion' => 60,
            'cantidad_alumnos_por_clase' => 7,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'nombre' => 'Pilates',
            'descripcion' => 'Pa que las minitas se pongan fuerte',
            'duracion' => 60,
            'cantidad_alumnos_por_clase' => 5,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'nombre' => 'Boxeo',
            'descripcion' => 'Pa caga a guantazo a la gilada',
            'duracion' => 60,
            'cantidad_alumnos_por_clase' => 10,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]];
        DB::table('actividades')->insert($actividades);
    }
}