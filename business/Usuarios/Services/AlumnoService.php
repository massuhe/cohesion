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
        forEach($alumnos as $alumno) {
            $alumno->debe = $alumno->debe ? $this->alumnoHelper->formatDebe($alumno->debe) : null;
            $alumno->alumno = ['id' => $alumno->alumno_id];
        }
        return $alumnos;
    }

}