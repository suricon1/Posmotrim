<?php

namespace App\Models\Traits;

use App\UseCases\ImageService;
use App\UseCases\Size;
use Storage;

trait ImageServais
{
    public function getPath()
    {
        $className = strtolower(class_basename(self::class));
        $dir = implode('/', array_slice(explode('\\', self::class),-2,2));
        return "pics/$dir/$className-{$this->id}/";
    }

    public function getContentPath()
    {
        return $this->getPath() . $this->getDirContentImageName() . '/';
    }

    public function fitImage()
    {
        if (!$this->imageList) {
            return;
        }
        foreach ($this->imageList as $value) {
            $this->saveImage(new Size($value));
        }
    }

    public function getImage($value = false)
    {
        if (!$value) {
            return ($this->getOriginImage()) ? Storage::url($this->getOriginImage()) : null;
        }

        if (!Storage::exists($this->getPath() . $this->getOriginImageName())) {
            return $this->getDefaultImageName();
        }

        if (Storage::exists($this->getPath() . $value . '.jpg')) {
            //return $this->getPath() . $value . '.jpg';
            return Storage::url($this->getPath() . $value . '.jpg');
        }
        return $this->saveImage(new Size($value));
    }

    public function removeImage()
    {
        $files = Storage::files($this->getPath());
        Storage::delete($files);
    }

    public function deleteImages()
    {
        Storage::deleteDirectory($this->getPath());
    }

    public function uploadImage($image)
    {
        if ($image == null) {return;}

        $this->removeImage();

        if(!Storage::exists($this->getPath())){
            Storage::makeDirectory($this->getPath());
        }

        $img = new ImageService(new Size('0x0'));
        $img->routeUrlImageSave($image, $this->getPath().$this->getOriginImageName(), $this->getImageWatermark());
    }

    public function getOriginImage()
    {
        return Storage::exists($this->getPath() . $this->getOriginImageName())
            ? $this->getPath() . $this->getOriginImageName()
            : $this->getDefaultImageName();
    }

    private function saveImage(Size $size)
    {
        $path = $this->getPath() . $size->width . 'x' . $size->height . '.jpg';
        if (Storage::exists($path)) {
            return Storage::url($path);
        }

        $image = new ImageService($size);
        $image->routeImageSave($this->getOriginImage(), $path, $this->getImageWatermark());

        return Storage::url($path);
    }

    private function getDirContentImageName()
    {
        try {
            return (new \ReflectionClassConstant(self::class, 'DIR_CONTENT_IMAGE_NAME'))->getValue();
        } catch (\ReflectionException $e) {
            return 'content';
        }
    }

    private function getOriginImageName()
    {
        try {
            return (new \ReflectionClassConstant(self::class, 'ORIGIN_IMAGE_NAME'))->getValue();
        } catch (\ReflectionException $e) {
            return 'origin.jpg';
        }
    }

    private function getDefaultImageName()
    {
        try {
            return (new \ReflectionClassConstant(self::class, 'DEFAULT_IMAGE_NAME'))->getValue();
        } catch (\ReflectionException $e) {
            return null;
        }
    }

    public function getImageWatermark()
    {
        try {
            return (new \ReflectionClassConstant(self::class, 'IMAGE_WATERMARK'))->getValue();
        } catch (\ReflectionException $e) {
            return false;
        }
    }
}
