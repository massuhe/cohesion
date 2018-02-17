<?php

namespace Business\Shared\Helpers;

use Illuminate\Support\Facades\Config;

class ImageHelper {

    public function storeBase64Image($idItem, $folder, $base64Img) 
    {
        $base64_str = substr($base64Img, strpos($base64Img, ",") + 1);
        $extension = $this->getExtension($base64Img);
        $image = base64_decode($base64_str);
        $imageName = "item-$idItem-".time().".$extension";
        $url = public_path() . Config::get("constants.images_path.$folder") . $imageName;
        $success = file_put_contents($url, $image);
        if (!$success) {
            throw new \Exception();
        }
        return $imageName;
    }

    public function removeImage($url, $folder)
    {
        $publicUrl = public_path() . Config::get("constants.images_path.$folder") . $url;
        if (file_exists($publicUrl)) {
            unlink($publicUrl);
        }
    }

    public function getImage($publicUrl)
    {
        $data = file_get_contents($publicUrl);
        return $data;
    }

    private function getExtension($base64Img)
    {
        $initPos = strPos($base64Img, 'image/') + strlen('image/');
        $endPos = strPos($base64Img, ';', $initPos) - $initPos;
        $extension = substr($base64Img, $initPos, $endPos);
        return $extension;
    }
}