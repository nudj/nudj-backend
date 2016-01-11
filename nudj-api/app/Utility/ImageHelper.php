<?php namespace App\Utility;

use Intervention\Image\Facades\Image;

class ImageHelper {

    protected $path;
    protected $filename;
    protected $image;

    public function __construct($path)
    {
        $this->setPath($path);
    }

    public function setPath($path)
    {
        $this->path = $this->createDir($path);
    }

    public function saveSizes($source, $sizes = null)
    {
        Image::configure(array('driver' => 'imagick'));

        $this->filename = str_random(10);

        try {
            $this->image = Image::make($source);
        } catch (\Exception $e) {
            throw new ApiException(ApiExceptionType::$IMAGE_ERROR, $e->getMessage());
        }
        $images = [];
        foreach ($sizes as $size) {
           $images[$size['name']] = call_user_func([$this, $size['transform']], $size);
        }

        return $images;
    }

    protected function crop($size)
    {
        $path = $this->createDir($this->path . $size['name']);
        $filename = $this->filename . self::getExtensionFromMime($this->image->mime);

        $image = clone $this->image;
        $image->fit($size['width'], $size['height']);
        $image->save($path . $filename);

        unset($image);

        return $filename;
    }

    protected function circle($size)
    {
        $path = $this->createDir($this->path . $size['name']);
        $filename = $this->filename . '.png';

        // Create the transparent mask
        $circle = Image::canvas($size['width'], $size['height']);
        $circle->circle($size['width'], $size['width']/2, $size['height']/2, function($draw) {
            $draw->background('#000');
        });

        // Resize the image and put the mask
        $image = clone $this->image;
        $image->fit($size['width'], $size['height']);
        $image->mask($circle, true);
        $image->save($path . $filename);

        unset($image);

        return $filename;
    }

    public function createDir($path)
    {
        is_dir($path) ?: mkdir($path, 0777, true);

        return rtrim($path, '/') . '/';
    }

    public function emptyDir($path, $removeDir = false)
    {
        $files = glob($path . '/*');

        foreach ($files as $file) {
            is_dir($file) ? $this->emptyDir($file, true) : unlink($file);
        }

        if($removeDir)
            rmdir($path);

        return true;
    }

    public static function getExtensionFromMime($mime)
    {
        if ($mime == 'image/jpeg')
            return '.jpg';
        elseif ($mime == 'image/png')
            return '.png';
        elseif ($mime == 'image/gif')
            return '.gif';
        else
            return false;
    }

}