<?php

namespace Business\Inventario\Repositories;

use Optimus\Genie\Repository;
use Illuminate\Support\Facades\DB;
use Business\Inventario\Models\ItemInventario;

class InventarioRepository extends Repository {

    public function getModel()
    {
        return new ItemInventario();
    }

    public function store($item)
    {
        $item->save();
        return $item;
    }

    public function update($data, $idInventario)
    {
        $item = $this->getById($idInventario);
        $item->cantidad = $data['cantidad'];
        $item->descripcion = $data['descripcion'];
        $item->save();
        return $item;
    }

    public function updateImage($item, $image)
    {
        $item->image_path = $image;
        $item->save();
        return $item;
    }

}