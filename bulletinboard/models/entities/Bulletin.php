<?php

namespace app\models\entities;

use yii\db\ActiveRecord;


class Bulletin extends ActiveRecord
{
    //public $imageFiles;
    public function rules()
    {
        return [
            // title rules
            'titleRequired' => ['title', 'required'],
            'titleLength'   => ['title', 'string', 'min' => 4, 'max' => 30],
            //description rules
            'descriptionRequired' => ['description', 'required'],
            'descriptionLength' => ['description', 'string', 'max' => 200],
            //avatar rules
           // [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }
}