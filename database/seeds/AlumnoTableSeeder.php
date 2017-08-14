<?php

use Illuminate\Database\Seeder;
use App\Models\Alumno;

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
    }
}
