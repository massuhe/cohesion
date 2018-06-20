<?php

namespace Business\Clases\Services;

use Carbon\Carbon;
use Business\Clases\Factories\ClaseFactory;
use Business\Clases\Repositories\ClaseRepository;
use Business\Clases\Helpers\ClaseHelper;
use Illuminate\Support\Facades\DB;
use DateTime;
use Business\Clases\Repositories\ClaseEspecificaRepository;

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

    public function getAll($option)
    {
        return $this->claseRepository->get($option);
    }

    public function updateClasesActividad($actividad)
    {
        $clasesViejas = $this->claseRepository->getByActividad($actividad->id, true);
        $actividad->load('dias_horarios');
        $clasesNuevas = collect($this->claseHelper->generateClases($actividad));
        $dif = $this->claseHelper->getDifClases($clasesViejas, $clasesNuevas);
        $this->claseRepository->storeMany($dif['clasesAgregar']);
        $this->claseRepository->restoreMany($dif['clasesRestore']);
        $this->claseRepository->deleteMany($dif['clasesBorrar']);
    }


    public function suspenderClasesRango($setParametros)
    {
        $fechaUltimasClasesGeneradas = $this->claseHelper->getLastClases();
        $setParametros['fechaHasta'] = $setParametros['indefinido'] ? '2999-12-31' : $setParametros['fechaHasta'];
        $fechaDesde = Carbon::parse($setParametros['fechaDesde']);
        $fechaHasta = Carbon::parse($setParametros['fechaHasta']);
        $motivo = $setParametros['motivo'];
        $accion = $setParametros['accion'];
        $where = $this->claseHelper->getSuspensionWhereQuery($setParametros);
        DB::transaction(function () use ($accion, $where, $fechaDesde, $fechaHasta, $fechaUltimasClasesGeneradas, $motivo) {
            $idClases = $this->claseRepository->suspenderByParametros($accion, $where, $motivo, $fechaDesde, $fechaHasta, $fechaUltimasClasesGeneradas);
            $this->crearEliminarSuspensiones($accion, $fechaHasta, $fechaUltimasClasesGeneradas, $idClases, $motivo);
        });
    }

    public function getWithAsistencias()
    {
        $fechaHoraActual = Carbon::now()->toDateTimeString();
        $clases = $this->claseRepository->getWithAsistencias($fechaHoraActual);
        return $clases;
    }

    private function crearEliminarSuspensiones($accion, $fechaHasta, $fechaUltimasClasesGeneradas, $idClases, $motivo)
    {
        if($fechaHasta > $fechaUltimasClasesGeneradas){
            if($accion === "1") {
                $currentSuspensiones = $this->claseRepository->getSuspensionesByClases($idClases);
                $newSuspensiones = $this->claseHelper->compareSuspensiones($currentSuspensiones, $idClases, $fechaHasta);
                $this->claseRepository->addSuspensiones($newSuspensiones['add'], $fechaHasta, $motivo);
                $this->claseRepository->updateSuspensiones($newSuspensiones['update'], $fechaHasta, $motivo);
            } else {
                $this->claseRepository->removeSuspensiones($idClases, $fechaHasta);
            }
        }
    }

}