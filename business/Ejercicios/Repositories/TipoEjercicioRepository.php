<?php

namespace Business\Ejercicios\Repositories;

use Optimus\Genie\Repository;
use Illuminate\Support\Facades\DB;
use Business\Ejercicios\Models\TipoEjercicio;

class TipoEjercicioRepository extends Repository {

    public function getModel()
    {
        return new TipoEjercicio();
    }

    public function store($tipoEjercicio)
    {
        $tipoEjercicio->save();
        return $tipoEjercicio;
    }

    public function update($idTipoEjercicio, $data)
    {
        $tipoEjercicio = $this->getById($idTipoEjercicio);
        $tipoEjercicio->nombre = $data['nombre'];
        $tipoEjercicio->save();
        return $tipoEjercicio;
    }

}
