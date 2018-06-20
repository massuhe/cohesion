<?php

namespace Business\Ejercicios\Services;

use Business\Ejercicios\Repositories\TipoEjercicioRepository;
use Business\Ejercicios\Models\TipoEjercicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TipoEjercicioService {

    private $tipoEjercicioRepository;

    public function __construct(
        TipoEjercicioRepository $ter
    )
    {
        $this->tipoEjercicioRepository = $ter;
    }

    public function getAll($options = [])
    {
        return $this->tipoEjercicioRepository->get($options);
    }

}