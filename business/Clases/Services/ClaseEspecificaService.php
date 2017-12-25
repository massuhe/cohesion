<?php

namespace Business\Clases\Services;

use Business\Clases\Repositories\ClaseEspecificaRepository;
use Business\Actividades\Repositories\ActividadRepository;
use Business\Clases\Helpers\ClaseEspecificaHelper;
use Business\Clases\Validators\ClaseEspecificaValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use DateTime;
use Business\Usuarios\Repositories\AlumnoRepository;

class ClaseEspecificaService
{

    private $claseEspecificaRepository;
    private $actividadRepository;
    private $alumnoRepository;
    private $claseEspecificaHelper;
    private $claseEspecificaValidator;

    public function __construct(
        ClaseEspecificaRepository $cer,
        ActividadRepository $ar,
        ClaseEspecificaHelper $ceh,
        ClaseEspecificaValidator $cev,
        AlumnoRepository $alr
    ) {
        $this->claseEspecificaRepository = $cer;
        $this->actividadRepository = $ar;
        $this->claseEspecificaHelper = $ceh;
        $this->claseEspecificaValidator = $cev;
        $this->alumnoRepository = $alr;
    }

    public function getClasesByWeekActivity($week, $idActividad, $isAlumno)
    {
        $actividad = $this->actividadRepository->getById($idActividad);
        $firstDayWeek = $this->claseEspecificaHelper->getFirstDayOfWeek($week);
        $lastDayWeek = $this->claseEspecificaHelper->getLastDayOfWeek($firstDayWeek);
        $clases = $this->claseEspecificaRepository->getByWeekActivity($firstDayWeek, $lastDayWeek, $actividad);
        $returnObj = ['dias' => $this->claseEspecificaHelper->groupClasesByDay($clases, $isAlumno)];
        if ($isAlumno) {
            $returnObj = array_merge($returnObj, ['alumno' => $this->getAlumnoInformation($clases)]);
        }
        return $returnObj;
    }

    public function getAll($option)
    {
        return $this->claseEspecificaRepository->get();
    }

    public function getById($id, $option)
    {
        return $this->claseEspecificaRepository->getById($id, $option);
    }

    public function update($data, $idClaseEspecifica)
    {
        $claseEspecifica = $this->claseEspecificaRepository->update($data, $idClaseEspecifica);
        return $this->claseEspecificaHelper->formatClaseUpdate($claseEspecifica);
    }

    public function cancelar($idClase)
    {
        $idAlumno = $this->getCurrentAlumnoId();
        $this->claseEspecificaValidator->validateAsisteAClase($idAlumno, $idClase);
        DB::transaction(function () use ($idAlumno, $idClase) {
            $this->claseEspecificaRepository->removeAsistencia($idAlumno, $idClase);
            $this->alumnoRepository->addPosibilidadRecuperar($idAlumno);
        });
    }

    private function getAlumnoInformation($clases)
    {
        $alumnoId = $this->getCurrentAlumnoId();
        $clasesArr = $clases->filter(function ($value, $key) use ($alumnoId) {
            return $value->alumnos->first(function ($value, $key) use ($alumnoId) {
                return $value->id === $alumnoId;
            }) !== null;
        })->map(function ($key, $value) {
            return $key->id;
        });
        return [
            'clases' => array_values($clasesArr->toArray()),
            'puede_recuperar' => $this->claseEspecificaRepository->getPuedeRecuperar($alumnoId)
        ];
    }

    private function getCurrentAlumnoId()
    {
        return Auth::guard()->user()->id;
    }

}
