<?php

namespace Business\Novedades\Factories;

use Business\Novedades\Models\Novedad;

class NovedadFactory {

    public function createNovedad($data)
    {
        $novedad = new Novedad();
        $novedad->titulo = $data['titulo'];
        $novedad->contenido = $data['contenido'];
        $novedad->es_prioritaria = $data['esPrioritaria'];
        return $novedad;
    }

}