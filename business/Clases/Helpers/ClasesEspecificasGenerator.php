<?php

namespace Business\Clases\Helpers;

use Business\Clases\Models\Clase;
use Business\Clases\Models\ClaseEspecifica;
use Carbon\Carbon;


class ClasesEspecificasGenerator 
{
    private $addDays = [
        'Lunes' => 0,
        'Martes' => 1,
        'Miercoles' => 2,
        'Jueves' => 3,
        'Viernes' => 4,
        'Sabado' => 5
    ];

    public function generate($addSemanas = 0, $idActividad = 0)
    {
        $semana = $this->getSemana($addSemanas);
        $this->checkNoExistenClasesEspecificas($semana, $idActividad);
        $clases = $idActividad === 0 ? Clase::all() : Clase::where('actividad_id', $idActividad)->get();
        $clasesEspecificas = [];
        foreach($clases as $clase) {
            $nuevaClase = new ClaseEspecifica();
            $nuevaClase->descripcionClase()->associate($clase);
            $nuevaClase->fecha = $this->getFecha($semana, $clase->dia_semana);
            $suspension = $this->checkSuspendida($clase, $nuevaClase->fecha);
            $nuevaClase->suspendida = $suspension['suspendida'];
            $nuevaClase->motivo = $suspension['motivo'];
            $nuevaClase->save();
            $nuevaClase->alumnos()->attach($this->getAlumnos($clase->alumnos));
        }
        return $semana;
    }

    public function borrar($addSemanas = 0, $idActividad = 0)
    {
        $semana = $this->getSemana($addSemanas);
        $clases = $idActividad === 0 ? Clase::withTrashed()->get() : Clase::withTrashed()->where('actividad_id', $idActividad)->get();
        $idClases = $clases->map(function ($c) { return $c->id;});
        ClaseEspecifica::whereIn('descripcion_clase', $idClases)->where('fecha', '>=', $semana)->delete();
        return $semana;
    }

    private function getSemana($addSemanas)
    {
        $semana = new Carbon('next monday');
        $semana->addWeeks($addSemanas);
        return $semana;
    }

    private function getFecha($semana, $diaSemana)
    {
        return $semana->copy()->addDays($this->addDays[$diaSemana]);
    }

    private function getAlumnos($alumnos)
    {
        $a = [];
        foreach($alumnos as $alumno) {
            $a[$alumno->id] = [
                'asistio' => true,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
        }
        return $a;
    }

    private function checkNoExistenClasesEspecificas($semana, $idActividad)
    {
        if ($idActividad === 0) {
            $clasesCount = ClaseEspecifica::where('fecha', '>=', $semana)->count();
        }
        else {
            $clasesCount = 
            ClaseEspecifica::join('clases', 'clases_especificas.descripcion_clase', '=', 'clases.id')
                ->where('fecha', '>=', $semana)->where('clases.actividad_id', $idActividad)->count();
        }
        if($clasesCount > 0) {
            throw new \Exception('Ya se generaron clases para dicha semana');
        }
    }

    private function checkSuspendida($clase, $fecha)
    {
        $suspensiones = $clase->suspensiones;
        $suspendida = false;
        $motivo = '';
        forEach($suspensiones as $suspension) {
            if($suspension->fecha_hasta >= $fecha) {
                $suspendida = true;
                $motivo = $suspension->motivo;
            }
        }
        return ['suspendida' => $suspendida, 'motivo' => $motivo];
    }
    
}