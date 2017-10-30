<?php

namespace Business\Clases\Factories;

use Business\Clases\Models\Clase;

class ClaseFactory {

    public function createClase($data)
    {
        $clase = new Clase();
        $clase->dia_semana = $data['dia_semana'];
        $clase->hora_inicio = $data['hora_inicio'];
        $clase->hora_fin = $data['hora_fin'];
        $clase->actividad = $data['actividad'];
        return $clase;
    }
}