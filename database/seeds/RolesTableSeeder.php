<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = [
            ['nombre' => 'Admin', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['nombre' => 'Alumno', 'created_at' => new DateTime(), 'updated_at' => new DateTime()]
        ];
        DB::table('roles')->insert($roles);
    }
}
