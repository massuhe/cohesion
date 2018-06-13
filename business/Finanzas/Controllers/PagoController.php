<?php

namespace Business\Finanzas\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Finanzas\Services\PagoService;

class PagoController extends Controller {
    
    private $pagoService;

    public function __construct(PagoService $ps)
    {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
        $this->pagoService = $ps;
    }

    public function getByMesCuota($mes, $anio)
    {
        if (!$this->tiene_permiso('VER_LISTADO_PAGOS')) {
            return $this->forbidden();
        }
        return $this->pagoService->getByMesCuota($mes, $anio);
    }

    public function getByAlumnoYFechas(Request $request)
    {
        if (!$this->tiene_permiso('VER_LISTADO_PAGOS')) {
            return $this->forbidden();
        }
        $idAlumno = $request->get('idAlumno');
        $fechaDesde = $request->get('fechaDesde') ? Carbon::parse($request->get('fechaDesde'))->startOfDay() : null;
        $fechaHasta = $request->get('fechaHasta') ? Carbon::parse($request->get('fechaHasta'))->addDay()->startOfDay() : null;
        return $this->pagoService->getByAlumnoYFechas($idAlumno, $fechaDesde, $fechaHasta);
    }

}