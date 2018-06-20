<?php

namespace Business\Rutinas\Validators;

use Business\Rutinas\Exceptions\DetallesInvalidosException;

class RutinaValidator {

    function validateDetallesACargar($parametroSemana, $detalles)
    {
        if (sizeOf($parametroSemana) !== sizeOf($detalles)) {
            throw new DetallesInvalidosException();
        }
        // forEach ($detalles as $detalle) {
        //     $parametro = $parametroSemana->first(function ($p) use ($detalle) {
        //         return $p->id === $detalle['parametroSemana'];
        //     });
        //     if (!$parametro) {
        //         throw new \Exception();
        //     }
        // }
    }

}