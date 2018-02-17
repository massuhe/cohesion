<?php
use Business\Actividades\Models\Actividad;
use Business\Actividades\Models\DiaHorario;
use Business\Actividades\Models\RangoHorario;
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
            'descripcion' => 'Actividad física encaminada a hipertrofiar el músculo.',
            'duracion' => 60,
            'cantidad_alumnos_por_clase' => 7,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]];
        $dias = [
            [
                'dia_semana' => 'Lunes', 'actividad_id' => 1, 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'dia_semana' => 'Martes', 'actividad_id' => 1, 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'dia_semana' => 'Miercoles', 'actividad_id' => 1, 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'dia_semana' => 'Jueves', 'actividad_id' => 1, 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'dia_semana' => 'Viernes', 'actividad_id' => 1, 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $rangos = [
            [
                'hora_desde' => '08:00:00', 'hora_hasta' => '21:00:00', 'dia_horario_id' => 1, 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'hora_desde' => '08:00:00', 'hora_hasta' => '21:00:00', 'dia_horario_id' => 2, 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'hora_desde' => '11:00:00', 'hora_hasta' => '21:00:00', 'dia_horario_id' => 3, 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'hora_desde' => '08:00:00', 'hora_hasta' => '21:00:00', 'dia_horario_id' => 4, 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'hora_desde' => '08:00:00', 'hora_hasta' => '20:00:00', 'dia_horario_id' => 5, 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];
        DB::table('actividades')->insert($actividades);
        DB::table('dias_horarios')->insert($dias);
        DB::table('rangos_horarios')->insert($rangos);
    }
}