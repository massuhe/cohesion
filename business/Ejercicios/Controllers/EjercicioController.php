<?php

namespace Business\Ejercicios\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Business\Ejercicios\Services\EjercicioService;

class EjercicioController extends Controller
{
    private $ejercicioService;

    public function __construct(EjercicioService $es)
    {
        $this->middleware('cors');
        // $this->middleware('auth:api');
        // $this->middleware('jwt.refresh');
        $this->ejercicioService = $es;
    }

    public function index()
    {
        // if (!$this->tiene_permiso('VER_EJERCICIOS')) {
        //     return $this->forbidden();
        // }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->ejercicioService->getAll($resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        $selectedData = $this->applySelect($parsedData);
        return $this->ok($selectedData);
    }

    // TODO: Crear FormRequest
    public function store(Request $request)
    {
        // if (!$this->tiene_permiso('CREAR_EJERCICIO')) {
        //     return $this->forbidden();
        // }
        $ejercicio = $this->ejercicioService->store($request->all());
        return $this->created($ejercicio);
    }

    // TODO: Crear FormRequest
    public function update(Request $request, $idEjercicio)
    {
        // if (!$this->tiene_permiso('MODIFICAR_EJERCICIO')) {
        //     return $this->forbidden();
        // }
        $ejercicio = $this->ejercicioService->update($idEjercicio, $request->all());
        return $this->ok($ejercicio);
    }

    public function destroy($idEjercicio)
    {
        // if (!$this->tiene_permiso('ELIMINAR_EJERCICIO')) {
        //     return $this->forbidden();
        // }
        $this->ejercicioService->delete($idEjercicio);
        return $this->okNoContent(204);
    }

}