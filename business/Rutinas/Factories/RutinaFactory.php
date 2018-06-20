<?php

namespace Business\Rutinas\Factories;

use Business\Rutinas\Factories\DiaRutinaFactory;
use Business\Rutinas\Models\Rutina;
use Carbon\Carbon;

class RutinaFactory {

    private $diaRutinaFactory;

    public function __construct(DiaRutinaFactory $drf)
    {
        $this->diaRutinaFactory = $drf;
    }

    public function create($data)
    {
        $rutina = new Rutina();
        $rutina->fecha_inicio = new Carbon($data['fechaInicio']);
        $rutina->fecha_fin = isset($data['fechaFin']) ? new Carbon($data['fechaFin']) : null;
        $rutina->total_semanas = $data['totalSemanas'];
        // $rutina->numero_rutina = $data['numeroRutina'];
        $rutina->alumno_id = $data['alumno'];
        $diasJson = isset($data['dias']) ? $data['dias'] : null;
        if ($diasJson) {
            forEach($diasJson as $diaJson) {
                $dia = $this->diaRutinaFactory->create($diaJson);
                $rutina->dias->add($dia);
            }
        }
        return $rutina;
    }

}