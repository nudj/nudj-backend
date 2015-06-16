<?php namespace App\Models\Traits;

trait Imageable {

    protected $filesDir = 'upload';


    public function getImagePath($path = '')
    {
        if(is_array($path))
            $path = implode(DIRECTORY_SEPARATOR, $path);

        if(isset($this->imageDir))
            return $this->filesDir . DIRECTORY_SEPARATOR . $this->imageDir . DIRECTORY_SEPARATOR . $path;

        return $path;
    }

    public function getImageUrl($path = '')
    {
        if(is_array($path))
            $path = implode('/', $path);

        $imageDir = isset($this->imageDir) ? $this->imageDir : '';

        return asset('/') .  $this->filesDir . '/' . $imageDir . '/' . $path;
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