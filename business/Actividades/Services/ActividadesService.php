<?php

namespace Business\Actividades\Services;

use Business\Actividades\Repositories\ActividadRepository;
use Business\Actividades\Helpers\ActividadHelper;
use Business\Actividades\Models\Actividad;
use Business\Actividades\Factories\ActividadFactory;
use Business\Clases\Repositories\ClaseRepository;
use Business\Clases\Repositories\ClaseEspecificaRepository;
use Business\Clases\Services\ClaseService;
use Business\Actividades\Exceptions\EliminarMusculacionException;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ActividadesService {

    private $actividadRepository;
    private $claseRepository;
    private $claseEspecificaRepository;
    private $actividadFactory;
    private $claseService;
    private $actividadHelper;

    public function __construct(
        ActividadRepository $ar,
        ClaseRepository $cr,
        ClaseEspecificaRepository $cer,
        ActividadFactory $af,
        ClaseService $cs,
        ActividadHelper $ah) 
    {
        $this->actividadRepository = $ar;
        $this->claseRepository = $cr;
        $this->claseEspecificaRepository = $cer;
        $this->actividadFactory = $af;
        $this->claseService = $cs;
        $this->actividadHelper = $ah;
    }

    public function getAll($options)
    {
        return $this->actividadRepository->get($options);
    }

    public function getById($idActividad, $option)
    {
        $actividad = $this->actividadRepository->getById($idActividad, $option);
        if(!$actividad) {
            abort(404, 'No se ha encontrado la actividad.');
        }
        return $actividad;
    }

    public function getListado()
    {
        return $this->actividadRepository->getListado();
    }

    public function getActividadesHorasLimites() 
    {
        $actividades = $this->actividadRepository->get(['includes' => ['dias_horarios', 'dias_horarios.horarios']]);
        $returnObj = [];
        forEach($actividades as $actividad) {
            $returnObj[] = $this->formatActivityHorasLimites($actividad);
        }
        return $returnObj;
    }

    public function store($data) 
    {
        $actividad = $this->actividadFactory->createActividad($data);
        $diasHorarios = $this->actividadHelper->generateDiasHorarios($data['diasHorarios']);
        $actividad->dias_horarios = $diasHorarios;
        DB::transaction(function () use ($actividad) {
            $this->actividadRepository->store($actividad);
            $clases = $this->actividadHelper->generateClases($actividad);
            $this->claseRepository->storeMany($clases);
            $this->actividadHelper->generate(0, $actividad->id);
        });
        return $actividad;
    }

    public function update($data, $idActividad)
    {
        $diasNuevos = $this->actividadHelper->generateDiasHorarios($data['diasHorarios']);
        $data['diasHorarios'] = $diasNuevos;
        return DB::transaction(function () use ($data, $idActividad) {
            $actividad = $this->actividadRepository->update($idActividad, $data);
            $this->claseService->updateClasesActividad($actividad);
            $this->actividadHelper->borrar(0, $idActividad);
            $this->actividadHelper->generate(0, $idActividad);
        });
    }

    public function delete($idActividad)
    {
        if (intval($idActividad) === 1) {
            throw new EliminarMusculacionException();
        }
        DB::transaction(function () use ($idActividad) {
            $this->actividadRepository->delete($idActividad);
            $this->claseRepository->deleteWhere('actividad_id',$idActividad);
            $this->claseEspecificaRepository->deleteByActividad($idActividad);
        });
    }

    private function formatActivityHorasLimites($actividad) 
    {
        $act = [];
        $act['id'] = $actividad->id;
        $act['nombre'] = $actividad->nombre;
        $act['cantidad_alumnos_por_clase'] = $actividad->cantidad_alumnos_por_clase;
        $horas = $this->getAllHours($actividad->dias_horarios);
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