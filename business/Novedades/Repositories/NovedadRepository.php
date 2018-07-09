<?php

namespace Business\Novedades\Repositories;

use Optimus\Genie\Repository;
use Illuminate\Support\Facades\DB;
use Business\Novedades\Models\Novedad;

class NovedadRepository extends Repository {

    public function getModel()
    {
        return new Novedad();
    }

    public function store($novedad)
    {
        $novedad->save();
        return $novedad;
    }

    public function update($idNovedad, $data)
    {
        $novedad = $this->getById($idNovedad);
        $novedad->titulo = $data['titulo'];
        $novedad->contenido = $data['contenido'];
        $novedad->es_prioritaria = $data['esPrioritaria'];
        $novedad->save();
        return $novedad;
    }

    public function updateImage($novedad, $image)
    {
        $novedad->image_path = $image;
        $novedad->save();
        return $novedad;
    }

}