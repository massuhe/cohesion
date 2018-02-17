<?php

namespace Business\Seguridad\Repositories;

use Optimus\Genie\Repository;
use Business\Seguridad\Models\Rol;
use Business\Seguridad\Models\Permiso;
use Illuminate\Support\Facades\DB;

class RolesRepository extends Repository {

    public function getModel()
    {
        return new Rol();
    }

    public function getPermisos()
    {
        return Permiso::all();
    }

    public function store($rol, $permisos = false)
    {
        return DB::transaction(function() use ($rol, $permisos){
            $rol->save();
            if ($permisos) {
                $rol->permisos()->sync($permisos);
            }
            return $permisos;
        });
    }

    public function update($idRol, $data)
    {
        return DB::transaction(function() use ($idRol, $data){
            $rol = $this->getById($idRol);
            $rol->nombre = $data['nombre'];
            $rol->save();
            $rol->permisos()->sync($data['permisos']);
            return $rol;
        });
    }

}