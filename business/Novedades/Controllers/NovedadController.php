<?php

namespace Business\Novedades\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Novedades\Services\NovedadService;
use Business\Novedades\Requests\NovedadRequest;

class NovedadController extends Controller
{

    private $novedadService;

    public function __construct(NovedadService $ns)
    {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
        $this->novedadService = $ns;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->tiene_permiso('VER_NOVEDADES')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->novedadService->getAll($resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        $selectedData = $this->applySelect($parsedData);
        return $this->ok($selectedData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NovedadRequest $request)
    {
        if (!$this->tiene_permiso('CREAR_NOVEDAD')) {
            return $this->forbidden();
        }
        $novedad = $this->novedadService->store($request->all());
        return $this->created($novedad);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $novedadId
     * @return \Illuminate\Http\Response
     */
    public function show($novedadId)
    {
        if (!$this->tiene_permiso('VER_NOVEDAD')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->novedadService->getById($novedadId, $resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        return $this->ok($parsedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idNovedad
     * @return \Illuminate\Http\Response
     */
    public function update(NovedadRequest $request, $idNovedad)
    {
        if (!$this->tiene_permiso('MODIFICAR_NOVEDAD')) {
            return $this->forbidden();
        }
        $novedad = $this->novedadService->update($request->all(), $idNovedad);
        return $this->ok($novedad);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Novedad  $novedad
     * @return \Illuminate\Http\Response
     */
    public function destroy($idNovedad)
    {
        if (!$this->tiene_permiso('ELIMINAR_NOVEDAD')) {
            return $this->forbidden();
        }
        $this->novedadService->delete($idNovedad);
        return $this->okNoContent(204);
    }
}