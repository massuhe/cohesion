<?php

namespace Business\Seguridad\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Seguridad\Models\Rol;
use Business\Usuarios\Models\Usuario;
use Business\Seguridad\Services\RolesService;

// TODO: Borrar
use Business\Finanzas\Helpers\DeudoresNotifier;

class RolesController extends Controller {

    private $rolesService;

    public function __construct(RolesService $rs) {
        $this->middleware('cors');
        // $this->middleware('auth:api');
        // $this->middleware('jwt.refresh');
        $this->rolesService = $rs;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->tiene_permiso('VER_ROLES')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->rolesService->getAll($resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        return $this->ok($parsedData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->tiene_permiso('CREAR_ROL')) {
            return $this->forbidden();
        }
        $usuario = $this->rolesService->store($request->all());
        return $this->created($usuario);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $idRol
     * @return \Illuminate\Http\Response
     */
    public function show($idRol)
    {
        if (!$this->tiene_permiso('VER_ROL')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->rolesService->getById($idRol, $resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        return $this->ok($parsedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idRol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idRol)
    {
        if (!$this->tiene_permiso('MODIFICAR_ROL')) {
            return $this->forbidden();
        }
        $rol = $this->rolesService->update($idRol, $request->all());
        return $this->ok($rol);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $idRol
     * @return \Illuminate\Http\Response
     */
    public function destroy($idRol)
    {
        if (!$this->tiene_permiso('ELIMINAR_ROL')) {
            return $this->forbidden();
        }
        $this->rolesService->delete($idRol);
        return $this->okNoContent(204);
    }

    public function getPermisos()
    {
        if (!$this->tiene_permiso('VER_PERMISOS')) {
            return $this->forbidden();
        }
        $permisos = $this->rolesService->getPermisos();
        return $this->ok($permisos);
    }

    public function mail(DeudoresNotifier $a)
    {
        $a->notifyDeudores();
    }

}