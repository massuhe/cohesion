<?php

namespace Business\Inventario\Factories;

use Business\Inventario\Models\ItemInventario;

class InventarioFactory {

    public function createItem($data)
    {
        $item = new ItemInventario();
        $item->cantidad = $data['cantidad'];
        $item->descripcion = $data['descripcion'];
        return $item;
    }

}