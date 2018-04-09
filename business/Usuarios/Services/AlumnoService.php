<?php

namespace Business\Usuarios\Services;

use Business\Usuarios\Models\Usuario;
use Business\Usuarios\Models\Alumno;
use Business\Usuarios\Factories\AlumnoFactory;
use Business\Usuarios\Factories\UsuarioFactory;
use Business\Usuarios\Repositories\AlumnoRepository;
use Carbon\Carbon;
use Business\Usuarios\Helpers\AlumnoHelper;

class AlumnoService
{
    private $alumnoRepository;
    private $alumnoHelper;

    public function __construct(AlumnoRepository $ar, AlumnoHelper $ah)
    {
        $this->alumnoRepository = $ar;
        $this->alumnoHelper = $ah;
    }

    public function listado()
    {
        $alumnos = $this->alumnoRepository->listado();
        forEach ($alumnos as $alumno) {
            $alumno->debe = $alumno->debe ? $this->alumnoHelper->formatDebe($alumno->debe) : null;
            $alumno->alumno = ['id' => $alumno->alumno_id];
        }
        return $alumnos;
    }

    public function getReporteIngresos($fechaDesde, $fechaHasta, $frecuencia)
    {
        $data = [];
        $fechaDesde = new Carbon($fechaDesde);
        $fechaHasta = new Carbon($fechaHasta);
        $alumnos = $this->alumnoRepository->getWhereArray([
            ['created_at', '>=', $fechaDesde],
            ['created_at', '<=', $fechaHasta]
        ]);
        for ($i = $fechaDesde->copy() ; $i->lt($fechaHasta) ; $i = $this->alumnoHelper->getNextDate($i, $frecuencia)) {
            $alumnosFecha = $alumnos->filter(function($a) use ($i, $frecuencia) {
                return $this->alumnoHelper->evaluateCondition($a, $i, $frecuencia);
            });
            $data[] = ['fecha' => $i->toDateString(), 'cantidad' => sizeOf($alumnosFecha)];
        }
        return $data;
    }

}