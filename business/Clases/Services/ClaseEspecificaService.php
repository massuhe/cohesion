<?php

namespace Business\Clases\Services;

use Business\Clases\Repositories\ClaseEspecificaRepository;
use Business\Actividades\Repositories\ActividadRepository;
use Illuminate\Support\Carbon;
use DateTime;

class ClaseEspecificaService {

    private $claseEspecificaRepository;
    private $actividadRepository;

    public function __construct(ClaseEspecificaRepository $cer, ActividadRepository $ar) {
        $this->claseEspecificaRepository = $cer;
        $this->actividadRepository = $ar;
    }

    public function getClasesByWeekActivity($week, $idActividad, $isAlumno) {
        $returnObj = [];
        $actividad = $this->actividadRepository->getById($idActividad);
        $returnObj = $this->getActivityInformation($actividad);
        $semana = Carbon::createFromFormat('m-d-Y', $week)->setTime(0,0,0);
        $firstDayWeek = ($semana->dayOfWeek == Carbon::MONDAY) ? $semana->copy() : $semana->copy()->previous(Carbon::MONDAY);
        $lastDayWeek = $firstDayWeek->copy()->next(Carbon::SATURDAY)->setTime(23,59,59);
        $clases = $this->claseEspecificaRepository->getByWeekActivity($firstDayWeek, $lastDayWeek, $actividad);
        $returnObj = array_merge($returnObj, ['dias' => $this->groupClasesByDay($clases, $isAlumno)]);
        if($isAlumno) { // Va a cambiar cuando se tenga implementado el login
            $returnObj = array_merge($returnObj, ['alumno' => $this->getAlumnoInformation($clases)]);
        }
        return $returnObj;
    }

    private function getAlumnoInformation($clases) {
        $clasesArr = $clases->filter(function($value, $key){
            return $value->alumnos->first(function($value, $key){
                return $value->id === 12;
            }) !== null;
        })->map(function($key, $value) {
            return $key->id;
        });
        return ['clases' => array_values($clasesArr->toArray()), 'puede_recuperar'=> 1];
    }

    private function getActivityInformation($activity) {
        $returnObj = [];
        $returnObj['cantidad_alumnos_por_clase'] = $activity->cantidad_alumnos_por_clase;
        $returnObj['hora_minima'] = '08:00:00';
        $returnObj['hora_maxima'] = '22:00:00';
        $returnObj['duracion_actividad'] = $activity->duracion;
        return $returnObj;
    }

    private function groupClasesByDay($clases, $isAlumno) {
        $daysArray = [];
        foreach($clases as $clase) {
            !isset($daysArray[$clase->fecha->dayOfWeek]['fecha']) ? 
                $daysArray[$clase->fecha->dayOfWeek]['fecha'] = $clase->fecha->format('m-d-Y') : '';
            $daysArray[$clase->fecha->dayOfWeek]['clases'][] = $this->formatClase($clase, $isAlumno);
        }
        return array_values($daysArray);
    }

    private function formatClase($clase, $isAlumno) {
        return [
            'id' => $clase->id,
            'hora_inicio' => $clase->hora_inicio,
            'alumnos' => $isAlumno ? sizeOf($clase->alumnos) : $this->formatAlumnos($clase->alumnos),
            'suspendida' => $clase->suspendida,
            'motivo' => $clase->motivo
        ];
    }

    private function formatAlumnos($alumnos) {
        $alumnosArray = [];
        foreach($alumnos as $alumno) {
            $alumnosArray[] = [
                'nombre' => $alumno->usuario->nombre,
                'apellido' => $alumno->usuario->apellido
            ];
        }
        return $alumnosArray;
    }

}
