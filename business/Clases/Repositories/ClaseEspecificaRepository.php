<?php

namespace Business\Clases\Repositories;

use Business\Clases\Models\ClaseEspecifica;
use Illuminate\Support\Carbon;

class ClaseEspecificaRepository {

    public function __construct() { }

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