<?php

namespace Business\Clases\Repositories;

use Business\Clases\Models\Clase;
use Optimus\Genie\Repository;
use Illuminate\Support\Facades\DB;
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

    public function suspenderByParametros($conditions, $motivo, $fechaHasta, $fechaUltimasClasesGeneradas)
    {
        $idClases = $this->getIdClases(Clase::select('id')->whereRaw($conditions)->get());
        DB::transaction(function () use ($idClases, $fechaHasta, $fechaUltimasClasesGeneradas, $motivo) {
            ClaseEspecifica::whereIn('id',$idClases)->update(['suspendida' => 1, 'motivo' => $motivo]);
            if($fechaHasta > $fechaUltimasClasesGeneradas){
                $this->addSuspensiones($idClases, $fechaHasta, $motivo);
            }
        });
    }

    private function getIdClases($clases)
    {
        return $clases->map(function($c){
            return $c->id;
        })->toArray();
    }

    private function addSuspensiones($idClases, $fechaHasta, $motivo)
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

}