<?php
namespace Business\Usuarios\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Usuarios\Models\Usuario;
use Business\Usuarios\Services\UsuarioService;


class UsuarioController extends Controller
{

    private $usuarioService;

    public function __construct(UsuarioService $us)
    {
       //$this->middleware('jwt.auth');
       //$this->middleware('jwt.refresh');
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
        return $this->ok($this->usuarioService->getAll());
        //Usuario::all();
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
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        return $this->ok($usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        try {
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->badRequest();
        }
        $usuario->email = $request->get('email');
        $usuario->password = $request->get('password');
        //isset($request->get('apellido')) ? 
        $usuario->save();
        return $this->ok($usuario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
        $usuario->delete();
        return $this->okNoContent(204);
    }
}