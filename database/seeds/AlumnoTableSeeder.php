<?php

use Business\Usuarios\Models\Alumno;
use Business\Usuarios\Models\Usuario;
use Business\Clases\Models\Asistencia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Alumno::class, 10)->create();
        Usuario::insert([
            'email' => 'massuhe@outlook.com',
            'password' => bcrypt('secret'),
            'nombre' => 'Esteban',
            'apellido' => 'Massuh',
            'domicilio' => 'Echague 782',
            'telefono' => '3435106979',
            'observaciones' => '',
            'rol_id' => 2,
            'activo' => true
        ]);
        Alumno::insert([
            'usuario_id' => DB::getPdo()->lastInsertId(),
            'tiene_antec_deportivos' => true
        ]);
        $idAlumno = DB::getPdo()->lastInsertId();
        $asistencias = [
            [
                'asistio' => true,
                'alumno_id' => $idAlumno,
                'clase_especifica_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'asistio' => true,
                'alumno_id' => $idAlumno,
                'clase_especifica_id' => 36,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'asistio' => true,
                'alumno_id' => $idAlumno,
                'clase_especifica_id' => 50,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        Asistencia::insert($asistencias);  
    }
}
