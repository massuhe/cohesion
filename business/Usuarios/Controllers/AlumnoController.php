<?php

namespace Business\Usuarios\Controllers;

use Business\Usuarios\Models\Usuario;
use Illuminate\Http\Request;
use Business\Usuarios\Services\AlumnoService;
use Business\Usuarios\Requests\AlumnoRequest;
use App\Http\Controllers\Controller;

class AlumnoController extends Controller
{

    private $alumnoService;

    public function __construct(AlumnoService $as)
    {
        $this->middleware('cors');
        // $this->middleware('auth:api');
        // $this->middleware('jwt.refresh');
        $this->alumnoService = $as;
    }

    public function listado()
    {
        // if (!$this->tiene_permiso('LISTADO_ALUMNOS')) {
        //     return $this->forbidden();
        // }
        return $this->alumnoService->listado();
    }
}
