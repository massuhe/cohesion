<?php

namespace Business\Inventario\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Inventario\Services\InventarioService;
use Business\Inventario\Requests\InventarioRequest;

class InventarioController extends Controller
{

    private $inventarioService;

    public function __construct(InventarioService $is)
    {
        $this->middleware('cors');
        // $this->middleware('auth:api');
        // $this->middleware('jwt.refresh');
       $this->inventarioService = $is;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (!$this->tiene_permiso('VER_ITEMS_INVENTARIO')) {
        //     return $this->forbidden();
        // }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->inventarioService->getAll($resourceOptions);
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
    public function store(InventarioRequest $request)
    {
        // if (!$this->tiene_permiso('CREAR_ITEM_INVENTARIO')) {
        //     return $this->forbidden();
        // }
        $inventario = $this->inventarioService->store($request->all());
        return $this->created($inventario);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $inventarioId
     * @return \Illuminate\Http\Response
     */
    public function show($inventarioId)
    {
        if (!$this->tiene_permiso('VER_ITEM_INVENTARIO')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->inventarioService->getById($inventarioId, $resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        return $this->ok($parsedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idInventario
     * @return \Illuminate\Http\Response
     */
    public function update(InventarioRequest $request, $idInventario)
    {
        if (!$this->tiene_permiso('MODIFICAR_ITEM_INVENTARIO')) {
            return $this->forbidden();
        }
        $inventario = $this->inventarioService->update($request->all(), $idInventario);
        return $this->ok($inventario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy($idInventario)
    {
        if (!$this->tiene_permiso('ELIMINAR_ITEM_INVENTARIO')) {
            return $this->forbidden();
        }
        $this->inventarioService->delete($idInventario);
        return $this->okNoContent(204);
    }
}