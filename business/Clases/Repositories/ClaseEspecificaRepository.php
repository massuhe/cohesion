<?php

namespace Business\Clases\Repositories;

use Business\Clases\Models\ClaseEspecifica;
use Illuminate\Support\Carbon;
use Optimus\Genie\Repository;
use Illuminate\Support\Facades\DB;

class ClaseEspecificaRepository extends Repository {

    public function getModel()
    {
        return new ClaseEspecifica();
    }

    public function getByWeekActivity($firstDayWeek, $lastDayWeek, $activity) 
    {
        $clases = ClaseEspecifica::with(['descripcionClase','alumnos', 'alumnos.usuario'])
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
}