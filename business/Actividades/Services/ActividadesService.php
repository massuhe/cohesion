<?php

namespace Business\Actividades\Services;

use Business\Actividades\Repositories\ActividadRepository;
use Business\Clases\Repositories\ClaseRepository;
use Business\Actividades\Factories\ActividadFactory;
use Business\Actividades\Factories\DiaHorarioFactory;
use Business\Actividades\Factories\RangoHorarioFactory;
use Business\Clases\Services\ClaseService;
use Business\Actividades\Models\Actividad;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ActividadesService {

    private $actividadRepository;
    private $claseRepository;
    private $actividadFactory;
    private $diaHorarioFactory;
    private $rangoHorarioFactory;
    private $claseService;

    public function __construct(
        ActividadRepository $ar,
        ClaseRepository $cr,
        ActividadFactory $af, 
        DiaHorarioFactory $dhf, 
        RangoHorarioFactory $rhf,
        ClaseService $cs) 
    {
        $this->actividadRepository = $ar;
        $this->claseRepository = $cr;
        $this->actividadFactory = $af;
        $this->diaHorarioFactory = $dhf;
        $this->rangoHorarioFactory = $rhf;
        $this->claseService = $cs;
    }

    public function get()
    {
        return $this->actividadRepository->get();
    }

    public function getActividadesHorasLimites() 
    {
        $actividades = $this->actividadRepository->get(['includes' => ['diasHorarios', 'diasHorarios.horarios']]);
        $returnObj = [];
        forEach($actividades as $actividad) {
            $returnObj[] = $this->formatActivityHorasLimites($actividad);
        }
        return $returnObj;
    }

    public function store($data) 
    {
        $actividad = $this->actividadFactory->createActividad($data);
        $diasHorarios = [];
        forEach($data['diasHorarios'] as $diaHorario) {
            $horarios = [];
            $dh = $this->diaHorarioFactory->createDiaHorario($diaHorario);
            forEach($diaHorario['horarios'] as $horario) {
                $h = $this->rangoHorarioFactory->createRangoHorario($horario);
                $horarios[] = $h;
            }
            $dh->horarios = $horarios;
            $diasHorarios[] = $dh;
        }
        $actividad->dias_horarios = $diasHorarios;
        DB::transaction(function () use ($actividad) {
            $this->actividadRepository->store($actividad);
            $clases = $this->claseService->generateClases($actividad);
            $this->claseRepository->storeMany($clases);
        });
        return $actividad;
    }

    private function formatActivityHorasLimites($actividad) 
    {
        $act = [];
        $act['id'] = $actividad->id;
        $act['nombre'] = $actividad->nombre;
        $act['cantidad_alumnos_por_clase'] = $actividad->cantidad_alumnos_por_clase;
        $horas = $this->getAllHours($actividad->diasHorarios);
        $act['hora_minima'] = $this->getMinHour($horas);
        $act['hora_maxima'] = $this->getMaxHour($horas, $actividad->duracion);
        $act['duracion'] = $actividad->duracion;
        return $act;
    }

    private function getAllHours($diasHorarios) 
    {
        $horas = $diasHorarios->map(function ($dh) {
            return $dh->horarios;
        });
        return $horas->flatten();
    }

    private function getMaxHour($horas, $duracion)
    {
        $max = (new Carbon())->setTime(0,0,0);
        forEach($horas as $hora) {
            $horaHasta = (new Carbon())->setTimeFromTimeString($hora->hora_hasta);
            if ($horaHasta->gt($max)) {
                $max = $horaHasta;
            }
        }
        return $max->subMinutes($duracion)->format('H:i:s');
    }

    private function getMinHour($horas)
    {
        $min = (new Carbon())->setTime(23,59,59);
        forEach($horas as $hora) {
            $horaDesde = (new Carbon())->setTimeFromTimeString($hora->hora_desde);
            if ($horaDesde->lt($min)) {
                $min = $horaDesde;
            }
        }
        return $min->format('H:i:s');
    }

}