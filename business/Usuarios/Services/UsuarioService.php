<?php

namespace Business\Usuarios\Services;

use Business\Usuarios\Factories\UsuarioFactory;
use Business\Usuarios\Models\Usuario;

class UsuarioService {

    private $usuarioFactory;

    public function __construct(UsuarioFactory $uf)
    {
        $this->usuarioFactory = $uf;
    }

    public function getAll()
    {
        return Usuario::all();
    }

    public function store($data)
    {
        $usuario = $this->usuarioFactory->createUsuario($data);
        $usuario->save();
        return $usuario;
    }
}