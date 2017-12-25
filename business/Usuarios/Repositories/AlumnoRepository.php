<?php
namespace Business\Usuarios\Repositories;

use Illuminate\Support\Facades\DB;
use Business\Usuarios\Models\Alumno;
use Carbon\Carbon;
use Optimus\Genie\Repository;
use Business\Clases\Models\PosibilidadRecuperar;

class AlumnoRepository extends Repository
{
    public function getModel()
    {
        return new Alumno();
    }

    public function addPosibilidadRecuperar($idAlumno, $validoHasta = null)
    {
        if(!$validoHasta) {
            $validoHasta = Carbon::now()->addWeeks(2);
        }
        $alumno = $this->getById($idAlumno);
        $alumno->posibilidadesRecuperar()->save(new PosibilidadRecuperar(['valido_hasta' => $validoHasta]));
        return true;
    }
}