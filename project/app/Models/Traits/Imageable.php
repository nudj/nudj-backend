<?php namespace App\Models\Traits;

use Illuminate\Support\Facades\URL;

trait Imageable {

    public $path;

    public function getImageDir($path = '')
    {
        if(is_array($path))
            $path = implode('/', $path);

        if(isset($this->imageDir))
            return $this->imageDir . $path;

        return $path;
    }


    public function getImageUrls($id, $images, $sizes = null)
    {
        $result = [];

        if(empty($images))
            return $result;

        foreach ($images as $size => $image) {
            if(!$sizes || in_array($size, $sizes))
                $result[$size] = asset('/') .  $this->getImageDir([$id, $size, $image]);
        }
        return $result;
    }


}