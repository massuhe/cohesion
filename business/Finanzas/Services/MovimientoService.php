<?php

namespace Business\Finanzas\Services;

use Business\Finanzas\Repositories\MovimientoRepository;
use Business\Finanzas\Factories\MovimientoFactory;
use Illuminate\Support\Facades\DB;

class MovimientoService {

    private $movimientoRepository;
    private $movimientoFactory;

    public function __construct(MovimientoRepository $mr, MovimientoFactory $mf)
    {
        $this->movimientoRepository = $mr;
        $this->movimientoFactory = $mf;
    }

    /**
     * Busca los movimientos del mes y el año pasados por parámetros, si no existe ninguno, retorna
     * los movimientos del mes más reciente que tenga movimientos.
     */
    public function findOrReturnLatest($mes, $anio)
    {
        $movimientos = $this->getMovimientosByMesAnio($mes, $anio);
        return sizeOf($movimientos) === 0 ?
            $this->movimientoRepository->getLatestOlderThan($mes, $anio)
            : $movimientos;
    }

    public function storeOrUpdate($mes, $anio, $newMovimientos)
    {
        $movimientosAdd = collect($newMovimientos)->map(function ($m) use ($mes, $anio) {
            return $this->movimientoFactory->createMovimiento(array_merge($m, ['anio' => $anio, 'mes' => $mes]));
        });
        DB::transaction(function() use ($movimientosAdd, $mes, $anio) {
            $this->movimientoRepository->deleteByMesAnio($mes, $anio);
            $this->movimientoRepository->storeMany($movimientosAdd);
        });
        return $this->getMovimientosByMesAnio($mes, $anio);
    }

    private function getMovimientosByMesAnio($mes, $anio)
    {
        return $this->movimientoRepository->getWhereArray([
            ['mes', $mes],
            ['anio', $anio]
        ]);
    }

}