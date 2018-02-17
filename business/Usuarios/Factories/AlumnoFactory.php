<?php
namespace Business\Usuarios\Factories;

use Business\Usuarios\Models\Alumno;

class AlumnoFactory {

    public function createAlumno($data)
    {
        $alumno = new Alumno();
        $alumno->tiene_antec_deportivos = $data['tieneAntecDeportivos'];
        $alumno->observaciones_antec_deportivos = $data['observacionesAntecDeportivos'];
        $alumno->tiene_antec_medicos = $data['tieneAntecMedicos'];
        $alumno->observaciones_antec_medicos = $data['observacionesAntecMedicos'];
        return $alumno;
    }
}