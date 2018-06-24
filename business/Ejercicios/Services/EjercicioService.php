<?php

namespace Business\Ejercicios\Services;

use Business\Ejercicios\Repositories\EjercicioRepository;
use Business\Ejercicios\Models\Ejercicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Business\Ejercicios\Factories\EjercicioFactory;

class EjercicioService {

    private $ejercicioRepository;
    private $ejercicioFactory;

    public function __construct(
        EjercicioRepository $er,
        EjercicioFactory $ef
    )
    {
        $this->ejercicioRepository = $er;
        $this->ejercicioFactory = $ef;
    }

    public function getAll($options = [])
    {
        return $this->ejercicioRepository->get($options);
    }

    public function store($data)
    {
        // Validar datos
        $ejercicio = $this->ejercicioFactory->createEjercicio($data);
        return $this->ejercicioRepository->store($ejercicio);
    }

    public function update($idEjercicio, $data)
    {
        return $this->ejercicioRepository->update($idEjercicio, $data);
    }

    public function delete($idEjercicio)
    {
        $this->ejercicioRepository->delete($idEjercicio);
    }

}