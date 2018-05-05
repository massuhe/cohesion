<?php

namespace Business\Rutinas\Repositories;

use Illuminate\Support\Facades\DB;
use Optimus\Genie\Repository;
use Business\Rutinas\Models\Rutina;

class RutinaRepository extends Repository
{

    public function getModel()
    {
        return new Rutina();
    }

    public function storeRutina($rutina)
    {
        DB::transaction(function() use ($rutina){
            $rutina->save();
            $rutina->dias()->saveMany($rutina->dias);
            forEach ($rutina->dias as $dia) {
                $this->storeDia($dia);
            }
        });
    }

    /**
     * Retorna la rutina del alumno pasado por parámetro cuyo número corresponda al pasado también por parámetro. Si no se pasa un
     * número de rutina, se devolvera la rutina actual (si hay alguna).
     */
    public function getByAlumno($alumnoId, $numero_rutina = null)
    {
        $rutinaQuery = Rutina::with(['dias.series.items.parametrosSemana.parametros.clase', 'dias.series.items.ejercicio'])
                             ->where('alumno_id', $alumnoId);
        if ($numero_rutina) {
            $rutinaQuery->where('numero_rutina', $numero_rutina);
        } else {
            $rutinaQuery->whereNull('fecha_fin');
        }
        $rutina = $rutinaQuery->first();
        return $rutina;
    }

    public function updateRutina($rutina, $entidadesBorrar)
    {
        DB::transaction(function() use ($entidadesBorrar, $rutina) {
            $this->storeRutina($rutina);
            $this->borrarEntidadesRutina($entidadesBorrar);
        });
    }

    public function getUltimaSemanaCargada($idRutina)
    {
        $query = "SELECT p.semana, count(pis.id) as cantidad_cargas
                  FROM rutinas r, dias_rutina d, series_rutina s, items_serie_rutina i, parametros_semana p
                  LEFT JOIN parametros_item_serie pis ON p.id = pis.parametro_semana_id
                  WHERE r.id = d.rutina_id
                  AND r.id = $idRutina
                  AND d.id = s.dia_rutina_id
                  AND s.id = i.serie_rutina_id
                  AND i.id = p.item_serie_rutina_id
                  GROUP BY r.id, p.semana
                  HAVING count(pis.id) > 0
                  ORDER BY p.semana DESC LIMIT 1";
        $data = DB::select(DB::raw($query));
        return sizeof($data) > 0 ? $data[0] : null;
    }

    public function cargarDetalles($parametrosSemana)
    {
        DB::transaction(function() use ($parametrosSemana) {
            forEach ($parametrosSemana as $parametroSemana) {
                $parametroSemana->parametros()->saveMany($parametroSemana->parametros);
            }
        });
    }

    private function borrarEntidadesRutina($entidadesBorrar)
    {
        forEach($entidadesBorrar as $entidad) {
            $entidad->delete();
        }
    }

    private function storeDia($dia)
    {
        $dia->series()->saveMany($dia->series);
        forEach ($dia->series as $serie) {
            $this->storeSerie($serie);
        }
    }

    private function storeSerie($serie)
    {
        $serie->items()->saveMany($serie->items);
        forEach ($serie->items as $item) {
            $this->storeItem($item);
        }
    }

    private function storeItem($item)
    {
        $item->parametrosSemana()->saveMany($item->parametrosSemana);
    }

}