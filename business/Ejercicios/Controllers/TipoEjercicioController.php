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
        if (!$this->tiene_permiso('VER_EJERCICIOS')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->tipoEjercicioService->getAll($resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        $selectedData = $this->applySelect($parsedData);
        return $this->ok($selectedData);
    }

}