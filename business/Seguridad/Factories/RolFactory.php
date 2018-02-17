<?php

namespace Business\Seguridad\Factories;

use Business\Seguridad\Models\Rol;

class RolFactory {

    public function createRol($data)
    {
        $rol = new Rol();
        $rol->nombre = $data['nombre'];
        return $rol;
    }

}