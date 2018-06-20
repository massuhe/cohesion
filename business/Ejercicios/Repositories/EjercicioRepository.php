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

}
