<?php
namespace Business\Usuarios\Controllers;

use Business\Usuarios\Models\Usuario;
use Illuminate\Http\Request;
use Business\Usuarios\Services\AlumnoService;
use Business\Usuarios\Requests\AlumnoRequest;
use App\Http\Controllers\Controller;

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
        $alumno = $this->alumnoService->save($request->all());
        return $this->ok($alumno);
    }

    /**
     * Display the specified resource.
     *
     * @param  Usuario  $usuario
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
    public function update(AlumnoRequest $request, $id)
    {
        //
        $alumno = $this->alumnoService->update($request->all(), $id);
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
