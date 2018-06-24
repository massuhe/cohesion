<?php

namespace Business\Ejercicios\Services;

use Business\Ejercicios\Repositories\TipoEjercicioRepository;
use Business\Ejercicios\Models\TipoEjercicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Business\Ejercicios\Factories\TipoEjercicioFactory;
use Business\Ejercicios\Validators\TipoEjercicioValidator;

class TipoEjercicioService {

    private $tipoEjercicioRepository;
    private $tipoEjercicioFactory;
    private $tipoEjercicioValidator;

    public function __construct(
        TipoEjercicioRepository $ter,
        TipoEjercicioFactory $tef,
        TipoEjercicioValidator $tev
    )
    {
        $this->tipoEjercicioRepository = $ter;
        $this->tipoEjercicioFactory = $tef;
        $this->tipoEjercicioValidator = $tev;
    }

    public function getAll($options = [])
    {
        return $this->tipoEjercicioRepository->get($options);
    }

    public function store($data)
    {
        // Validar datos
        $tipoEjercicio = $this->tipoEjercicioFactory->createTipoEjercicio($data);
        return $this->tipoEjercicioRepository->store($tipoEjercicio);
    }

    public function update($idTipoEjercicio, $data)
    {
        return $this->tipoEjercicioRepository->update($idTipoEjercicio, $data);
    }

    public function delete($idTipoEjercicio)
    {
        $this->tipoEjercicioValidator->validateTipoEjercicioNoAsignadoAEjercicio($idTipoEjercicio);
        $this->tipoEjercicioRepository->delete($idTipoEjercicio);
    }

}