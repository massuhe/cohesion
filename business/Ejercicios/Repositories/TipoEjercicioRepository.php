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

}
