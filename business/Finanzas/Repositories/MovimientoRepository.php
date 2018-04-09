<?php

namespace Business\Finanzas\Repositories;

use Illuminate\Support\Facades\DB;
use Optimus\Genie\Repository;
use Business\Finanzas\Models\Movimiento;

class MovimientoRepository extends Repository
{

    public function getModel()
    {
        return new Movimiento();
    }

    public function getLatestOlderThan($mes, $anio)
    {
        $movimientoMasReciente = Movimiento::select('mes', 'anio')
            ->whereRaw("CONCAT(anio, ' ', mes) <= '$anio $mes'")
            ->orderBy('anio', 'desc')
            ->orderBy('mes', 'desc')
            ->first();
        return $movimientoMasReciente ?
            $this->getWhereArray([
                ['mes', $movimientoMasReciente->mes],
                ['anio', $movimientoMasReciente->anio]
            ])
            : [];
    }

    public function storeMany($movimientos)
    {
        $insert = $movimientos->map(function($m) {
            return [
                'descripcion' => $m->descripcion,
                'importe' => $m->importe,
                'fecha_efectiva' => $m->fecha_efectiva,
                'tipo_movimiento' => $m->tipo_movimiento,
                'es_personal' => $m->es_personal,
                'mes' => $m->mes,
                'anio' => $m->anio
            ];
        })->toArray();
        Movimiento::insert($insert);
    }

    public function deleteByMesAnio($mes, $anio)
    {
        Movimiento::where([['mes', $mes], ['anio', $anio]])->delete();
    }

}