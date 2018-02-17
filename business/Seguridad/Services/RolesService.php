<?php

namespace Business\Seguridad\Services;

use Business\Seguridad\Repositories\RolesRepository;
use Business\Seguridad\Factories\RolFactory;

class RolesService {

    private $rolesRepository;
    private $rolFactory;

    public function __construct(
        RolesRepository $rr,
        RolFactory $rf
    )
    {
        $this->rolesRepository = $rr;
        $this->rolFactory = $rf;
    }

    public function getAll($option)
    {
        $roles = [];
        forEach($this->rolesRepository->get($option) as $rol) {
            if($rol->id !== 1 && $rol->id !== 2) {
                $roles[] = $rol;
            }
        }
        return $roles;
    }

    public function getById($rolId, $options)
    {
        $rol = $this->rolesRepository->getById($rolId, $options);
        if(!$rol || $rol->id === 1 || $rol->id === 2) {
            abort(404, 'No se ha encontrado el ROL.');
        }
        return $rol;
    }

    public function store($data)
    {
        $rol = $this->rolFactory->createRol($data);
        $permisos = $data['permisos'];
        return $this->rolesRepository->store($rol, $permisos);
    }

    public function update($idRol, $data)
    {
        $this->rolesRepository->update($idRol, $data);
    }

    public function delete($idRol)
    {
        $this->rolesRepository->delete($idRol);
    }

    public function getPermisos()
    {
        return $this->rolesRepository->getPermisos();
    }
}