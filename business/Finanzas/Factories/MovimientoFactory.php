<?php

namespace Business\Finanzas\Factories;

use Business\Finanzas\Models\Movimiento;
use Carbon\Carbon;

class MovimientoFactory {

    public function createMovimiento($data)
    {
        $movimiento = new Movimiento();
        $movimiento->descripcion = $data['descripcion'];
        $movimiento->importe = $data['importe'];
        $movimiento->fecha_efectiva = $data['fechaEfectiva'] ? new Carbon($data['fechaEfectiva']) : null;
        $movimiento->es_personal = $data['esPersonal'];
        $movimiento->tipo_movimiento = $data['tipoMovimiento'];
        $movimiento->mes = $data['mes'];
        $movimiento->anio = $data['anio'];
        return $movimiento;
    }

}