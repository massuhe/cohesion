<?php

use Business\Usuarios\Models\Alumno;
use Business\Usuarios\Models\Usuario;
use Business\Clases\Models\Clase;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Usuario::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'nombre' => $faker->firstName,
        'apellido' => $faker->lastName,
        'domicilio' => $faker->address,
        'telefono' => $faker->phoneNumber,
        'observaciones' => $faker->paragraph($nbSentences = 2, $variableNbSentences = true),
        'activo' => $faker->boolean(80)
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Alumno::class, function (Faker\Generator $faker) {

    return [
        'usuario_id' => $faker->unique()->numberBetween(1, 10),
        'tiene_antec_deportivos' => $faker->boolean(50)
    ];
});