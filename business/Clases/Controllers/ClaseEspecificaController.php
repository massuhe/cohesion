<?php

namespace Business\Clases\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Clases\Services\ClaseEspecificaService;

class ClaseEspecificaController extends Controller
{

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
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->claseEspecificaService->getAll($resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        $selectedData = $this->applySelect($parsedData);
        return $this->ok($selectedData);
    }

    /**
     * 
     */
    public function getClasesEspecificas(Request $request)
    {
        //
        $isAlumno = false;
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
        //
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->claseEspecificaService->getById($id, $resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        $selectedData = $this->applySelect($parsedData);
        return $this->ok($selectedData);
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
        //
        $claseEspecifica = $this->claseEspecificaService->update($request->all(), $idClaseEspecifica);
        return $this->ok($claseEspecifica);
    }

}
