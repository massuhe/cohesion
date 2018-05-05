<?php
namespace Business\Actividades\Repositories;

use Illuminate\Support\Facades\DB;
use Optimus\Genie\Repository;
use Business\Actividades\Models\Actividad;
use Illuminate\Database\Eloquent\Collection;
use Business\Clases\Repositories\ClaseRepository;

class ActividadRepository extends Repository
{

    public function getModel()
    {
        return new Actividad();
    }
    
    public function getListado()
    {
        return Actividad::select('actividades.id', 'actividades.nombre', 'actividades.duracion', 
            'actividades.cantidad_alumnos_por_clase', DB::raw('count(distinct alumnos_clases.alumno_id) as total_alumnos'))
                ->leftJoin('clases', 'actividades.id', '=', 'clases.actividad_id')
                ->leftJoin('alumnos_clases', 'clases.id', '=', 'alumnos_clases.clase_id')
                ->whereNull('clases.deleted_at')
                ->groupBy('actividades.id', 'actividades.nombre', 'actividades.duracion', 
                    'actividades.cantidad_alumnos_por_clase')
                ->get();
    }

    public function store($actividad)
    {
        $diasHorarios = $actividad->dias_horarios;
        $actividad->offsetUnset('dias_horarios');
        $actividad->save();
        $this->storeDiasHorarios($actividad, $diasHorarios);
        $actividad->dias_horarios = $diasHorarios;
        return $actividad;
    }

    public function update($idActividad, $data)
    {
        $actividad = Actividad::with(['dias_horarios'])->find($idActividad);
        $this->updateActividad($actividad, $data);
        $actividad->dias_horarios()->delete();
        $actividad->save();
        $this->storeDiasHorarios($actividad, $data['diasHorarios']);
        return $actividad;
    }

    private function updateActividad($actividad, $data)
    {
        $actividad->nombre = $data['nombre'];
        $actividad->descripcion = $data['descripcion'];
        $actividad->duracion = $data['duracion'];
        $actividad->cantidad_alumnos_por_clase = $data['cantidadAlumnosPorClase'];
    }

    private function storeDiasHorarios($actividad, $diasHorarios)
    {
        forEach ($diasHorarios as $diaHorario) {
            $horarios = $diaHorario->horarios;
            $diaHorario->offsetUnset('horarios');
            $actividad->dias_horarios()->save($diaHorario);
            $diaHorario->horarios()->saveMany($horarios);
            $diaHorario->horarios = $horarios;
        }
    }

}