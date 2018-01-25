<?php

namespace Business\Clases\Repositories;

use Business\Clases\Models\Clase;
use Optimus\Genie\Repository;
use Business\Clases\Models\ClaseEspecifica;
use Business\Clases\Models\Suspension;

class ClaseRepository extends Repository {

    public function getModel()
    {
        return new Clase();
    }

    public function storeMany($clases)
    {
        return Clase::insert($clases);
    }

    public function deleteMany($clases)
    {
        $ids = $clases->map(function($v,$k){return $v->id;})->toArray();
        return Clase::destroy($ids);
    }

    public function suspenderByParametros($accion, $conditions, $motivo, $fechaDesde, $fechaHasta, $fechaUltimasClasesGeneradas)
    {
        $idClases = $this->getIdClases(Clase::select('id')->whereRaw($conditions)->get());
        ClaseEspecifica::whereIn('descripcion_clase',$idClases)
            ->where([['fecha', '>=', $fechaDesde->toDateString()], ['fecha', '<=', $fechaHasta->toDateString()]])
            ->update(['suspendida' => $accion, 'motivo' => $motivo]);
        return $idClases;
    }

    private function getIdClases($clases)
    {
        return $clases->map(function($c){
            return $c->id;
        })->toArray();
    }

    public function getSuspensionesByClases($idClases)
    {
        return Suspension::whereIn('clase_id', $idClases)->get();
    }

    public function addSuspensiones($idClases, $fechaHasta, $motivo)
    {
        $suspensiones = collect($idClases)->map(function($c) use ($fechaHasta, $motivo){
            return [
                'clase_id' => $c,
                'fecha_hasta' => $fechaHasta,
                'motivo' => $motivo
            ];
        })->toArray();
        Suspension::insert($suspensiones);
    }

    public function removeSuspensiones($idClases, $fechaHasta)
    {
        if(sizeof($idClases) === 0) {
            return;
        }
        Suspension::whereIn('clase_id', $idClases)->where('fecha_hasta', '<=', $fechaHasta)->delete();
    }

    public function updateSuspensiones($idSuspensiones, $fechaHasta, $motivo)
    {
        if(sizeof($idSuspensiones) === 0) {
            return;
        }
        Suspension::whereIn('id', $idSuspensiones)->update(['fecha_hasta' => $fechaHasta, 'motivo' => $motivo]);
    }

}