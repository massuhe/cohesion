<?php

namespace Business\Clases\Validators;

use Business\Clases\Repositories\AsistenciaRepository;
use Business\Clases\Exceptions\NoAsisteAClaseException;
use Business\Clases\Exceptions\ClaseVencidaException;
use Business\Clases\Models\Asistencia;
use Business\Clases\Models\ClaseEspecifica;
use Carbon\Carbon;

class ClaseEspecificaValidator
{

    private const HORA_LIMITE_CONFIRMACION = 1;

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

    public function validateClaseVencida($idClase)
    {
        $clase = ClaseEspecifica::with('descripcionClase')->find($idClase);
        $fechaHora = Carbon::instance($clase->fecha);
        $horaArray = explode(":", $clase->descripcionClase->hora_inicio);
        $fechaHora->hour($horaArray[0] - ClaseEspecificaValidator::HORA_LIMITE_CONFIRMACION)->minute($horaArray[1])->second($horaArray[2]);
        if(Carbon::now() > $fechaHora) {
            throw new ClaseVencidaException();
        }
    }
}