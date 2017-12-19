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
        $this->call(PermisosTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RolesPermisosTableSeeder::class);
        $this->call(UsuarioTableSeeder::class);
        $this->call(AlumnoTableSeeder::class);
        $this->call(ActividadTableSeeder::class);
        $this->call(ClaseTableSeeder::class);
        $this->call(ClaseEspecificaTableSeeder::class);
    }
}
