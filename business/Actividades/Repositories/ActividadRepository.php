<?php

namespace Business\Actividades\Repositories;

use Optimus\Genie\Repository;
use Business\Actividades\Models\Actividad;

class ActividadRepository extends Repository {

    public function getModel()
    {
        return new Actividad();
    }
}