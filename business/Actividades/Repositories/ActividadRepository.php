<?php
namespace Business\Actividades\Repositories;

use Illuminate\Support\Facades\DB;
use Optimus\Genie\Repository;
use Business\Actividades\Models\Actividad;
use Illuminate\Database\Eloquent\Collection;
use Business\Clases\Repositories\ClaseRepository;

class ActividadRepository extends Repository
{

    public function getModel()
    {
        return new Actividad();
    }

    public function store($actividad)
    {
        $diasHorarios = $actividad->dias_horarios;
        $actividad->offsetUnset('dias_horarios');
        $actividad->save();
        $this->storeDiasHorarios($actividad, $diasHorarios);
        $actividad->dias_horarios = $diasHorarios;
        return $actividad;
    }

    private function storeDiasHorarios($actividad, $diasHorarios)
    {
        forEach ($diasHorarios as $diaHorario) {
            // $this->storeRangosHorarios($diaHorario->horarios);
            $horarios = $diaHorario->horarios;
            $diaHorario->offsetUnset('horarios');
            $actividad->diasHorarios()->save($diaHorario);
            // $diaHorario->save();
            $diaHorario->horarios()->saveMany($horarios);
            $diaHorario->horarios = $horarios;
        }
    }

    // private function storeRangosHorarios($rangosHorarios)
    // {
    //     forEach($rangosHorarios as $rangoHorario) {
    //         $rangoHorario->save();
    //     }
    // }

}