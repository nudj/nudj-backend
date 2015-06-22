<?php namespace App\Models\Traits;


use App\Utility\CloudHelper;
use App\Utility\ImageHelper;
use Illuminate\Support\Facades\Config;

trait Imageable {

    public abstract function getConfigItem($item);


    public function getImagePath($path = '', $separator = DIRECTORY_SEPARATOR)
    {
        if(is_array($path))
            $path = implode($separator, $path);

        return Config::get('cfg.dir_upload') . $separator . $this->getConfigItem('imageDir') . $separator . $path;

    }

    public function getLocalImageUrl($path = '')
    {
        if(is_array($path))
            $path = implode('/', $path);

        return asset('/') .  Config::get('cfg.dir_upload') . '/' . $this->getConfigItem('imageDir') . '/' . $path;
    }


    public function getCloudImageUrls($id, $images, $sizes = null)
    {
        $result = [];

        if(empty($images))
            return $result;

        foreach ($images as $size => $image) {

            if(!$sizes || in_array($size, $sizes))
                $result[$size] = $this->getConfigItem('imageUrl') . $this->getImagePath([$id, $size, $image], '/');
        }
        return $result;
    }


    public function updateImage($imageSource = null)
    {

        $imageHelper = new ImageHelper($this->getImagePath($this->id));
        $images = $imageHelper->saveSizes($imageSource, $this->getConfigItem('imageSizes'));

        $cloudHelper = new CloudHelper(Config::get('cfg.rackspace'));
        foreach($images as $size => $image) {
            $imageParts = [$this->id, $size, $image];
            $cloudHelper->emptyContainer($this->getConfigItem('imageDir'));
            $cloudHelper->save($imageParts, $this->getLocalImageUrl($imageParts), $this->getConfigItem('imageDir'));
        }

        $imageHelper->emptyDir($this->getImagePath($this->id));

        return $images;
    }


}