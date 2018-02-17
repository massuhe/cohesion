<?php

namespace Business\Inventario\Services;

use Business\Inventario\Repositories\InventarioRepository;
use Business\Inventario\Factories\InventarioFactory;
use Business\Inventario\Models\Inventario;
use Business\Inventario\Helpers\InventarioHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class InventarioService {

    private $inventarioRepository;
    private $inventarioFactory;
    private $inventarioHelper;

    public function __construct(
        InventarioRepository $ir, 
        InventarioFactory $if,
        InventarioHelper $ih
    )
    {
        $this->inventarioRepository = $ir;
        $this->inventarioFactory = $if;
        $this->inventarioHelper = $ih;
    }

    public function getAll($options = [])
    {
        return $this->inventarioRepository->get($options);
    }

    public function getById($itemId, $options = [])
    {
        $item = $this->inventarioRepository->getById($itemId, $options);
        if(!$item) {
            abort(404, 'No se ha encontrado el item.');
        }
        return $item;
    }

    public function store($data)
    {
        return DB::transaction(function() use ($data) {
            try {
                $item = $this->inventarioFactory->createItem($data);
                $item = $this->inventarioRepository->store($item);
                if (isset($data['image'])) {
                    $url = $this->inventarioHelper->storeBase64Image($item->id, 'inventario', $data['image']);
                    $this->inventarioRepository->updateImage($item, $url);
                }
                return $item;
            }
            catch (\Exception $e) {
                $this->inventarioHelper->removeImage($url, 'inventario');
                throw $e;
            }
        });
    }

    public function update($data, $idInventario)
    {
        $item = $this->inventarioRepository->getById($idInventario);
        return DB::transaction(function () use ($data, $item){
            $item = $this->inventarioRepository->update($data, $item->id);
            if(isset($data['image'])) {
                if ($item->image_path) {
                    $this->inventarioHelper->removeImage($item->image_path, 'inventario');
                }
                $newImage = $this->inventarioHelper->storeBase64Image($item->id, 'inventario', $data['image']);
                $this->inventarioRepository->updateImage($item, $newImage);
                return $item;
            }
        });
    }

    public function delete($idInventario)
    {
        $imagePath = $this->inventarioRepository->getById($idInventario)->image_path;
        if ($imagePath) {
            $this->inventarioHelper->removeImage($imagePath, 'inventario');
        }
        $this->inventarioRepository->delete($idInventario);
    }
}