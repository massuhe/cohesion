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
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
        $this->ejercicioService = $es;
    }

    public function index()
    {
        if (!$this->tiene_permiso('VER_EJERCICIOS')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->ejercicioService->getAll($resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        $selectedData = $this->applySelect($parsedData);
        return $this->ok($selectedData);
    }

}