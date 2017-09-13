<?php

namespace Business\Usuarios\Services;

use Business\Usuarios\Models\Usuario;
use Business\Usuarios\Models\Alumno;
use Business\Usuarios\Factories\AlumnoFactory;
use Business\Usuarios\Factories\UsuarioFactory;
use Business\Usuarios\Repositories\AlumnoRepository;


class AlumnoService
{
    private $alumnoFactory;
    private $usuarioFactory;
    private $alumnoRepository;

    public function __construct(AlumnoFactory $af, UsuarioFactory $uf, AlumnoRepository $ar)
    {
        $this->alumnoFactory = $af;
        $this->usuarioFactory = $uf;
        $this->alumnoRepository = $ar;
    }

    public function getAll()
    {
        return $this->alumnoRepository->getAll();
    }

    public function save($input)
    {
        $usuario = $this->usuarioFactory->createUsuario($input);
        $alumno = $this->alumnoFactory->createAlumno($input['alumno']);
        return $this->alumnoRepository->save($usuario, $alumno);
    }

    public function getAlumno($idAlumno)
    {
        return $this->alumnoRepository->getAlumno($idAlumno);
    }

    public function update($data, $idAlumno)
    {
        return $this->alumnoRepository->update($data, $idAlumno);
    }

    public function delete($idAlumno)
    {
        $this->alumnoRepository->delete($idAlumno);
    }
}