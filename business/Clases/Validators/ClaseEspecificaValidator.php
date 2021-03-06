<?php

namespace Business\Clases\Validators;

use Business\Clases\Repositories\AsistenciaRepository;
use Business\Clases\Exceptions\NoAsisteAClaseException;
use Business\Clases\Exceptions\ClaseVencidaException;
use Business\Clases\Exceptions\MaximoAsistentesSuperadoException;
use Business\Clases\Models\Asistencia;
use Business\Clases\Models\ClaseEspecifica;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class ClaseEspecificaValidator
{

    // private const MINUTOS_LIMITE_CONFIRMACION = 60;

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
        $fechaHora->hour($horaArray[0])->minute($horaArray[1])->second($horaArray[2])->subMinutes(Config::get('business.MINUTOS_LIMITE_CONFIRMACION'));//ClaseEspecificaValidator::MINUTOS_LIMITE_CONFIRMACION);
        if(Carbon::now() > $fechaHora) {
            throw new ClaseVencidaException();
        }
    }

    public function validarMaximoAsistentes($claseEspecifica, $asistencias = [])
    {
        if ($claseEspecifica instanceof ClaseEspecifica) {
            $actividad = $claseEspecifica->descripcionClase->actividad;
            $asistenciasCompare = $claseEspecifica->alumnos;
        } else {
            $actividad = ClaseEspecifica::find($claseEspecifica)->descripcionClase->actividad;
            $asistenciasCompare = $asistencias;
        }
        if (sizeOf($asistenciasCompare) > $actividad->cantidad_alumnos_por_clase) {
            throw new MaximoAsistentesSuperadoException();
        }
    }
}