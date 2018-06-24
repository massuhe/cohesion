<?php
namespace Business\Ejercicios\Factories;

use Business\Ejercicios\Models\Ejercicio;

class EjercicioFactory {

    public function createEjercicio($data)
    {
        $ejercicio = new Ejercicio();
        $ejercicio->nombre = $data['nombre'];
        $ejercicio->descripcion = $data['descripcion'];
        $ejercicio->tipo_ejercicio_id = $data['tipoEjercicio'];
        return $ejercicio;
    }
}