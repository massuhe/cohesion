<?php

namespace Business\Clases\Repositories;

use Business\Clases\Models\Clase;
// use Optimus\Genie\Repository;

class ClaseRepository {



    public function storeMany($clases)
    {
        $a = Clase::insert($clases);
        return $a;
    }

}