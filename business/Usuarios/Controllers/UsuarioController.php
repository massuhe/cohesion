<?php
namespace Business\Usuarios\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Usuarios\Models\Usuario;
use Optimus\Bruno\EloquentBuilderTrait;
// use Optimus\Bruno\LaravelController;
use Business\Usuarios\Services\UsuarioService;

class UsuarioController extends Controller
{
    use EloquentBuilderTrait;

    private $usuarioService;

    public function __construct(UsuarioService $us)
    {
       //$this->middleware('jwt.auth');
       //$this->middleware('jwt.refresh');
       $this->middleware('cors');
       $this->usuarioService = $us;
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
    public function store(Request $request)
    {
        //
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
        //
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->usuarioService->getById($usuarioId, $resourceOptions);
        $parsedData = $this->parseData($data, $resourceOptions, 'usuarios');
        return $this->ok($parsedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idUsuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idUsuario)
    {
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
        //
        $this->usuarioService->delete($idUsuario);
        return $this->okNoContent(204);
    }
}