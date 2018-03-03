<?php

namespace Business\Finanzas\Repositories;

use Illuminate\Support\Facades\DB;
use Optimus\Genie\Repository;
use Business\Finanzas\Models\Cuota;

class CuotaRepository extends Repository
{

    public function getModel()
    {
        return new Cuota();
    }

    public function getByParams($alumno, $mes, $anio)
    {
        return Cuota::where([
            ['alumno_id', $alumno], 
            ['mes', $mes],
            ['anio', $anio]
        ])->first();
    }

    public function store($cuota)
    {
        $cuota->save();
        return $cuota;
    }

    public function registrarPago($cuota, $pago)
    {
        $cuota->pagos()->save($pago);
        return $pago;
    }

    public function update($cuota, $data)
    {
        $cuota->importe_total = isset($data['importeTotal']) ? $data['importeTotal'] : $cuota->importe_total;
        $cuota->observaciones = isset($data['observaciones']) ? $data['observaciones'] : $cuota->observaciones;
        $cuota->save();
        return $cuota;
    }
}