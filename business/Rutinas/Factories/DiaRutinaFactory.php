<?php

namespace Business\Rutinas\Factories;

use Business\Rutinas\Models\DiaRutina;
use Business\Rutinas\Factories\SerieRutinaFactory;

class DiaRutinaFactory {

    private $serieRutinaFactory;

    public function __construct(SerieRutinaFactory $srf)
    {
        $this->serieRutinaFactory = $srf;
    }

    public function create($data)
    {
        $diaRutina = new DiaRutina();
        $seriesJson = isset($data['series']) ? $data['series'] : null;
        if ($seriesJson) {
            forEach($seriesJson as $serieJson) {
                $serie = $this->serieRutinaFactory->create($serieJson);
                $diaRutina->series->add($serie);
            }
        }
        return $diaRutina;
    }

}