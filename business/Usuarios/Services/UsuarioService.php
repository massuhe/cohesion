<?php

namespace Business\Usuarios\Services;

use Business\Usuarios\Repositories\UsuarioRepository;
use Business\Clases\Repositories\ClaseEspecificaRepository;
use Business\Usuarios\Factories\UsuarioFactory;
use Business\Usuarios\Factories\AlumnoFactory;
use Business\Usuarios\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Business\Shared\Helpers\ImageHelper;
use Business\Shared\Services\ImageService;
use Illuminate\Support\Facades\Hash;

class UsuarioService {

    private $usuarioRepository;
    private $claseEspecificaRepository;
    private $usuarioFactory;
    private $alumnoFactory;
    private $imageService;

    public function __construct(
        UsuarioRepository $ur, 
        UsuarioFactory $uf,
        ClaseEspecificaRepository $cer, 
        AlumnoFactory $af,
        ImageService $is
    )
    {
        $this->usuarioRepository = $ur;
        $this->claseEspecificaRepository = $cer;
        $this->usuarioFactory = $uf;
        $this->alumnoFactory = $af;
        $this->imageService = $is;
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
        $realId = $userId ? $userId : Auth::guard()->user()->id;
        $user = $this->usuarioRepository->getById($realId, $options);
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
        return DB::transaction(function () use ($usuario, $alumno, $clases, $data) {
            $this->usuarioRepository->store($usuario, $alumno, $clases);
            $this->storeAlumnoAvatar($usuario, $alumno, $data);
            return $usuario;
        });
    }

    public function update($data, $idUsuario)
    {
        $realId = $idUsuario ? $idUsuario : Auth::guard()->user()->id;
        $realData = $idUsuario ? $data : $this->extractData($data);
        return DB::transaction(function () use ($realData, $realId) {
            try {
                if (isset($realData['alumno']['imagen'])) {
                    $realData['alumno']['imagenPerfil'] = $this->imageService->updateImage($realId, 'avatares', $realData['alumno']['imagen']);
                }
            }
            catch (\Exception $e) {
                $this->imageService->removeImage($realData['alumno']['imagenPerfil'], 'avatares');
            }
            $this->usuarioRepository->update($realId, $realData);
        });
    }

    public function changePassword($idUsuario, $password)
    {
        $realId = $idUsuario ? $idUsuario : Auth::guard()->user()->id;
        $hashedPassword = Hash::make($password);
        return $this->usuarioRepository->changePassword($realId, $hashedPassword);
    }

    public function delete($idUsuario)
    {
        $this->usuarioRepository->deleteWithClases($idUsuario);
    }

    public function getCantidadClasesAlumno($idAlumno)
    {
        return $this->usuarioRepository->getCantidadClasesAlumno($idAlumno);
    }

    /**
     * Funcion que se ejecuta cuando el alumno hace update de datos, se extrae sólos los que este puede editar.
     */
    private function extractData($originalData) {
        $dataExtract = [
            'domicilio' => $originalData['domicilio'],
            'telefono' => $originalData['telefono'],
        ];
        if (isset($originalData['imagen'])) {
            $dataExtract['alumno'] = ['imagen' => $originalData['imagen']];
        }
        return $dataExtract;
    }

    private function storeAlumnoAvatar($usuario, $alumno, $data)
    {
        if (!($alumno && isset($data['alumno']['imagen']))) {
            return ;
        }
        try {
            $imagePath = $this->imageService->updateImage($usuario->id, 'avatares', $data['alumno']['imagen']);
            $alumno->imagen_perfil = $imagePath;
            $alumno->save();
        }
        catch (\Exception $e) {
            $this->imageService->removeImage($imagePath, 'avatares');
        }
    }
}