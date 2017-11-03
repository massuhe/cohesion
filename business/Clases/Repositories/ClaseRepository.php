<?php

namespace Business\Clases\Repositories;

use Business\Clases\Models\Clase;
use Optimus\Genie\Repository;

class ClaseRepository extends Repository {

    public function getModel()
    {
        return new Clase();
    }

    public function storeMany($clases)
    {
        return Clase::insert($clases);
    }

    public function deleteMany($clases)
    {
        $ids = $clases->map(function($v,$k){return $v->id;})->toArray();
        return Clase::destroy($ids);
    }

}