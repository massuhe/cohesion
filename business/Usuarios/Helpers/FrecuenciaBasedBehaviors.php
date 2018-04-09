<?php

namespace Business\Usuarios\Helpers;

use Carbon\Carbon;

class FrecuenciaBasedBehaviors {

    public function getNextDate($date, $frecuencia)
    {
        $dateReturn = $date->copy();
        switch ($frecuencia) {
            case 0:
                return $dateReturn->addDay();
            case 1:
                return $dateReturn->addDays(7);
            case 2:
                return $dateReturn->addMonth();
            case 3:
                return $dateReturn->addYear();
        }
    }

    public function evaluateCondition($alumno, $date, $frecuencia)
    {
        $fechaAlumno = new Carbon($alumno->created_at);
        switch ($frecuencia) {
            case 0:
                return $fechaAlumno->isSameDay($date);
            case 1:
                $faSOW = $fechaAlumno->copy()->startOfWeek();
                $is = $faSOW->isSameDay($date->copy()->startOfWeek());
                return $is;
            case 2:
                return $fechaAlumno->isSameMonth($date);
            case 3:
                return $fechaAlumno->isSameYear($date);
        }
    }

}