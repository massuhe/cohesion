<?php

namespace Business\Usuarios\Services;

use Business\Usuarios\Repositories\UsuarioRepository;
use Business\Usuarios\Factories\UsuarioFactory;
use Business\Usuarios\Factories\AlumnoFactory;
use Business\Usuarios\Models\Usuario;

class UsuarioService {

    private $usuarioRepository;
    private $usuarioFactory;
    private $alumnoFactory;

    public function __construct(UsuarioRepository $ur, UsuarioFactory $uf, AlumnoFactory $af)
    {
        $this->usuarioRepository = $ur;
        $this->usuarioFactory = $uf;
        $this->alumnoFactory = $af;
    }

    public function getAll($options = [])
    {
        return $this->usuarioRepository->get($options);
    }

    public function getById($options = [])
    {
        return $this->usuarioRepository->getById($options);
    }

    public function store($data)
    {
        $usuario = $this->usuarioFactory->createUsuario($data);
        $alumno = isset($data['alumno']) ? $this->alumnoFactory->createAlumno($data['alumno']) : null;
        return $this->usuarioRepository->store($usuario, $alumno);
    }

    public function update($data, $idUsuario)
    {
        return $this->usuarioRepository->update($idUsuario, $data);
    }

    public function delete($idUsuario)
    {
        $this->usuarioRepository->delete($idUsuario);
    }
}