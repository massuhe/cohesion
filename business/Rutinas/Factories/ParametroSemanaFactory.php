<?php

namespace Business\Rutinas\Factories;

use Business\Rutinas\Models\ParametroSemana;

class ParametroSemanaFactory {

    public function create($data)
    {
        $parametroSemana = new ParametroSemana();
        $parametroSemana->semana = $data['semana'];
        $parametroSemana->repeticiones = $data['repeticiones'];
        return $parametroSemana;
    }

}