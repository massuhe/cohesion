<?php

namespace Business\Clases\Helpers;

class FormatHelper
{
    public function formatClaseUpdate($claseEspecifica)
    {
        $claseEspecificaReturn = $claseEspecifica->toArray();
        $claseEspecificaReturn['alumnos'] = $claseEspecifica->alumnos->map(function($alumno){
            return ['id' => $alumno->id, 'asistio' => $alumno->asistencia->asistio];
        });
        return $claseEspecificaReturn;
    }

    public function formatAlumnos($alumnos) {
        $alumnosArray = [];
        foreach($alumnos as $alumno) {
            $alumnosArray[] = [
                'nombre' => $alumno->usuario->nombre,
                'apellido' => $alumno->usuario->apellido
            ];
        }
        return $alumnosArray;
    }

    public function groupClasesByDay($clases, $isAlumno) {
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
}