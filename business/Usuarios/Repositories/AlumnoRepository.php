<?php
namespace Business\Usuarios\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Optimus\Genie\Repository;
use Business\Clases\Models\PosibilidadRecuperar;
use Business\Usuarios\Models\Alumno;
use Business\Usuarios\Exceptions\SinPosibilidadRecuperarException;

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

    public function removePosibilidadRecuperar($idAlumno)
    {
        $posibilidadRecuperar = Alumno::find($idAlumno)->posibilidadesRecuperar()
            ->whereRaw("valido_hasta = (SELECT MIN(valido_hasta) FROM posibilidades_recuperar WHERE alumno_id = $idAlumno)")
            ->first();
        if(!$posibilidadRecuperar) {
            throw new SinPosibilidadRecuperarException();
        }
        $posibilidadRecuperar->delete();
    }
}