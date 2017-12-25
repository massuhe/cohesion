<?php

namespace Business\Clases\Validators;

use Business\Clases\Repositories\AsistenciaRepository;
use Business\Clases\Exceptions\NoAsisteAClaseException;
use Business\Clases\Models\Asistencia;

class ClaseEspecificaValidator
{

    public function validateAsisteAClase($idAlumno, $idClase)
    {
        $asiste = Asistencia::where([
            ['alumno_id', '=', $idAlumno],
            ['clase_especifica_id', '=', $idClase]
        ])->count() > 0;
        if(!$asiste){
            throw new NoAsisteAClaseException();
        }
    }
}