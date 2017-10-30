<?php

namespace Business\Actividades\Factories;

use Business\Actividades\Models\RangoHorario;

class RangoHorarioFactory {

    public function createRangoHorario($data) {
        $rangoHorario = new RangoHorario();
        $rangoHorario['hora_desde'] = $data['horaDesde'];
        $rangoHorario['hora_hasta'] = $data['horaHasta'];

        return $rangoHorario;
    }
}