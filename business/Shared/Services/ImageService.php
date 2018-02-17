<?php

namespace Business\Shared\Services;

use Business\Shared\Helpers\ImageHelper;
use Illuminate\Support\Facades\Config;

class ImageService {

    private $imageHelper;

    public function __construct(ImageHelper $ih) 
    {
        $this->imageHelper = $ih;
    }

    public function getImage($folder, $imageName)
    {
        $folderPath = Config::get("constants.images_path.$folder");
        if (!$folderPath) {
            throw new \Exception();
        }
        $publicUrl = public_path() . $folderPath . $imageName;
        if (!file_exists($publicUrl)) {
            throw new \Exception();
        }
        $type = mime_content_type($publicUrl);
        return ['image' => $this->imageHelper->getImage($publicUrl), 'type' => $type];
    }
}