<?php

namespace Business\Rutinas\Factories;

use Business\Rutinas\Models\ItemSerieRutina;
use Business\Rutinas\Factories\ParametroSemanaFactory;

class ItemSerieRutinaFactory {

    private $parametroSemanaFactory;

    public function __construct(ParametroSemanaFactory $psf)
    {
        $this->parametroSemanaFactory = $psf;
    }

    public function create($data)
    {
        $itemSerieRutina = new ItemSerieRutina();
        $itemSerieRutina->micro_descanso = isset($data['microDescanso']) ? $data['microDescanso'] : null;
        $itemSerieRutina->observaciones = isset($data['observaciones']) ? $data['observaciones'] : null;
        $itemSerieRutina->ejercicio_id = $data['ejercicio'];
        $parametrosSemanaJson = isset($data['parametrosSemana']) ? $data['parametrosSemana'] : null;
        if ($parametrosSemanaJson) {
            forEach($parametrosSemanaJson as $parametroSemanaJson) {
                $parametroSemana = $this->parametroSemanaFactory->create($parametroSemanaJson);
                $itemSerieRutina->parametrosSemana->add($parametroSemana);
            }
        }
        return $itemSerieRutina;
    }

}