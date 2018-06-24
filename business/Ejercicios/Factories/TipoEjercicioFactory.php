<?php

namespace Business\Ejercicios\Factories;

use Business\Ejercicios\Models\TipoEjercicio;

class TipoEjercicioFactory {

    public function createTipoEjercicio($data)
    {
        $tipoEjercicio = new TipoEjercicio();
        $tipoEjercicio->nombre = $data['nombre'];
        return $tipoEjercicio;
    }
}