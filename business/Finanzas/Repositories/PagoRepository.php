<?php

namespace Business\Finanzas\Repositories;

use Optimus\Genie\Repository;
use Business\Finanzas\Models\Pago;

class PagoRepository extends Repository
{

    public function getModel()
    {
        return new Pago();
    }

    public function getByMesCuota($mes, $anio)
    {
        return Pago::with('cuota.alumno.usuario:id,nombre,apellido')
                ->whereHas('cuota', function ($query) use ($mes, $anio) {
                    $query->where('mes', $mes)->where('anio', $anio);
                })->get();
    }

    public function getByAlumnoYFechas($idAlumno, $fechaDesde, $fechaHasta)
    {
        return Pago::with('cuota.alumno.usuario:id,nombre,apellido')
                ->when($fechaDesde, function ($query) use ($fechaDesde) {
                    return $query->where('created_at', '>=', $fechaDesde);
                })->when($fechaHasta, function ($query) use ($fechaHasta) {
                    return $query->where('created_at', '<', $fechaHasta);
                })->when($idAlumno, function ($query) use ($idAlumno) {
                    return $query->whereHas('cuota.alumno', function ($query) use ($idAlumno) {
                        $query->where('id', $idAlumno);
                    });
                })->get();
    }

}