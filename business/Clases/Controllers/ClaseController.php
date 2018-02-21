<?php
namespace Business\Clases\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Clases\Models\Clase;
use Optimus\Bruno\EloquentBuilderTrait;
use Business\Clases\Services\ClaseService;
use Business\Clases\Requests\SuspenderClasesRequest;

class ClaseController extends Controller
{
    use EloquentBuilderTrait;

    private $claseService;
    

    public function __construct(ClaseService $cs)
    {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
        $this->claseService = $cs;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->tiene_permiso('VER_CLASES')) {
            return $this->forbidden();
        }
        $resourceOptions = $this->parseResourceOptions();
        $data = $this->claseService->getAll($resourceOptions);
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
        if (!$this->tiene_permiso('CREAR_CLASE')) {
            return $this->forbidden();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $usuarioId
     * @return \Illuminate\Http\Response
     */
    public function show($claseId)
    {
        if (!$this->tiene_permiso('VER_CLASE')) {
            return $this->forbidden();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idUsuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idClase)
    {
        if (!$this->tiene_permiso('MODIFICAR_CLASE')) {
            return $this->forbidden();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy($idClase)
    {
        if (!$this->tiene_permiso('ELIMINAR_CLASE')) {
            return $this->forbidden();
        }
    }

    /**
     * Suspende las clases que cumplan con el set de parámetros pasados
     */
    public function suspender(SuspenderClasesRequest $request)
    {
        if (!$this->tiene_permiso('SUSPENDER_CLASES')) {
            return $this->forbidden();
        }
        $setParametros = $request->all();
        $this->claseService->suspenderClasesRango($setParametros);
        return $this->okNoContent();
    }

    /**
     * Se obtienen las clases agrupadas con las asistencias fijas y semanales, agrupadas por actividad
     */
    public function getConAsistencias()
    {
        if (!$this->tiene_permiso('VER_CLASES')) {
            return $this->forbidden();
        }
        return $this->ok($this->claseService->getWithAsistencias());
    }

}