<?php

namespace Business\Actividades\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Actividades\Services\ActividadesService;

class ActividadController extends Controller {

    private $actividadesService;

    public function __construct(ActividadesService $as) {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
        $this->actividadesService = $as;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->tiene_permiso('VER_ACTIVIDADES')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->actividadesService->getAll($resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        $selectedData = $this->applySelect($parsedData);
        return $this->ok($selectedData);
    }

    /**
     * 
     */
    public function show($idActividad)
    {
        if (!$this->tiene_permiso('VER_ACTIVIDAD')) {
            return $this->forbidden();
        }
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
        if (!$this->tiene_permiso('VER_LISTADO_ACTIVIDADES')) {
            return $this->forbidden();
        }
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
        if (!$this->tiene_permiso('CREAR_ACTIVIDAD')) {
            return $this->forbidden();
        }
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
        if (!$this->tiene_permiso('MODIFICAR_ACTIVIDAD')) {
            return $this->forbidden();
        }
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
        if (!$this->tiene_permiso('ELIMINAR_ACTIVIDAD')) {
            return $this->forbidden();
        }
        $this->actividadesService->delete($idActividad);
        return $this->okNoContent();
    }

    /**
     * 
     */
    public function getActividadesHorasLimites(Request $request)
    {
        if (!$this->tiene_permiso('VER_ACTIVIDADES_HORAS_LIMITE')) {
            return $this->forbidden();
        }
        $actividades = $this->actividadesService->getActividadesHorasLimites();
        return $this->ok($actividades);
    }
}