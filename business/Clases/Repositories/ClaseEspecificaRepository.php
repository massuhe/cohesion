<?php

namespace Business\Clases\Repositories;

use Business\Clases\Models\ClaseEspecifica;
use Illuminate\Support\Carbon;
use Optimus\Genie\Repository;

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
}