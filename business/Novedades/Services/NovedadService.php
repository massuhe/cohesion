<?php

namespace Business\Novedades\Services;

use Business\Novedades\Repositories\NovedadRepository;
use Business\Novedades\Factories\NovedadFactory;
use Business\Novedades\Models\Novedad;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Business\Shared\Services\ImageService;

class NovedadService {

    private $novedadRepository;
    private $novedadFactory;
    private $imageService;

    public function __construct(
        NovedadRepository $nr, 
        NovedadFactory $nf,
        ImageService $is
    )
    {
        $this->novedadRepository = $nr;
        $this->novedadFactory = $nf;
        $this->imageService = $is;
    }

    public function getAll($options = [])
    {
        return $this->novedadRepository->get($options);
    }

    public function getById($novedadId, $options = [])
    {
        $novedad = $this->novedadRepository->getById($novedadId, $options);
        if (!$novedad) {
            abort(404, 'No se ha encontrado la novedad.');
        }
        return $novedad;
    }

    public function store($data)
    {
        return DB::transaction(function() use ($data) {
            $novedad = $this->novedadFactory->createNovedad($data);
            $this->novedadRepository->store($novedad);
            $this->storeNovedadImage($novedad, $data);
            return $novedad;
        });
    }

    public function update($data, $idNovedad)
    {
        $novedad = $this->novedadRepository->getById($idNovedad);
        return DB::transaction(function () use ($data, $novedad) {
            $novedad = $this->novedadRepository->update($novedad->id, $data);
            $this->storeNovedadImage($novedad, $data);
            return $novedad;
        });
    }

    public function delete($idNovedad)
    {
        DB::transaction(function () use ($idNovedad) {
            $imagePath = $this->novedadRepository->getById($idNovedad)->image_path;
            if ($imagePath) {
                $this->imageService->removeImage($imagePath, 'novedades');
            }
            $this->novedadRepository->delete($idNovedad);
        });
    }

    public function count()
    {
        return sizeof($this->novedadRepository->get());
    }

    private function storeNovedadImage($novedad, $data) {
        if (!(isset($data['image']) && $data['image'] !== null)) {
            return ;
        }
        try {
            $url = $this->imageService->updateImage($novedad->id, 'novedades', $data['image']);
            $this->novedadRepository->updateImage($novedad, $url);
        }
        catch (\Exception $e) {
            $this->imageService->removeImage($url, 'novedades');
            throw $e;
        }
    }
}