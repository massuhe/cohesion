<?php
namespace Business\Usuarios\Repositories;

use Illuminate\Support\Facades\DB;
use Business\Usuarios\Models\Usuario;

class AlumnoRepository
{
    public function getAll()
    {
        return Usuario::with('alumno')->get();
    }

    public function save($usuario, $alumno)
    {
        DB::transaction(function () use ($usuario, $alumno) {
            $usuario->save();
            $usuario->alumno()->save($alumno);
        });
        $usuario->alumno = $alumno;
        return $usuario;
    }

    public function getAlumno($idAlumno)
    {
        return Usuario::with('alumno')->findOrFail($idAlumno);
    }

    public function update($data, $idAlumno)
    {
        $usuario = Usuario::with('alumno')->find($idAlumno);
        $usuario->apellido = $data['apellido'];
        $usuario->nombre = $data['nombre'];
        $usuario->email = $data['email'];
        $usuario->password = $data['password'];
        $usuario->domicilio = $data['domicilio'];
        $usuario->telefono = $data['telefono'];
        $usuario->observaciones = $data['observaciones'];
        $usuario->activo = true;
        $alumno = $usuario->alumno;
        $alumno->tiene_antec_deportivos = $data['alumno']['tieneAntecDeportivos'];
        DB::transaction(function () use ($usuario, $alumno) {
            $usuario->save();
            $usuario->alumno()->save($alumno);
        });
        return $usuario;
    }

    public function delete($idAlumno)
    {
        $alumno = Usuario::findOrFail($idAlumno);
        $alumno->delete();
    }
}