<?php
namespace Business\Usuarios\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Usuarios\Models\Usuario;
use Optimus\Bruno\EloquentBuilderTrait;
// use Optimus\Bruno\LaravelController;
use Business\Usuarios\Services\UsuarioService;
use Business\Usuarios\Requests\UsuarioRequest;

class UsuarioController extends Controller
{
    use EloquentBuilderTrait;

    private $usuarioService;

    public function __construct(UsuarioService $us)
    {
        $this->middleware('cors');
        // $this->middleware('auth:api');
        // $this->middleware('jwt.refresh');
       $this->usuarioService = $us;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->tiene_permiso('VER_USUARIOS')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->usuarioService->getAll($resourceOptions);
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
    public function store(UsuarioRequest $request)
    {
        if (!$this->tiene_permiso('CREAR_USUARIO')) {
            return $this->forbidden();
        }
        $usuario = $this->usuarioService->store($request->all());
        return $this->created($usuario);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $usuarioId
     * @return \Illuminate\Http\Response
     */
    public function show($usuarioId)
    {
        // if (!$this->tiene_permiso('VER_USUARIO')) {
        //     return $this->forbidden();
        // }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->usuarioService->getById($usuarioId, $resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions);
        return $this->ok($parsedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idUsuario
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioRequest $request, $idUsuario)
    {
        if (!$this->tiene_permiso('MODIFICAR_USUARIO')) {
            return $this->forbidden();
        }
        $usuario = $this->usuarioService->update($request->all(), $idUsuario);
        return $this->ok($usuario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy($idUsuario)
    {
        if (!$this->tiene_permiso('ELIMINAR_USUARIO')) {
            return $this->forbidden();
        }
        $this->usuarioService->delete($idUsuario);
        return $this->okNoContent(204);
    }

}