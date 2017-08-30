<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Alumno;
use App\Services\AlumnoService;
use App\Http\Requests\AlumnoRequest;

class AlumnoController extends Controller
{

    private $alumnoService;

    public function __construct(AlumnoService $as)
    {
        $this->alumnoService = $as;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $alumnos = $this->alumnoService->getAll();
        return $this->ok($alumnos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlumnoRequest $request)
    {
        //
        $usuario = Usuario::newFromRequest($request);
        $alumno = Alumno::newFromRequest($request->get('alumno'));
        $this->alumnoService->save($usuario, $alumno);
        $usuario->alumno = $alumno;
        return $this->ok($usuario);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $alumno = $this->alumnoService->getAlumno($id);
        return $this->ok($alumno);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $alumno = $this->alumnoService->update($request, $id);
        return $this->ok($alumno);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->alumnoService->delete($id);
        return $this->okNoContent();
    }
}
