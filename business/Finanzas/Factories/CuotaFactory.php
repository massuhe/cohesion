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
        return $cuota;
    }

}