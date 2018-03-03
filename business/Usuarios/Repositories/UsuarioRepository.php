<?php

namespace Business\Usuarios\Repositories;

use Illuminate\Support\Facades\DB;
use Business\Usuarios\Models\Usuario;
use Optimus\Genie\Repository;
use Illuminate\Database\Eloquent\Builder;
use Business\Clases\Models\ClaseEspecifica;
use Carbon\Carbon;
use Business\Clases\Models\Clase;
use Business\Usuarios\Models\Alumno;

class UsuarioRepository extends Repository
{
    public function getModel()
    {
        return new Usuario();
    }

    public function store($usuario, $alumno = null, $clases = null)
    {
        $usuario->save();
        if ($alumno !== null) {
            $usuario->alumno()->save($alumno);
            $alumno->clases()->attach($clases);
            $this->generateClasesEspecificasAlumno($alumno, $clases);
            $usuario->alumno = $alumno;
        }
        return $usuario;
    }

    public function deleteWithClases($idUsuario)
    {
        DB::transaction(function () use ($idUsuario) {
            $usuario = Usuario::find($idUsuario);
            if($usuario->rol_id === 1) {
                throw new \Exception();
            }
            if($usuario->alumno) {
                $usuario->alumno->clases()->detach();
                $usuario->alumno->clasesEspecificas()->detach();
            }
            $usuario->delete();
        });
    }

    public function update($idUsuario, $data)
    {
        if ($alumno = isset($data['alumno'])) {
            $usuario = $this->findAlumno($idUsuario, $data);
        } else {
            $usuario = Usuario::find($idUsuario);
        }
        $this->updateUsuario($usuario, $data);
        $usuario->save();
        if ($alumno) {
            $usuario->alumno()->save($usuario->alumno);
            $this->updateClases($usuario->alumno, $data['alumno']['clases']);
        }
        return $usuario;
    }

    public function filterIsAlumno(Builder $query, $method, $clauseOperator, $value, $in)
    {
        // check if value is true
        $boolval = $value === 'true';
        $alumnos = DB::table('alumnos')->select('usuario_id')->get()->map(function ($e) {
            return $e->usuario_id;
        });

        $boolval ? $query->whereIn('usuarios.id', $alumnos->toArray())
                 : $query->whereNotIn('usuarios.id', $alumnos->toArray());
    }

    public function filterNombreApellido(Builder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $rawWhere = "CONCAT(usuarios.nombre, ' ', usuarios.apellido)" . ' LIKE ' . "'%". $value ."%'";
            $query->whereRaw($rawWhere);
        }
    }

    private function generateClasesEspecificasAlumno($alumno, $clases)
    {
        $now = Carbon::now('America/Argentina/Buenos_Aires')->toDateTimeString();
        $clasesEspecificas = ClaseEspecifica::select('clases_especificas.id')
            ->join('clases', 'clases_especificas.descripcion_clase', '=', 'clases.id')
            ->whereIn('descripcion_clase', $clases)
            ->whereRaw("CONCAT(clases_especificas.fecha, ' ', clases.hora_inicio) >= '$now'")->get();
        $insert = [];
        forEach($clasesEspecificas as $ce) {
            $insert[$ce->id] = [
                'asistio' => true, 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ];
        }
        $alumno->clasesEspecificas()->attach($insert);
    }

    private function updateUsuario($usuario, $data)
    {
        $usuario->apellido = $data['apellido'];
        $usuario->nombre = $data['nombre'];
        $usuario->email = $data['email'];
        // $usuario->password = $data['password']; TODO: Hacer
        $usuario->domicilio = $data['domicilio'];
        $usuario->telefono = $data['telefono'];
        !isset($data['rol']) ?: $usuario->rol_id = $data['rol'];
        $usuario->activo = true;
        return $usuario;
    }

    private function findAlumno($idUsuario, $data)
    {
        $usuario = Usuario::with('alumno.clases')->find($idUsuario);
        $alumno = $usuario->alumno;
        $alumno->tiene_antec_deportivos = $data['alumno']['tieneAntecDeportivos'];
        $alumno->observaciones_antec_deportivos = $data['alumno']['observacionesAntecDeportivos'];
        $alumno->tiene_antec_medicos = $data['alumno']['tieneAntecMedicos'];
        $alumno->observaciones_antec_medicos = $data['alumno']['observacionesAntecMedicos'];
        return $usuario;
    }

    private function updateClases($alumno, $idClasesNuevas)
    {
        $idClasesViejas = $alumno->clases->map(function($c){ return $c->id;});
        $idClasesAsociar = collect($idClasesNuevas)->filter(function($c) use ($idClasesViejas){
           return !in_array($c, $idClasesViejas->toArray()); 
        });
        $idClasesBorrar = $idClasesViejas->filter(function($c) use ($idClasesNuevas){
            return !in_array($c, $idClasesNuevas); 
         });
         $alumno->clases()->sync($idClasesNuevas);
         $this->updateClasesEspecificas($alumno, $idClasesAsociar, $idClasesBorrar);
    }

    private function updateClasesEspecificas($alumno, $idClasesAsociar, $idClasesBorrar)
    {
        $now = Carbon::now('America/Argentina/Buenos_Aires')->toDateTimeString();
        $ceBorrar = $alumno->clasesEspecificas()->whereIn('descripcion_clase', $idClasesBorrar->toArray())->where('fecha', '>=', $now)->get();
        $ceAgregar = ClaseEspecifica::whereIn('descripcion_clase', $idClasesAsociar->toArray())->where('fecha', '>=', $now)->get();
        $attach = [];
        forEach($ceAgregar as $ce) {
            $attach[$ce->id] = ['asistio' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        }
        $detach = $ceBorrar->map(function($c){ return $c->id;})->toArray();
        $alumno->clasesEspecificas()->attach($attach);
        $alumno->clasesEspecificas()->detach($detach);
    }

    public function getCantidadClasesAlumno($idAlumno)
    {
        $count = Alumno::find($idAlumno)->clases()->count();
        return $count;
    }

}