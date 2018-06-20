<?php

namespace Business\Shared\Services;

use Business\Shared\Helpers\ImageHelper;
use Illuminate\Support\Facades\Config;
use Business\Shared\Exceptions\ImageNotFoundException;

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
            throw new ImageNotFoundException();
        }
        $publicUrl = public_path() . $folderPath . $imageName;
        if (!file_exists($publicUrl)) {
            throw new ImageNotFoundException();
        }
        $type = mime_content_type($publicUrl);
        return ['image' => $this->imageHelper->getImage($publicUrl), 'type' => $type];
    }

    public function storeImage($id, $folder, $image)
    {
        return $this->imageHelper->storeBase64Image($id, $folder, $image);
    }

    public function updateImage($id, $folder, $image)
    {
        $fileToRemoveName = $this->getImageNameById($id, $folder);
        if ($fileToRemoveName) {
            $this->removeImage($fileToRemoveName, $folder);
        }
        return $this->storeImage($id, $folder, $image);
    }

    public function removeImage($url, $folder)
    {
        return $this->imageHelper->removeImage($url, $folder);
    }

    private function getImageNameById($id, $folder)
    {
        $namePattern = "item-$id-*";
        $folderPath = Config::get("constants.images_path.$folder");
        $fullPathPattern = public_path() . "$folderPath$namePattern";
        $filePathArray =  glob($fullPathPattern);
        if (sizeOf($filePathArray) === 0){
            return ;
        }
        $filePath = $filePathArray[0];
        $pathSplitted = explode('\\', $filePath);
        $fileName= $pathSplitted[sizeOf($pathSplitted) - 1];
        return $fileName;
    }
}