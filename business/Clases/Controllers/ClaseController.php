<?php
namespace Business\Clases\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Clases\Models\Clase;
use Optimus\Bruno\EloquentBuilderTrait;
use Business\Clases\Services\ClaseEspecificaService;


class ClaseController extends Controller
{
    use EloquentBuilderTrait;

    private $claseEspecificaService;

    public function __construct(ClaseEspecificaService $ces)
    {
       //$this->middleware('jwt.auth');
       //$this->middleware('jwt.refresh');
       $this->middleware('cors');
       $this->claseEspecificaService = $ces;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Clase::get();
    }

    /**
     * 
     */
    public function getClasesEspecificas(Request $request)
    {
        //
        $isAlumno = true;
        $semana = $request->get('semana');
        $idActividad = $request->get('actividad');
        return $this->claseEspecificaService->getClasesByWeekActivity($semana, $idActividad, $isAlumno);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $usuarioId
     * @return \Illuminate\Http\Response
     */
    public function show($claseId)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy($idClase)
    {
        
    }
}