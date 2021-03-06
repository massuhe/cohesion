<?php
namespace Business\Clases\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Clases\Services\ClaseEspecificaService;
use Business\Clases\Models\PosibilidadRecuperar;
use Optimus\Bruno\EloquentBuilderTrait;

class ClaseEspecificaController extends Controller
{

    use EloquentBuilderTrait;

    private $claseEspecificaService;

    public function __construct(ClaseEspecificaService $ces)
    {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
        $this->claseEspecificaService = $ces;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isAlumno = $this->tiene_permiso('VER_CLASES_ESPECIFICAS_ALUMNO');
        if (!$this->tiene_permiso('VER_CLASES_ESPECIFICAS') && !$isAlumno) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->claseEspecificaService->getAll($resourceOptions, $isAlumno);
        $parsedData = $this->parseData($data, $resourceOptions);
        $selectedData = $this->applySelect($parsedData);
        return $this->ok($selectedData);
    }

    /**
     * 
     */
    public function getClasesEspecificas(Request $request)
    {
        $isAlumno = $this->tiene_permiso('VER_LISTADO_CLASES_ESPECIFICAS_ALUMNO');
        if (!$this->tiene_permiso('VER_LISTADO_CLASES_ESPECIFICAS') && !$isAlumno) {
            return $this->forbidden();
        }
        $semana = $request->get('semana');
        $idActividad = $request->get('actividad');
        return $this->ok($this->claseEspecificaService->getClasesByWeekActivity($semana, $idActividad, $isAlumno));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$this->tiene_permiso('VER_CLASE_ESPECIFICA')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->claseEspecificaService->getById($id, $resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        $selectedData = $this->applySelect(collect([$parsedData]));
        return $this->ok($selectedData[0]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idClaseEspecifica)
    {
        if (!$this->tiene_permiso('MODIFICAR_CLASE_ESPECIFICA')) {
            return $this->forbidden();
        }
        $claseEspecifica = $this->claseEspecificaService->update($request->all(), $idClaseEspecifica);
        return $this->ok($claseEspecifica);
    }

    /**
     * Cancela una clase asignada. 
     */
    public function cancelar(Request $request)
    {
        if (!$this->tiene_permiso('CANCELAR_CLASE')) {
            return $this->forbidden();
        }
        $this->claseEspecificaService->cancelar($request->get('idClase'));
        return $this->okNoContent();
    }

    /**
     * Recupera la clase.
     */
    public function recuperar(Request $request)
    {
        if (!$this->tiene_permiso('RECUPERAR_CLASE')) {
            return $this->forbidden();
        }
        $this->claseEspecificaService->recuperar($request->get('idClase'));
        return $this->okNoContent(); 
    }

}
