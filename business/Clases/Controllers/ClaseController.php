<?php
namespace Business\Clases\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Clases\Models\Clase;
use Optimus\Bruno\EloquentBuilderTrait;


class ClaseController extends Controller
{
    use EloquentBuilderTrait;

    private $claseEspecificaService;

    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->tiene_permiso('VER_CLASES')) {
            return $this->forbidden();
        }
        return $this->ok(Clase::get());
    }

    // /**
    //  * 
    //  */
    // public function getClasesEspecificas(Request $request)
    // {
    //     //
    //     $isAlumno = true;
    //     $semana = $request->get('semana');
    //     $idActividad = $request->get('actividad');
    //     return $this->ok($this->claseEspecificaService->getClasesByWeekActivity($semana, $idActividad, $isAlumno));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->tiene_permiso('CREAR_CLASE')) {
            return $this->forbidden();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $usuarioId
     * @return \Illuminate\Http\Response
     */
    public function show($claseId)
    {
        if (!$this->tiene_permiso('VER_CLASE')) {
            return $this->forbidden();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idUsuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idClase)
    {
        if (!$this->tiene_permiso('MODIFICAR_CLASE')) {
            return $this->forbidden();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy($idClase)
    {
        if (!$this->tiene_permiso('ELIMINAR_CLASE')) {
            return $this->forbidden();
        }
    }
}