<?php

namespace Business\Ejercicios\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Business\Ejercicios\Services\TipoEjercicioService;

class TipoEjercicioController extends Controller
{
    private $tipoEjercicioService;

    public function __construct(TipoEjercicioService $tes)
    {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
        $this->tipoEjercicioService = $tes;
    }

    public function index()
    {
        // if (!$this->tiene_permiso('VER_EJERCICIOS')) {
        //     return $this->forbidden();
        // }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->tipoEjercicioService->getAll($resourceOptions);
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
        $tipoEjercicio = $this->tipoEjercicioService->store($request->all());
        return $this->created($tipoEjercicio);
    }
    
        // TODO: Crear FormRequest
    public function update(Request $request, $idTipoEjercicio)
    {
            // if (!$this->tiene_permiso('MODIFICAR_EJERCICIO')) {
            //     return $this->forbidden();
            // }
        $tipoEjercicio = $this->tipoEjercicioService->update($idTipoEjercicio, $request->all());
        return $this->ok($tipoEjercicio);
    }

    public function destroy($idTipoEjercicio)
    {
            // if (!$this->tiene_permiso('ELIMINAR_EJERCICIO')) {
            //     return $this->forbidden();
            // }
        $this->tipoEjercicioService->delete($idTipoEjercicio);
        return $this->okNoContent(204);
    }

}