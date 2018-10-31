<?php
namespace Business\Usuarios\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Optimus\Genie\Repository;
use Business\Clases\Models\PosibilidadRecuperar;
use Business\Usuarios\Models\Alumno;
use Business\Usuarios\Exceptions\SinPosibilidadRecuperarException;
use Illuminate\Support\Facades\Config;

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

    public function listado()
    {
        $now = Carbon::now();
        $monthFixed = strlen($now->month) === 2 ? $now->month : "0$month";
        $deudores_query = 
        "SELECT deudas.alumno_id, GROUP_CONCAT(deudas.mes, '-', deudas.anio, ': ', deudas.importe_total - deudas.importe_pagado SEPARATOR '; ') as debe
         FROM (
             SELECT A.id as alumno_id, C.anio, C.mes, C.importe_total, SUM(P.importe) as importe_pagado
             FROM ALUMNOS A, CUOTAS C, PAGOS P
             WHERE A.id = C.alumno_id
             AND CONCAT(C.anio, ' ', LPAD(C.mes, 2, '0')) <= '$now->year $monthFixed'
             AND C.id = P.cuota_id
             GROUP BY A.id, C.anio, C.mes, C.importe_total
             HAVING C.importe_total - SUM(P.importe) > 0
         ) as deudas
         GROUP BY deudas.alumno_id";
        $query_final = 
        "SELECT U.id, U.email, A0.id as alumno_id, U.nombre, U.apellido, U.activo, deudores.debe
         FROM usuarios U
         JOIN alumnos A0 on U.id = A0.usuario_id
         LEFT JOIN ($deudores_query) as deudores on A0.id = deudores.alumno_id
         WHERE u.deleted_at IS NULL";
        $data = DB::select(DB::raw($query_final));
        return $data;
    }

}