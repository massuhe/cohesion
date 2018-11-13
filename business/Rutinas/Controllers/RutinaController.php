<?php

namespace Business\Rutinas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Business\Rutinas\Services\RutinaService;
use Business\Rutinas\Models\Rutina;

class RutinaController extends Controller
{
    private $rutinaService;

    public function __construct(RutinaService $rs)
    {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
        $this->rutinaService = $rs;
    }

    public function show(Request $request, $rutinaId)
    {
        if (!$this->tiene_permiso('VER_RUTINA')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->rutinaService->getById($rutinaId, $resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        return $this->ok($parsedData);
    }

    public function store(Request $request)
    {
        if (!$this->tiene_permiso('CREAR_RUTINA')) {
            return $this->forbidden();
        }
        $rutina = $this->rutinaService->store($request->get('rutina'));
        return $this->ok($rutina);
    }

    public function update(Request $request, $idRutina)
    {
        if (!$this->tiene_permiso('MODIFICAR_RUTINA')) {
            return $this->forbidden();
        }
        $rutina = $this->rutinaService->update($idRutina, $request->get('rutina'));
        return $this->ok($rutina);
    }

    public function getByAlumno(Request $request, $alumnoId = null)
    {
        $isAlumno = $this->tiene_permiso('VER_RUTINA_ALUMNO');
        if (!$this->tiene_permiso('VER_RUTINA') && !$isAlumno) {
            return $this->forbidden();
        }
        $numero_rutina = $request->get('numeroRutina');
        $withUltimaSemana = $request->get('withUltimaSemana') === '1';
        $rutina = $this->rutinaService->getByAlumno($alumnoId, $numero_rutina, $withUltimaSemana);
        return $this->ok($rutina);
    }

    public function cargarDetallesRutina(Request $request, $alumnoId = null)
    {
        $isAlumno = false;// $this->tiene_permiso('CARGAR_DETALLES_ALUMNO');
        // if (!$isAlumno && !$this->tiene_permiso('CARGAR_DETALLES')) {
        //     return $this->forbidden();
        // }
        $dia = $request->get('dia');
        $semana = intval($request->get('semana'));
        $clase = intval($request->get('clase'));
        $detalles = $request->get('detalles');
        $this->rutinaService->cargarDetallesRutinaAlumno($alumnoId, $semana, $dia, $clase, $detalles);
        return $this->okNoContent();
    }

}