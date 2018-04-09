<?php

use Business\Usuarios\Models\Alumno;
use Business\Usuarios\Models\Usuario;
use Business\Clases\Models\Asistencia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlumnoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Alumno::class, 15)->create();
        Usuario::insert([
            'email' => 'massuhe@outlook.com',
            'password' => bcrypt('secret'),
            'nombre' => 'Esteban',
            'apellido' => 'Massuh',
            'domicilio' => 'Echague 782',
            'telefono' => '3435106979',
            'rol_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'activo' => true
        ]);
        Alumno::insert([
            'usuario_id' => DB::getPdo()->lastInsertId(),
            'tiene_antec_deportivos' => true,
            'tiene_antec_medicos' => true
        ]);
        $idAlumno = DB::getPdo()->lastInsertId();
        $idUsersWithAlumno = DB::table('alumnos')->get()->map(function($a){return $a->usuario_id;});
        Usuario::whereIn('id', $idUsersWithAlumno)->update(['rol_id' => 2]);
    }
}
