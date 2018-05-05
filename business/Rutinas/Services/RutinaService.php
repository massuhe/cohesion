<?php

namespace Business\Rutinas\Services;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Business\Rutinas\Repositories\RutinaRepository;
use Business\Rutinas\Factories\RutinaFactory;
use Business\Rutinas\Models\ParametroItemSerie;
use Business\Rutinas\Helpers\RutinaHelper;
use Business\Usuarios\Services\UsuarioService;
use Business\Rutinas\Factories\ParametroItemSerieFactory;

class RutinaService {

    private $rutinaRepository;
    private $rutinaFactory;
    private $rutinaHelper;
    private $usuarioService;
    private $parametroItemSerieFactory;

    public function __construct(
        RutinaRepository $rr,
        RutinaFactory $rf, 
        RutinaHelper $rh, 
        UsuarioService $us,
        ParametroItemSerieFactory $pis
    )
    {
        $this->rutinaRepository = $rr;
        $this->rutinaFactory = $rf;
        $this->rutinaHelper = $rh;
        $this->usuarioService = $us;
        $this->parametroItemSerieFactory = $pis;
    }

    public function getById($rutinaId, $resourceOptions)
    {
        $rutina = $this->rutinaRepository->getById($rutinaId, $resourceOptions);
        if (!$rutina) {
            abort(404, 'No se ha encontrado la rutina.');
        }
        return $rutina;
    }

    public function getByAlumno($alumnoId, $numeroRutina, $withUltimaSemana)
    {
        $dataReturn = [];
        $rutina = $this->rutinaRepository->getByAlumno($alumnoId, $numeroRutina);
        $dataReturn['rutina'] = $rutina;
        if ($rutina && $withUltimaSemana) {
            $dataReturn['ultima_semana'] = $ultimaSemana = $this->getUltimaSemanaCargada($rutina);
        }
        return $dataReturn;
    }

    public function store($data)
    {
        $rutina = $this->rutinaFactory->create($data);
        $this->rutinaRepository->storeRutina($rutina);
        return $rutina;
    }

    public function update($idRutina, $data)
    {
        $rutina = $this->rutinaRepository->getById($idRutina);
        $entidadesBorrar = $this->rutinaHelper->updateRutina($rutina, $data);
        $this->rutinaRepository->updateRutina($rutina, $entidadesBorrar);
        return $rutina;
    }

    public function cargarDetallesCurrentAlumnoRutina($semana, $dia, $claseEspecificaId, $detalles)
    {
        $parametroSemanaUpdate = [];
        $parametrosSemana = $this->getRutinaParametrosSemana($dia, $semana);
        forEach ($detalles as $detalle) {
            $idParametroSemana = $detalle['parametroSemana'];
            $parametroSemana = $parametrosSemana->first(function($is) use ($idParametroSemana) { 
                return $is->id === $idParametroSemana; 
            });
            if (!$parametroSemana) {
                throw new \Exception();
            }
            $detalleModel = $this->parametroItemSerieFactory->create([
                'clase' => $claseEspecificaId,
                'carga' => $detalle['carga']
            ]);
            $parametroSemana->parametros->add($detalleModel);
            $parametroSemanaUpdate[] = $parametroSemana;
        }
        $this->rutinaRepository->cargarDetalles($parametroSemanaUpdate);
    }

    private function getUltimaSemanaCargada($rutina)
    {
        $cantidadClasesAlumno = $this->usuarioService->getCantidadClasesAlumno($rutina->alumno_id);
        $ultimaSemanaInfo = $this->rutinaRepository->getUltimaSemanaCargada($rutina->id);
        return $ultimaSemanaInfo->cantidad_cargas < $cantidadClasesAlumno ? 
            $ultimaSemanaInfo->semana 
            : $ultimaSemanaInfo->semana + 1;
    }

    private function getRutinaParametrosSemana($dia, $semana)
    {
        $rutina = $this->findCurrentAlumnoRutina();
        $dia = $rutina->dias->first(function($d) use ($dia) { 
            return $d->id === $dia; 
        });
        $itemsSerie = $dia->series->map(function ($s) { 
            return $s->items;
        })->flatten();
        $parametrosSemana = $itemsSerie->map(function ($is) use ($semana) { 
            return $is->parametrosSemana->first(function($ps) use ($semana) {
                return $ps->semana === $semana;
            });
        })->flatten();
        return $parametrosSemana;
    }

    private function findCurrentAlumnoRutina()
    {
        $alumnoId = 1;// Auth::guard()->user()->alumno->id;
        return $this->rutinaRepository->getByAlumno($alumnoId);
    }

}