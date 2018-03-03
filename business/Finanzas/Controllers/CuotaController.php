<?php

namespace Business\Finanzas\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Finanzas\Services\CuotaService;

class CuotaController extends Controller
{
    private $cuotasService;

    public function __construct(CuotaService $cs)
    {
        $this->middleware('cors');
        // $this->middleware('auth:api');
        // $this->middleware('jwt.refresh');
        $this->cuotasService = $cs;
    }

    public function index(Request $request)
    {
        if (!$this->tiene_permiso('VER_CUOTAS')) {
            return $this->forbidden();
        }
    }

    /**
     * Devuelve la cuota de un alumno para un mes y un año, si no existe retorna una nueva cuota que no está almacenada en la
     * base de datos con el importe fijado según la cantidad de clases a la que asiste el alumno.
     */
    public function findWithFallback($alumno, $mes, $anio)
    {
        if (!$this->tiene_permiso('VER_CUOTA')) {
            return $this->forbidden();
        }
        $data = $this->cuotasService->findWithFallback($alumno, $mes, $anio);
        return $this->ok($data);
    }

    /**
     * Registra un pago a una cuota dada. Si la cuota no existe, se crea una nueva para el alumno en un mes y año dado.
     */
    public function store(Request $request)
    {
        if (!$this->tiene_permiso('CREAR_CUOTA') || !$this->tiene_permiso('MODIFICAR_CUOTA')) {
            return $this->forbidden();
        }
        $data = $this->cuotasService->createOrUpdateIfExists($request->all());
        return $this->ok($data);
    }

}