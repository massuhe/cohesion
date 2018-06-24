<?php

namespace Business\Ejercicios\Repositories;

use Optimus\Genie\Repository;
use Illuminate\Support\Facades\DB;
use Business\Ejercicios\Models\Ejercicio;

class EjercicioRepository extends Repository {

    public function getModel()
    {
        return new Ejercicio();
    }

    public function store($ejercicio)
    {
        $ejercicio->save();
        return $ejercicio;
    }

    public function update($idEjercicio, $data)
    {
        $ejercicio = $this->getById($idEjercicio);
        $ejercicio->nombre = $data['nombre'];
        $ejercicio->descripcion = $data['descripcion'];
        $ejercicio->tipo_ejercicio_id = $data['tipoEjercicio'];
        $ejercicio->save();
        return $ejercicio;
    }

}
