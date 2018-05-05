<?php

namespace Business\Rutinas\Factories;

use Business\Rutinas\Models\ParametroItemSerie;
use Carbon\Carbon;

class ParametroItemSerieFactory {

    public function create($data)
    {
        $parametroItemSerie = new ParametroItemSerie();
        $parametroItemSerie->clase_especifica_id = $data['clase'];
        $parametroItemSerie->carga = $data['carga'];
        return $parametroItemSerie;
    }

}