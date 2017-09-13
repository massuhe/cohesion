<?php
namespace Business\Usuarios\Factories;

use Business\Usuarios\Models\Alumno;

class AlumnoFactory {

    public function createAlumno($data)
    {
        $alumno = new Alumno();
        $alumno->tiene_antec_deportivos = $data['tieneAntecDeportivos'];
        return $alumno;
    }
}