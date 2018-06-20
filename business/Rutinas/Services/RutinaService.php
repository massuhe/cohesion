<?php

namespace Business\Rutinas\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Business\Rutinas\Repositories\RutinaRepository;
use Business\Rutinas\Factories\RutinaFactory;
use Business\Rutinas\Models\ParametroItemSerie;
use Business\Rutinas\Helpers\RutinaHelper;
use Business\Usuarios\Services\UsuarioService;
use Business\Rutinas\Factories\ParametroItemSerieFactory;
use Business\Usuarios\Repositories\AlumnoRepository;
use Business\Usuarios\Models\Alumno;
use Business\Rutinas\Validators\RutinaValidator;
use Business\Rutinas\Exceptions\DetallesInvalidosException;

class RutinaService {

    private $rutinaRepository;
    private $rutinaFactory;
    private $rutinaHelper;
    private $usuarioService;
    private $parametroItemSerieFactory;
    private $alumnoRepository;
    private $rutinaValidator;

    public function __construct(
        RutinaRepository $rr,
        RutinaFactory $rf, 
        RutinaHelper $rh, 
        UsuarioService $us,
        ParametroItemSerieFactory $pis,
        AlumnoRepository $ar,
        RutinaValidator $rv
    )
    {
        $this->rutinaRepository = $rr;
        $this->rutinaFactory = $rf;
        $this->rutinaHelper = $rh;
        $this->usuarioService = $us;
        $this->parametroItemSerieFactory = $pis;
        $this->alumnoRepository = $ar;
        $this->rutinaValidator = $rv;
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
        if (!$alumnoId) {
            $alumno = Auth::guard()->user()->alumno;
        } else {
            $alumno = $this->alumnoRepository->getById($alumnoId)->load('usuario');
        }
        $dataReturn['alumno'] = $alumno->usuario->nombre . ' ' . $alumno->usuario->apellido;
        $rutina = $this->rutinaRepository->getByAlumno($alumno->id, $numeroRutina);
        $dataReturn['rutina'] = $rutina;
        $dataReturn['clases'] = $this->getClasesParametrosItemSerie($rutina);
        if ($rutina && $withUltimaSemana) {
            $dataReturn['ultima_semana'] = $ultimaSemana = $this->getUltimaSemanaCargada($rutina);
        }
        return $dataReturn;
    }

    public function store($data)
    {
        $rutina = $this->rutinaFactory->create($data);
        DB::transaction(function () use ($rutina) {
            $numeroUltimaRutina = $this->cerrarUltimaRutina($rutina->alumno_id);
            $rutina->numero_rutina = $numeroUltimaRutina + 1;
            $this->rutinaRepository->storeRutina($rutina);
        });
        return $rutina;
    }

    public function update($idRutina, $data)
    {
        $rutina = $this->rutinaRepository->getById($idRutina);
        $entidadesBorrar = $this->rutinaHelper->updateRutina($rutina, $data);
        $this->rutinaRepository->updateRutina($rutina, $entidadesBorrar);
        return $rutina;
    }

    public function cargarDetallesRutinaAlumno($idAlumno, $semana, $dia, $claseEspecificaId, $detalles)
    {
        $parametroSemanaUpdate = [];
        $parametrosSemana = $this->getRutinaParametrosSemana($idAlumno, $dia, $semana);
        $this->rutinaValidator->validateDetallesACargar($parametrosSemana, $detalles);
        forEach ($detalles as $detalle) {
            $idParametroSemana = $detalle['parametroSemana'];
            $parametroSemana = $parametrosSemana->first(function($is) use ($idParametroSemana) { 
                return $is->id === $idParametroSemana; 
            });
            if (!$parametroSemana) {
                throw new DetallesInvalidosException();
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
        if (!$ultimaSemanaInfo) {
            return 1;
        }
        return $ultimaSemanaInfo->cantidad_cargas < $cantidadClasesAlumno ? 
            $ultimaSemanaInfo->semana 
            : $ultimaSemanaInfo->semana + 1;
    }

    private function getRutinaParametrosSemana($idAlumno, $dia, $semana)
    {
        $rutina = $this->findAlumnoRutina($idAlumno);
        $dia = $rutina->dias[$dia];
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

    private function findAlumnoRutina($idAlumno)
    {
        $alumnoId = $idAlumno ? $idAlumno : Auth::guard()->user()->alumno->id;
        return $this->rutinaRepository->getByAlumno($alumnoId);
    }

    private function cerrarUltimaRutina($alumnoId)
    {
        $rutinaVieja = $this->rutinaRepository->getByAlumno($alumnoId);
        if (!$rutinaVieja) {
            return 0;
        }
        $this->rutinaRepository->cerrarRutina($rutinaVieja);
        return $rutinaVieja->numero_rutina;
    }

    private function getClasesParametrosItemSerie($rutina)
    {
        if (!$rutina) {
            return [];
        }
        $clasesParametrosItemSerie = $rutina->dias->map(function ($dia) {
            return $dia->series->map(function ($serie) {
                return $serie->items->map(function ($item) {
                    return $item->parametrosSemana->map(function ($ps) {
                        return $ps->parametros->map(function ($p) {
                            return $p->clase;
                        });
                    });
                });
            });
        })
        ->flatten()
        ->unique(function ($item) {
            return $item->id;
        });
        return $clasesParametrosItemSerie;
    }

}