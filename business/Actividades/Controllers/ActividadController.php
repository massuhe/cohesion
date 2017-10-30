<?php

namespace Business\Actividades\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Actividades\Services\ActividadesService;

class ActividadController extends Controller {

    private $actividadesService;

    public function __construct(ActividadesService $as) {
        //$this->middleware('jwt.auth');
        //$this->middleware('jwt.refresh');
        $this->middleware('cors');
        $this->actividadesService = $as;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->ok($this->actividadesService->get());
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
        $actividad = $this->actividadesService->store($request->all());
        return $this->created($actividad);
    }

    /**
     * 
     */
    public function getActividadesHorasLimites(Request $request)
    {
        //
        $actividades = $this->actividadesService->getActividadesHorasLimites();
        return $this->ok($actividades);
    }
}