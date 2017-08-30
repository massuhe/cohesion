<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Alumno;

class AlumnoService
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
    }

    public function getAlumno($idAlumno)
    {
        return Usuario::with('alumno')->findOrFail($idAlumno);
    }

    public function update($request, $idAlumno)
    {
        $usuario = Usuario::with('alumno')->find($idAlumno);
        $usuario->nombre = $request->get('nombre');
        $usuario->apellido = $request->get('apellido');
        $usuario->email = $request->get('email');
        $usuario->password = $request->get('password');
        $usuario->domicilio = $request->get('domicilio');
        $usuario->telefono = $request->get('telefono');
        $usuario->observaciones = $request->get('observaciones');
        $usuario->activo = true;
        $alumno = $usuario->alumno;
        $alumno->tiene_antec_deportivos = ($request->get('alumno'))['tieneAntecDeportivos'];
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