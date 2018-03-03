<?php

namespace Business\Finanzas\Factories;

use Business\Finanzas\Models\Cuota;

class CuotaFactory {

    public function createCuota($data)
    {
        $cuota = new Cuota();
        $cuota->alumno_id = $data['alumno'];
        $cuota->mes = $data['mes'];
        $cuota->anio = $data['anio'];
        $cuota->importe_total = isset($data['importeTotal']) ? $data['importeTotal'] : null;
        $cuota->observaciones = isset($data['observaciones']) ? $data['observaciones'] : null;
        return $cuota;
    }

}