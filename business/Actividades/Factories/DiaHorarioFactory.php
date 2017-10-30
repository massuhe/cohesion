<?php

namespace Business\Actividades\Factories;

use Business\Actividades\Models\DiaHorario;

class DiaHorarioFactory {

    public function createDiaHorario($data) {
        $diaHorario = new DiaHorario();
        $diaHorario['dia_semana'] = $data['diaSemana'];

        return $diaHorario;
    }
}