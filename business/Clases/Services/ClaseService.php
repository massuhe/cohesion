<?php

namespace Business\Clases\Services;

use Carbon\Carbon;
use Business\Clases\Factories\ClaseFactory;
use Business\Clases\Repositories\ClaseRepository;
use Business\Clases\Helpers\ClaseHelper;
use DateTime;

class ClaseService {

    private $claseRepository;
    private $claseFactory;
    private $claseHelper;

    public function __construct(ClaseRepository $cr, ClaseFactory $cf, ClaseHelper $ch) 
    {
        $this->claseRepository = $cr;
        $this->claseFactory = $cf;
        $this->claseHelper = $ch;
    }

    public function updateClasesActividad($actividad)
    {
        $clasesViejas = $this->claseRepository->getWhere('actividad_id', $actividad->id);
        $actividad->load('dias_horarios');
        $clasesNuevas = collect($this->generateClases($actividad));
        $dif = $this->getDifClases($clasesViejas, $clasesNuevas);
        $this->claseRepository->storeMany($dif['clasesAgregar']->toArray());
        $this->claseRepository->deleteMany($dif['clasesBorrar']);
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

    public function suspenderClasesRango($setParametros)
    {
        $fechaUltimasClasesGeneradas = Carbon::now()->endOfWeek()->addWeeks(2);
        forEach($setParametros as $set) {
            $fechaHasta = Carbon::parse($set['fechaHasta']);
            $motivo = $set['motivo'];
            $where = $this->claseHelper->getSuspensionWhereQuery($set);
            $this->claseRepository->suspenderByParametros($where, $motivo, $fechaHasta, $fechaUltimasClasesGeneradas);
        }
    }

    private function getDifClases($clasesViejas, $clasesNuevas)
    {
        $clasesAgregar = $clasesNuevas->filter(function($v, $k) use ($clasesViejas){
            return $clasesViejas->first(function($vv, $kv) use ($v) {
                $khe = $v['hora_inicio']->format('H:i:s');
                return $vv->dia_semana === $v['dia_semana']
                    && $vv->hora_inicio === $v['hora_inicio']->format('H:i:s') 
                    && $vv->hora_fin === $v['hora_fin']->format('H:i:s');
            }) === null;
        });
        $clasesBorrar = $clasesViejas->filter(function($v1, $k1) use ($clasesNuevas){
            return $clasesNuevas->first(function($vn, $kn) use ($v1) {
                return $vn['dia_semana'] === $v1->dia_semana
                    && $vn['hora_inicio']->format('H:i:s') === $v1->hora_inicio 
                    && $vn['hora_fin']->format('H:i:s') === $v1->hora_fin;
            }) === null;
        });
        return ['clasesAgregar' => $clasesAgregar, 'clasesBorrar' => $clasesBorrar];
    }

}