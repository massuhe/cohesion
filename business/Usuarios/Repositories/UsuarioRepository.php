<?php

namespace Business\Usuarios\Repositories;

use Illuminate\Support\Facades\DB;
use Business\Usuarios\Models\Usuario;
use Optimus\Genie\Repository;
use Illuminate\Database\Eloquent\Builder;


class UsuarioRepository extends Repository
{
    public function getModel()
    {
        return new Usuario();
    }

    public function store($usuario, $alumno = null)
    {
        DB::transaction(function () use ($usuario, $alumno) {
            $usuario->save();
            if ($alumno !== null) {
                $usuario->alumno()->save($alumno);
                $usuario->alumno = $alumno;
            }
        });
        return $usuario;
    }

    public function update($idUsuario, $data)
    {
        if ($alumno = isset($data['alumno'])) {
            $usuario = Usuario::with('alumno')->find($idUsuario);
            $alumno = $usuario->alumno;
            $alumno->tiene_antec_deportivos = $data['alumno']['tieneAntecDeportivos'];
        } else {
            $usuario = Usuario::find($idUsuario);
        }
        $this->updateUsuario($usuario, $data);
        DB::transaction(function () use ($usuario, $alumno) {
            $usuario->save();
            if ($alumno) {
                $usuario->alumno()->save($alumno);
            }

        });
        return $usuario;
    }

    private function updateUsuario($usuario, $data)
    {
        $usuario->apellido = $data['apellido'];
        $usuario->nombre = $data['nombre'];
        $usuario->email = $data['email'];
        $usuario->password = $data['password'];
        $usuario->domicilio = $data['domicilio'];
        $usuario->telefono = $data['telefono'];
        $usuario->observaciones = $data['observaciones'];
        $usuario->activo = true;
        return $usuario;
    }

    public function filterIsAlumno(Builder $query, $method, $clauseOperator, $value, $in)
    {
        // check if value is true
        if ($value) {
            $alumnos = DB::table('alumnos')->select('usuario_id')->get()->map(function ($e) {
                return $e->usuario_id;
            });
            $query->whereIn('usuarios.id', $alumnos->toArray());
        }
    }

    public function filterNombreApellido(Builder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $rawWhere = "CONCAT(usuarios.nombre, ' ', usuarios.apellido)" . ' LIKE ' . "'%". $value ."%'";
            $query->whereRaw($rawWhere);
        }
    }
}