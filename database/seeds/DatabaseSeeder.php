<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsuarioTableSeeder::class);
        $this->call(AlumnoTableSeeder::class);
        $this->call(ActividadTableSeeder::class);
        $this->call(ClaseTableSeeder::class);
        $this->call(ClaseEspecificaSeeder::class);
    }
}
