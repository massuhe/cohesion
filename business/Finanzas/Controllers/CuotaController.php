<?php

namespace Business\Finanzas\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CuotaController extends Controller
{
    private $cuotasService;

    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
        // $this->cuotasService = $cs;
    }

    public function getOrCreateCuota(Request $request)
    {
        $forbidden = !$this->tiene_permiso('VER_CUOTA') || !$this->tiene_permiso('CREAR_CUOTA');
        if ($forbidden) {
            return $this->forbidden();
        }
        return $this->cuotasService->getOrCreateCuota($request->getAll());
    } 
}