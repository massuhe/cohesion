<?php

namespace Business\Rutinas\Factories;

use Business\Rutinas\Models\SerieRutina;
use Business\Rutinas\Factories\ItemSerieRutinaFactory;

class SerieRutinaFactory {

    private $itemSerieRutinaFactory;

    public function __construct(ItemSerieRutinaFactory $isrf)
    {
        $this->itemSerieRutinaFactory = $isrf;
    }

    public function create($data)
    {
        $serieRutina = new SerieRutina();
        $serieRutina->vueltas = $data['vueltas'];
        $serieRutina->macro_descanso = isset($data['macroDescanso']) ? $data['macroDescanso'] : null;
        $serieRutina->observaciones = isset($data['observaciones']) ? $data['observaciones'] : null;
        $itemsSerieRutinaJson = isset($data['items']) ? $data['items'] : null;
        if ($itemsSerieRutinaJson) {
            forEach ($itemsSerieRutinaJson as $itemSerieRutinaJson) {
                $itemSerieRutina = $this->itemSerieRutinaFactory->create($itemSerieRutinaJson);
                $serieRutina->items->add($itemSerieRutina);
            }
        }
        return $serieRutina;
    }

}