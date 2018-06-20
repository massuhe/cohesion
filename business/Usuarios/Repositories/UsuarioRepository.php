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
            if (isset($data['alumno']['clases'])) {
                $this->updateClases($usuario->alumno, $data['alumno']['clases']);
            }
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

    public function filterIdAlumno(Builder $query, $method, $clauseOperator, $value, $in)
    {
        $id = intval($value);
        $alumno = DB::table('alumnos')->find($id);
        if ($alumno) {
            $query->find($alumno->usuario_id);
        }
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
        $now = Carbon::now()->toDateTimeString();
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
        $this->setIfDefined($usuario, 'apellido', $data, 'apellido');
        $this->setIfDefined($usuario, 'nombre', $data, 'nombre');
        $this->setIfDefined($usuario, 'email', $data, 'email');
        $this->setIfDefined($usuario, 'domicilio', $data, 'domicilio');
        $this->setIfDefined($usuario, 'telefono', $data, 'telefono');
        $this->setIfDefined($usuario, 'rol_id', $data, 'rol');
        $usuario->activo = true;
        return $usuario;
    }

    private function findAlumno($idUsuario, $data)
    {
        $usuario = Usuario::with('alumno.clases')->find($idUsuario);
        $alumno = $usuario->alumno;
        $this->setIfDefined($alumno, 'tiene_antec_deportivos', $data['alumno'], 'tieneAntecDeportivos');
        $this->setIfDefined($alumno, 'observaciones_antec_deportivos', $data['alumno'], 'observacionesAntecDeportivos');
        $this->setIfDefined($alumno, 'tiene_antec_medicos', $data['alumno'], 'tieneAntecMedicos');
        $this->setIfDefined($alumno, 'observaciones_antec_medicos', $data['alumno'], 'observacionesAntecMedicos');
        $this->setIfDefined($alumno, 'imagen_perfil', $data['alumno'], 'imagenPerfil');
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
        $now = Carbon::now()->toDateTimeString();
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
        $alumno = Alumno::find($idAlumno);
        if (!$alumno) {
            return 0;
        }
        return $alumno->clases()->count();
    }

    public function changePassword($idUsuario, $password)
    {
        $usuario = $this->getById($idUsuario);
        $usuario->password = $password;
        $usuario->save();
    }

    private function setIfDefined($entity, $entityProp, $data, $dataProp) {
        if (!isset($data[$dataProp])) {
            return ;
        }
        $entity->$entityProp = $data[$dataProp];
    }

}