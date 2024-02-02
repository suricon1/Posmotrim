<?php

namespace App\UseCases;

use Intervention\Image\Facades\Image;

class ImageService
{
    public $width;
    public $height;

    public function __construct(Size $size)
    {
        $this->width = $size->width;
        $this->height = $size->height;
    }

    public function saveImage($fromPath, $savePath, $watermark = false)
    {
    //dd($fromPath);
        $img = Image::make($fromPath)->encode('jpeg')->widen(1200, function ($constraint) {
            $constraint->upsize();
        });

        if($img->filesize() > 512000){
            throw new \DomainException('Размер фото превышает 500 KB.');
        }

        if($this->width && $this->height){
            $img->fit($this->width, $this->height, function ($constraint) {
                $constraint->upsize();
            });
        }

        if($watermark && $this->width > 300){
            $img->insert(storage_path('app/public/pics/') . $watermark, 'bottom-right', 0, 0);     //Наложение водяного знака
        }
        //return;
        $img->save($savePath, 70);
        $img->destroy();
    }

    public function routeGalleryImageSave($fromPath, $savePath, $watermark = false)
    {
        //$this->saveImage(public_path() .'/'. $fromPath, public_path() .'/'. $savePath. '/' . class_basename($fromPath));
        $this->saveImage(storage_path('app/public/') . $fromPath, storage_path('app/public/') . $savePath. '/' . class_basename($fromPath), $watermark);
    }

    public function routeImageSave($fromPath, $savePath, $watermark = false)
    {
        //dd(storage_path('app/public/') . $fromPath, $savePath, storage_path('app/public/') . $savePath);
        //$this->saveImage(public_path() .'/'. $fromPath, public_path() .'/'. $savePath);
        $this->saveImage(storage_path('app/public/') . $fromPath, storage_path('app/public/') . $savePath, $watermark);
    }

    public function routeUrlImageSave($fromPath, $savePath, $watermark = false)
    {
        $this->saveImage($fromPath, storage_path('app/public/') . $savePath, $watermark);
    }
}
