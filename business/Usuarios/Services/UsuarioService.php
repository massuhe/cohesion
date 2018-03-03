<?php

namespace Business\Usuarios\Services;

use Business\Usuarios\Repositories\UsuarioRepository;
use Business\Clases\Repositories\ClaseEspecificaRepository;
use Business\Usuarios\Factories\UsuarioFactory;
use Business\Usuarios\Factories\AlumnoFactory;
use Business\Usuarios\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioService {

    private $usuarioRepository;
    private $claseEspecificaRepository;
    private $usuarioFactory;
    private $alumnoFactory;

    public function __construct(
        UsuarioRepository $ur, 
        UsuarioFactory $uf,
        ClaseEspecificaRepository $cer, 
        AlumnoFactory $af
    )
    {
        $this->usuarioRepository = $ur;
        $this->claseEspecificaRepository = $cer;
        $this->usuarioFactory = $uf;
        $this->alumnoFactory = $af;
    }

    public function getAll($options = [])
    {
        $ret = [];
        forEach($this->usuarioRepository->get($options) as $user) {
            $user->rol_id === 1 ?: $ret[] = $user;
        };
        return $ret;
    }

    public function getById($userId, $options = [])
    {
        $user = $this->usuarioRepository->getById($userId, $options);
        if(!$user || $user->rol_id === 1) {
            abort(404, 'No se ha encontrado el usuario.');
        }
        return $user;
    }

    public function store($data)
    {
        $usuario = $this->usuarioFactory->createUsuario($data);
        $alumno = $clases = null;
        if (isset($data['alumno'])) {
            $usuario->rol_id = 2;
            $alumno = $this->alumnoFactory->createAlumno($data['alumno']);
            $clases = $data['alumno']['clases'];
        }
        return DB::transaction(function () use ($usuario, $alumno, $clases) {
            return $this->usuarioRepository->store($usuario, $alumno, $clases);
        });
    }

    public function update($data, $idUsuario)
    {
        return DB::transaction(function () use ($data, $idUsuario) {
            $this->usuarioRepository->update($idUsuario, $data);
        });
    }

    public function delete($idUsuario)
    {
        $this->usuarioRepository->deleteWithClases($idUsuario);
    }

    public function getCantidadClasesAlumno($idAlumno)
    {
        return $this->usuarioRepository->getCantidadClasesAlumno($idAlumno);
    }
}