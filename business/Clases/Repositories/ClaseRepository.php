<?php

namespace Business\Clases\Repositories;

use Business\Clases\Models\Clase;
use Optimus\Genie\Repository;
use Business\Clases\Models\ClaseEspecifica;
use Business\Clases\Models\Suspension;
use Illuminate\Support\Facades\DB;

class ClaseRepository extends Repository
{

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
        $ids = $clases->map(function ($v, $k) {
            return $v->id;
        })->toArray();
        return Clase::destroy($ids);
    }

    public function suspenderByParametros($accion, $conditions, $motivo, $fechaDesde, $fechaHasta, $fechaUltimasClasesGeneradas)
    {
        $idClases = $this->getIdClases(Clase::select('id')->whereRaw($conditions)->get());
        ClaseEspecifica::whereIn('descripcion_clase', $idClases)
            ->where([['fecha', '>=', $fechaDesde->toDateString()], ['fecha', '<=', $fechaHasta->toDateString()]])
            ->update(['suspendida' => $accion, 'motivo' => $motivo]);
        return $idClases;
    }

    public function getWithAsistencias($fechaHoraActual)
    {
        $queryMaximaAsistenciaSemanal = 
        "SELECT ce.descripcion_clase id, COUNT(*) asistencia_semana
         FROM clases c, clases_especificas ce
         LEFT JOIN asistencias asi ON asi.clase_especifica_id = ce.id
         WHERE c.id = ce.descripcion_clase
         AND asi.id IS NOT NULL
         AND CONCAT(ce.fecha, ' ', c.hora_inicio) >= '$fechaHoraActual'
         GROUP BY ce.id, ce.descripcion_clase, ce.fecha
         HAVING COUNT(*) = (
         	SELECT COUNT(*) asistencias_clases
             FROM clases c2, clases_especificas ce2, asistencias a2
             WHERE ce2.id = a2.clase_especifica_id
             AND c2.id = ce2.descripcion_clase
             AND CONCAT(ce2.fecha, ' ', c2.hora_inicio) >= '$fechaHoraActual'
             AND ce2.descripcion_clase = ce.descripcion_clase
             GROUP BY ce2.fecha
             ORDER BY asistencias_clases DESC
             LIMIT 1)";
        $queryAsistenciasFijas =        
        "SELECT c.id, COUNT(ac.clase_id) asistencia_fija
         FROM clases c
         LEFT JOIN alumnos_clases ac ON c.id = ac.clase_id
         GROUP BY c.id";
        $queryFinal = 
        "SELECT a.id actividad_id, a.cantidad_alumnos_por_clase, a.nombre actividad_nombre, cla.id, cla.dia_semana,
                cla.hora_inicio, cla2.asistencia_fija, IFNULL(cla1.asistencia_semana,0) asistencia_semana
         FROM clases cla
         LEFT JOIN ($queryMaximaAsistenciaSemanal) AS cla1 ON cla.id = cla1.id
         LEFT JOIN ($queryAsistenciasFijas) AS cla2 ON cla.id = cla2.id
         JOIN actividades a ON a.id = cla.actividad_id";
        $data = DB::select(DB::raw($queryFinal));
        return $data;
    }

    private function getIdClases($clases)
    {
        return $clases->map(function ($c) {
            return $c->id;
        })->toArray();
    }

    public function getSuspensionesByClases($idClases)
    {
        return Suspension::whereIn('clase_id', $idClases)->get();
    }

    public function addSuspensiones($idClases, $fechaHasta, $motivo)
    {
        $suspensiones = collect($idClases)->map(function ($c) use ($fechaHasta, $motivo) {
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
        if (sizeof($idClases) === 0) {
            return;
        }
        Suspension::whereIn('clase_id', $idClases)->where('fecha_hasta', '<=', $fechaHasta)->delete();
    }

    public function updateSuspensiones($idSuspensiones, $fechaHasta, $motivo)
    {
        if (sizeof($idSuspensiones) === 0) {
            return;
        }
        Suspension::whereIn('id', $idSuspensiones)->update(['fecha_hasta' => $fechaHasta, 'motivo' => $motivo]);
    }

}