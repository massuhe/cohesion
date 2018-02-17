<?php
namespace Business\Usuarios\Factories;

use Business\Usuarios\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory {

    public function createUsuario($data)
    {
        $usuario = new Usuario();
        $usuario->nombre = $data['nombre'];
        $usuario->apellido = $data['apellido'];
        $usuario->email = $data['email'];
//        $usuario->password = $data['password'];
        $usuario->password = Hash::make('secret');
        $usuario->domicilio = $data['domicilio'];
        $usuario->telefono = $data['telefono'];
        !isset($data['rol']) ? : $usuario->rol_id =  $data['rol'];
        $usuario->activo = true;
        return $usuario;
    }
}