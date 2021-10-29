<?php

namespace App\Models\Traits;

use App\UseCases\ImageService;
use App\UseCases\Size;
use Illuminate\Support\Facades\Storage;


trait GalleryServais
{
    public function fitGallery()
    {
        if(!$this->imageList) {return;}
        if(!Storage::exists($this->getGalleryPath())) {return;}

        foreach ($this->imageList as $value)
        {
            $this->saveGallery(new Size($value));
        }
    }

    public function getGalleryPath()
    {
        return $this->getPath().$this->getDirGaleryName();
    }

    public function getGallery($size = false)
    {
        $path = $this->getGalleryPath();
        if(!Storage::exists($path) || !Storage::exists($path.'/origin')) {
            return [];
        }

        if(!$size){
            return Storage::files($path.'/origin');
        }

        if(!Storage::exists($path.'/'.$size)){
            return $this->saveGallery(new Size($size));
        }

        return Storage::files($path.'/'.$size);
    }

    public function uploadGallery($files)
    {
        if($files == null) { return; }

        $path = $this->getGalleryPath().'/origin';
        foreach ($files as $file) {
            $images[] = $path . '/' . $this->getFilename($path, $file);
        }
        $this->addImageToGallery($images);
    }

    public function addImageToGallery($images)
    {
        foreach (Storage::directories($this->getGalleryPath()) as $dir){
            $size = class_basename($dir);
            if($size == 'origin') {continue;}
            $this->saveGallery(new Size($size), $images);
        }
    }

    public function removeImageFromGallery($files)
    {
        if($files == null) { return; }
        foreach (Storage::directories($this->getGalleryPath()) as $dir)
        {
            foreach ($files as $file){
                Storage::delete($dir.'/'.$file);
            }
        }
    }

    public function saveGallery(Size $size, $images = false)
    {
        $files = $images ?: Storage::files($this->getGalleryPath().'/origin');
        $path = $this->getGalleryPath().'/'.$size->width.'x'.$size->height;

        if(!Storage::exists($path)){
            Storage::makeDirectory($path);
        }

        foreach ($files as $file){
            $image = new ImageService($size);
            $image->routeGalleryImageSave($file, $path, $this->getImageWatermark());
        }
        return Storage::files($path);
    }

    private function getFilename($path, $file)
    {
        $filename = '/'.str_random(10) . '.' . $file->extension();
        if (Storage::exists($path . $filename)) return $this->getFilename($path, $file);

        if(!Storage::exists($path)){
            Storage::makeDirectory($path);
        }

        $img = new ImageService(new Size('0x0'));
        //$img->saveImage($file, storage_path('app/public/').$path.$filename, self::IMAGE_WATERMARK);
        $img->routeUrlImageSave($file, $path.$filename, $this->getImageWatermark());

        return $filename;
    }

    private function getDirGaleryName()
    {
        try {
            return (new \ReflectionClassConstant(self::class, 'DIR_GALERY_NAME'))->getValue();
        } catch (\ReflectionException $e) {
            return 'galery';
        }
    }
}
