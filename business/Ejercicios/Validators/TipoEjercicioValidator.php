<?php

namespace Business\Ejercicios\Validators;

use Business\Ejercicios\Models\Ejercicio;
use Business\Ejercicios\Exceptions\TipoEjercicioAsignadoAEjercicioException;

class TipoEjercicioValidator {

    public function validateTipoEjercicioNoAsignadoAEjercicio($idTipoEjercicio)
    {
        $cuentaEjercicios = Ejercicio::where('tipo_ejercicio_id', $idTipoEjercicio)->count();
        if ($cuentaEjercicios > 0) {
            throw new TipoEjercicioAsignadoAEjercicioException();
        }
    }

}