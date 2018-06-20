<?php

namespace Business\Ejercicios\Services;

use Business\Ejercicios\Repositories\EjercicioRepository;
use Business\Ejercicios\Models\Ejercicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class EjercicioService {

    private $ejercicioRepository;

    public function __construct(
        EjercicioRepository $er
    )
    {
        $this->ejercicioRepository = $er;
    }

    public function getAll($options = [])
    {
        return $this->ejercicioRepository->get($options);
    }

}