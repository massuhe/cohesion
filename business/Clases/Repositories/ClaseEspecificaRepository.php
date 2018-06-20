<?php

namespace Business\Clases\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Optimus\Genie\Repository;
use Illuminate\Database\Eloquent\Builder;
use Business\Clases\Models\ClaseEspecifica;
use Business\Clases\Models\PosibilidadRecuperar;
use Business\Clases\Models\Asistencia;
use Optimus\Bruno\EloquentBuilderTrait;
use Business\Rutinas\Models\ParametroItemSerie;

class ClaseEspecificaRepository extends Repository {

    use EloquentBuilderTrait;

    public function getModel()
    {
        return new ClaseEspecifica();
    }

    public function getByWeekActivity($firstDayWeek, $lastDayWeek, $activity) 
    {
        $clases = ClaseEspecifica::with(['descripcionClase','alumnos', 'alumnos.usuario'])
            ->select(['clases_especificas.*', 'clases.hora_inicio'])
            ->join('clases', 'clases_especificas.descripcion_clase', '=', 'clases.id')
            ->where([
                ['fecha', '>=', $firstDayWeek],
                ['fecha', '<=', $lastDayWeek],
                ['clases.actividad_id', '=', $activity->id]
            ])->get();
            return $clases;
    }

    public function update($data, $id)
    {
        $claseEspecifica = $this->getById($id);
        $claseEspecifica->suspendida = $data['suspendida'];
        $claseEspecifica->motivo = $claseEspecifica->suspendida ? $data['motivo'] : null;
        $alumnos = [];
        $alumnosNuevos = $data['asistencias'];
        forEach($alumnosNuevos as $alumno){
            $alumnos[$alumno['id']] = ['asistio' => $alumno['asistio']];
        }
        return DB::transaction(function () use ($claseEspecifica, $alumnos) {
            $claseEspecifica->alumnos()->sync($alumnos);
            $claseEspecifica->save();
            return $claseEspecifica->load('alumnos');
        });
    }

    public function getPuedeRecuperar($alumnoId)
    {
        return PosibilidadRecuperar::where([
            ['alumno_id', '=', $alumnoId],
            ['valido_hasta', '>=', date("Y-m-d")]
        ])->count();
    }

    public function removeAsistencia($idAlumno, $idClase) {
        $clase = $this->getById($idClase);
        $clase->alumnos()->detach($idAlumno);
        $clase->touch();
    }

    public function addAsistencia($idAlumno, $idClase) {
        $clase = $this->getById($idClase);
        $now = Carbon::now();
        $clase->alumnos()->attach([$idAlumno => [
            'asistio' => true, 
            'created_at' => $now,
            'updated_at' => $now]]
        );
        $clase->touch();
    }

    public function deleteByActividad($idActividad)
    {
        ClaseEspecifica::whereHas('descripcionClase', function($query) use ($idActividad) {
            $query->where('actividad_id', $idActividad);
        })->delete();
    }

    public function filterIdAlumno(Builder $query, $method, $clauseOperator, $value, $in)
    {
        $idsClasesAlumno = Asistencia::select('clase_especifica_id')
            ->where('alumno_id', $value)
            ->get()
            ->map(function($c) {
                return $c->clase_especifica_id;
            })
            ->toArray();
        $query->whereIn('id', $idsClasesAlumno);
    }

    public function filterAssignedToRutina(Builder $query, $method, $clauseOperator, $value, $in)
    {

        $fechaHoraLimite = Carbon::now('America/Argentina/Buenos_Aires')->toDateTimeString();
        $idClasesPosibles = ClaseEspecifica::select('clases_especificas.id')
            ->join('asistencias', 'clases_especificas.id', '=', 'asistencias.clase_especifica_id')
            ->leftJoin('clases', 'clases_especificas.descripcion_clase', '=', 'clases.id')
            ->where('asistencias.asistio', true)
            ->where('clases.actividad_id', 1)
            ->whereRaw("CONCAT(clases_especificas.fecha, ' ', clases.hora_fin) <= '$fechaHoraLimite'")
            ->whereNotIn('clases_especificas.id', function($query) {
                $query->select('parametros_item_serie.clase_especifica_id')->from('parametros_item_serie');
            })
            ->get();
        $query->whereIn('id', $idClasesPosibles);
    }

}