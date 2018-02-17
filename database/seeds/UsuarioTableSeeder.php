<?php

use Business\Usuarios\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Usuario::class, 15)->create();
        Usuario::insert([
            'email' => 'admin@cohesion.com',
            'password' => bcrypt('secret'),
            'nombre' => 'Admin',
            'apellido' => 'Cohesion',
            'domicilio' => 'Calle 123',
            'telefono' => '155201478',
            'rol_id' => 1,
            'activo' => true
        ]);
    }
}
