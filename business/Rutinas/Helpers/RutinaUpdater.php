<?php

namespace Business\Rutinas\Helpers;
use Carbon\Carbon;
use Business\Rutinas\Factories\DiaRutinaFactory;
use Business\Rutinas\Factories\SerieRutinaFactory;
use Business\Rutinas\Factories\ItemSerieRutinaFactory;
use Business\Rutinas\Factories\ParametroSemanaFactory;

class RutinaUpdater {

    private $diaRutinaFactory;
    private $serieRutinaFactory;
    private $itemSerieRutinaFactory;
    private $parametroSemanaFactory;

    public function __construct(
        DiaRutinaFactory $drf,
        SerieRutinaFactory $srf,
        ItemSerieRutinaFactory $isrf,
        ParametroSemanaFactory $psf
    )
    {
        $this->diaRutinaFactory = $drf;
        $this->serieRutinaFactory = $srf;
        $this->itemSerieRutinaFactory = $isrf;
        $this->parametroSemanaFactory = $psf;
    }

    /**
     * Actualiza la rutina según los datos pasados por parámetros.
     * Retorna un array en donde la clave rutina es la rutina actualizada con los datos, y la clave borrar contiene
     * las entidades que deben ser borradas (DiaRutina, ItemSerieRutina, etc...).
     */
    public function updateRutina($rutina, $data)
    {
        $rutina->fecha_inicio = new Carbon($data['fechaInicio']);
        $rutina->fecha_fin = isset($data['fechaFin']) ? new Carbon($data['fechaFin']) : $rutina->fecha_fin;
        $rutina->total_semanas = $data['totalSemanas'];
        $entidadesBorrar = $this->generic($rutina, 'dias', $data['dias'], 'diaRutinaFactory', 'updateDia');
        return $entidadesBorrar;
    }

    private function updateDia($dia, $data)
    {
        return $this->generic($dia, 'series', $data['series'], 'serieRutinaFactory', 'updateSerie');
    }

    private function updateSerie($serieRutina, $data)
    {
        $serieRutina->vueltas = $data['vueltas'];
        $serieRutina->macro_descanso = isset($data['macroDescanso']) ? $data['macroDescanso'] : $serieRutina->macro_descanso;
        $serieRutina->observaciones = isset($data['observaciones']) ? $data['observaciones'] : $serieRutina->observaciones;
        return $this->generic($serieRutina, 'items', $data['items'], 'itemSerieRutinaFactory', 'updateItemSerieRutina');
    }

    public function updateItemSerieRutina($itemSerieRutina, $data)
    {
        $itemSerieRutina->micro_descanso = isset($data['microDescanso']) ? $data['microDescanso'] : $itemSerieRutina->micro_descanso;
        $itemSerieRutina->observaciones = isset($data['observaciones']) ? $data['observaciones'] : $itemSerieRutina->observaciones;
        $itemSerieRutina->ejercicio_id = $data['ejercicio'];
        return $this->generic($itemSerieRutina, 'parametrosSemana', $data['parametrosSemana'], 'parametroSemanaFactory', 'updateParametroSemana');
    }

    public function updateParametroSemana($parametroSemana, $data)
    {
        // $parametroSemana->semana = $data['semana'];
        $parametroSemana->repeticiones = $data['repeticiones'];
        return [];
    }

    private function generic($entity, $entityProp, $data, $factoryProperty, $nextCallback)
    {
        // Inicializo arrays para ver si tengo que agregar, modificar o eliminar entidades
        $delete = $add = $modify = [];
        // En este loop me fijo si los datos pasados en el json tienen id (y por lo tanto, si son registros existentes en la base de datos).
        // Si no tiene, creo una entidad para ese registro y la agrego al array de add, si tiene la agrego al array de modify para ser tratado
        // mas adelante.
        forEach ($data as $d) {
            if (!isset($d['id'])) {
                $new = $this->$factoryProperty->create($d);
                $add[] = $new;
            } else {
                $modify[] = $d;
            }
        }
        // En este loop itero ahora sobre las entidades existentes en la base de datos, si alguna de estas entidades no está incluida en los
        // datos pasados en el json (y que no son registros nuevos, por eso se busca en modify), significa que el registro 
        // tiene que ser borrado, por lo tanto agrego en el array delete para ser borrado más adelante. Por el contrario si el registro
        // aparece en el json, probablemente tenga que ser modificado y por ello invoco a nextCallback (la función que se encargará de 
        // realizar dicha modificación).
        forEach ($entity->$entityProp as $e) {
            $eData = collect($modify)->first(function ($d) use ($e) {
                return $d['id'] === $e->id;
            });
            if (!$eData) {
                $delete[] = $e;
            } else {
                $delete = array_merge($delete, $this->$nextCallback($e, $eData));
            }
        }
        // Esto nomás lo hago porque si no funciona hacer directamente ->saveMany($add). ¯\_(ツ)_/¯
        forEach ($add as $e) {
            $entity->$entityProp->add($e);
        }
        return $delete;
    }

}