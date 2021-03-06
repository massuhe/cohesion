<?php

namespace Business\Actividades\Factories;

use Business\Actividades\Models\Actividad;

class ActividadFactory {

    public function createActividad($data) {
        $actividad = new Actividad();
        $actividad->nombre = $data['nombre'];
        $actividad->descripcion = isset($data['descripcion']) ? $data['descripcion'] : null;
        $actividad->duracion = $data['duracion'];
        $actividad->cantidad_alumnos_por_clase = $data['cantidadAlumnosPorClase'];

        return $actividad;
    }

}