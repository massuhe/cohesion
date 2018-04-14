<?php

namespace Business\Finanzas\Controllers;

use App\Http\Controllers\Controller;
use Business\Finanzas\Services\PagoService;

class PagoController extends Controller {
    
    private $pagoService;

    public function __construct(PagoService $ps)
    {
        $this->middleware('cors');
        // $this->middleware('auth:api');
        // $this->middleware('jwt.refresh');
        $this->pagoService = $ps;
    }

    public function getListado()
    {
        if (!$this->tiene_permiso('VER_LISTADO_PAGOS')) {
            return $this->forbidden();
        }
        $pagos = $this->pagoService->getAllPagos();
        return $pagos;
    }

}