<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\entities\User;

class RegisterForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $email;
    public $captcha;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
       // $user = $this->module->modelMap['User'];
        return [
            // username rules
            'usernameLength'   => ['username', 'string', 'min' => 4, 'max' => 20],
            'usernameTrim'     => ['username', 'filter', 'filter' => 'trim'],
            'usernamePattern'  => ['username', 'match', 'pattern' => User::$usernameRegexp],
            'usernameRequired' => ['username', 'required'],
            'usernameUnique'   => [
                'username',
                'unique',
                'targetClass' => 'app\models\entities\User',
                'message' => 'This username has already been taken.'
            ],
            // email rules
            'emailTrim'     => ['email', 'filter', 'filter' => 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern'  => ['email', 'email'],
            'emailUnique'   => [
                'email',
                'unique',
                'targetClass' => 'app\models\entities\User',
                'message' => 'This email address has already been taken.'
            ],
            // password rules
            'passwordRequired' => ['password', 'required'],
            'passwordCompare' => ['password', 'compare'],
            'passwordLength'   => ['password', 'string', 'min' => 4, 'max' => 20],
            // captcha
            'checkCaptcha' => ['captcha', 'captcha']
        ];
    }
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->password = $this->password;
            $user->email = $this->email;
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }
}