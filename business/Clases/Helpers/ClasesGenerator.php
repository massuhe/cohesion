<?php

namespace Business\Clases\Helpers;

use Carbon\Carbon;

class ClasesGenerator
{

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

    public function getDifClases($clasesViejas, $clasesNuevas)
    {
        $response = $this->getClasesAgregarRestore($clasesViejas, $clasesNuevas);
        $clasesBorrar = $clasesViejas->filter(function($v1, $k1) use ($clasesNuevas){
            return $clasesNuevas->first(function($vn, $kn) use ($v1) {
                return $vn['dia_semana'] === $v1->dia_semana
                    && $vn['hora_inicio']->format('H:i:s') === $v1->hora_inicio 
                    && $vn['hora_fin']->format('H:i:s') === $v1->hora_fin;
            }) === null;
        });
        return array_merge($response, ['clasesBorrar' => $clasesBorrar]);
    }

    private function getClasesAgregarRestore($clasesViejas, $clasesNuevas)
    {
        $clasesAgregar = $clasesRestore = [];
        forEach($clasesNuevas as $clase) {
            $c = $clasesViejas->first(function($vv, $kv) use ($clase) {
                    return $vv->dia_semana === $clase['dia_semana']
                        && $vv->hora_inicio === $clase['hora_inicio']->format('H:i:s') 
                        && $vv->hora_fin === $clase['hora_fin']->format('H:i:s');
                });
            if (!$c) {
                $clasesAgregar[] = $clase;
            }
            if($c && $c->trashed()) {
                $clasesRestore[] = $c;
            }
        }
        return ['clasesAgregar' => $clasesAgregar, 'clasesRestore' => $clasesRestore];
    }
}