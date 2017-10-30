<?php

namespace Business\Clases\Services;

use Illuminate\Support\Carbon;
use Business\Clases\Factories\ClaseFactory;
use DateTime;

class ClaseService {

    private $claseFactory;

    public function __construct(ClaseFactory $cf) 
    {
        $this->claseFactory = $cf;
    }

    public function generateClases($actividad)
    {
        $duracion = $actividad->duracion;
        $diasHorarios = $actividad->dias_horarios;
        $clases = [];
        foreach ($diasHorarios as $diaHorario) {
            $rangosHorarios = $diaHorario->horarios;
            forEach($rangosHorarios as $horario) {
                $horaInicio = Carbon::parse($horario->hora_desde);
                $horaFin = Carbon::parse($horario->hora_hasta);
                for($i = $horaInicio->copy(); $i < $horaFin; $i->addMinutes($duracion)) {
                    $clases[] = [
                        'dia_semana' => $diaHorario->dia_semana,
                        'hora_inicio' => $i->copy(),
                        'hora_fin' => $i->copy()->addMinutes($duracion),
                        'actividad_id' => $actividad->id
                    ];
                }
            }
        }
        return $clases;
    }

}