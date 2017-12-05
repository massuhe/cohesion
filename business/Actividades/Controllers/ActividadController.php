<?php

namespace Business\Actividades\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Actividades\Services\ActividadesService;

class ActividadController extends Controller {

    private $actividadesService;

    public function __construct(ActividadesService $as) {
        //$this->middleware('jwt.auth');
        //$this->middleware('jwt.refresh');
        $this->middleware('cors');
        $this->actividadesService = $as;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->ok($this->actividadesService->get());
    }

    /**
     * 
     */
    public function show($idActividad)
    {
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->actividadesService->getById($idActividad, $resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        return $this->ok($data);
    }

    /**
     * 
     */
    public function getListado()
    {
        $actividad = $this->actividadesService->getListado();
        return $actividad;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $actividad = $this->actividadesService->store($request->all());
        return $this->created($actividad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idUsuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idActividad)
    {
        $actividad = $this->actividadesService->update($request->all(), $idActividad);
        return $this->ok($actividad);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy($idActividad)
    {
        $this->actividadesService->delete($idActividad);
        return $this->okNoContent();
    }

    /**
     * 
     */
    public function getActividadesHorasLimites(Request $request)
    {
        //
        $actividades = $this->actividadesService->getActividadesHorasLimites();
        return $this->ok($actividades);
    }
}