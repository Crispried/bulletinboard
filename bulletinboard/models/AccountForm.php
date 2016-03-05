<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\entities\User;
use yii\web\UploadedFile;
use app\models\ImageResizer;

/**
 * LoginForm is the model behind the login form.
 */
class AccountForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $information;
    public $rate;
    public $lastVisit;
    public $avatar;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // password rules
            'passwordRequired' => ['password', 'required'],
            'passwordLength'   => ['password', 'string', 'min' => 4, 'max' => 20],
            //infrmation rules
            'informationLength' => ['information', 'string', 'max' => 250],
            //avatar rules
            'avatarSafe' => ['avatar', 'safe'],
            'avatarValidation' => ['avatar', 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * fetch stored image file name with complete path
     * @return string
     */
    public function getImageFile()
    {
        return isset($this->avatar) ? Yii::$app->params['uploadPath'] . $this->avatar : null;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl($avatar)
    {
        // return a default image placeholder if your source avatar is not found
        $avatarUrl = isset($avatar) ? $avatar : 'default_user.jpg';
        return Yii::$app->params['uploadUrl'] . $avatarUrl;
    }
    /**
     * Process deletion of image
     *
     * @return boolean the status of deletion
     */
    public function deleteImage() {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->avatar = null;
        $this->filename = null;

        return true;
    }
    public function upload()
    {
        if ($this->validate()) {
            $image = $this->avatar;
            $image->saveAs('../images/account/' . $this->username . '.' . $this->avatar->extension);

            $image = new ImageResizer();
            $image->load('../images/account/' . $this->username . '.' . $this->avatar->extension);
            $image->resizeToWidth(200);
            $image->save('../images/account/' . $this->username . '.' . $this->avatar->extension);
            return true;
        } else {
            return false;
        }
    }
    public function update(User $user){
        if($this->validate()){
            if($this->avatar != null){
                $this->upload();
                $imageName = $this->username;
                $user->avatarUrl = '/bulletinboard/images/account/'. $imageName . '.' . $this->avatar->extension;
            }
            $user->password = $this->password;
            $user->information = $this->information;
            if($user->save()){
                return true;
            }
        }
        return false;
    }
}
