<?php
namespace app\models\rules;
use app\models\entities\Image;

interface IImageRepository
{
    public function getImages();
    public function saveImage(Image $image);
    public function deleteImage($imageId);
}