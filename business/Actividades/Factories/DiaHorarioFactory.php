<?php

namespace Business\Actividades\Factories;

use Business\Actividades\Models\DiaHorario;
use Business\Shared\Utils\StrUtils;

class DiaHorarioFactory {

    public function createDiaHorario($data) {
        $diaHorario = new DiaHorario();
        $diaHorario['dia_semana'] = StrUtils::removeTildes($data['diaSemana']);

        return $diaHorario;
    }
}