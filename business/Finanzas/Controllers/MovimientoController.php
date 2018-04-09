<?php

namespace Business\Finanzas\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Finanzas\Services\MovimientoService;

class MovimientoController extends Controller
{
    private $movimientosService;

    public function __construct(MovimientoService $ms)
    {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
        $this->movimientosService = $ms;
    }

    public function index(Request $request)
    {
        if (!$this->tiene_permiso('VER_MOVIMIENTOS')) {
            return $this->forbidden();
        }
    }

    public function storeOrUpdateMany(Request $request, $mes, $anio)
    {
        if (!$this->tiene_permiso('CREAR_MOVIMIENTO')) {
            return $this->forbidden();
        }
        return $this->movimientosService->storeOrUpdate($mes, $anio, $request->get('movimientos'));
    }

    public function findOrReturnLatest($mes, $anio)
    {
        if (!$this->tiene_permiso('VER_MOVIMIENTOS')) {
            return $this->forbidden();
        }
        $data = $this->movimientosService->findOrReturnLatest($mes, $anio);
        return $data;
    }

}