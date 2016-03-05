<?php

namespace app\models\entities;

use yii\db\ActiveRecord;

class Image extends ActiveRecord
{

    public static function upload($bulletinId)
    {
        if (!file_exists('../images/bulletin/' . $bulletinId)) {
            mkdir('../images/bulletin/' . $bulletinId, 0777, true);
        }
        $uploads_dir = '../images/bulletin/' . $bulletinId . '/';
        foreach ($_FILES["imageFiles"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["imageFiles"]["tmp_name"][$key];
                $name = $_FILES["imageFiles"]["name"][$key];
                move_uploaded_file($tmp_name, "$uploads_dir/$name");
                $image = new Image();
                $image->bulletinId = $bulletinId;
                $image->url = '/bulletinboard/images/bulletin/'. $bulletinId . '/' . $name;
                $image->save();
            }
        }
    }
}