<?php
namespace Business\Usuarios\Factories;

use Business\Usuarios\Models\Usuario;

class UsuarioFactory {

    public function createUsuario($data)
    {
        $usuario = new Usuario();
        $usuario->nombre = $data['nombre'];
        $usuario->apellido = $data['apellido'];
        $usuario->email = $data['email'];
//        $usuario->password = $data['password'];
        $usuario->password = 'contraseña';
        $usuario->domicilio = $data['domicilio'];
        $usuario->telefono = $data['telefono'];
        $usuario->observaciones = $data['observaciones'];
        $usuario->activo = true;
        return $usuario;
    }
}