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

    public function getAllPagos()
    {
        return Pago::select('pagos.id', 'pagos.importe','pagos.created_at as fechaPago', 'cuotas.mes', 'cuotas.anio', 'cuotas.importe_total as totalCuota',
                'usuarios.apellido', 'usuarios.nombre')
            ->join('cuotas', 'pagos.cuota_id', '=', 'cuotas.id')
            ->join('alumnos', 'cuotas.alumno_id', '=', 'alumnos.id')
            ->join('usuarios', 'alumnos.usuario_id', '=', 'usuarios.id')
            ->get();
    }

}