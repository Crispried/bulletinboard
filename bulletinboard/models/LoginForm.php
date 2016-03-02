<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\entities\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $captcha;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username rules
            'usernameLength'   => ['username', 'string', 'min' => 4, 'max' => 20],
            'usernamePattern'  => ['username', 'match', 'pattern' => User::$usernameRegexp],
            'usernameRequired' => ['username', 'required'],
            // password rules
            'passwordRequired' => ['password', 'required'],
            'passwordLength'   => ['password', 'string', 'min' => 4, 'max' => 20],
            'passwordValidation' => ['password', 'validatePassword'],
            // captcha
            'checkCaptcha' => ['captcha', 'captcha']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
           // $identity = User::findOne(['username' => $this->username]);
            //Yii::$app->user->login($identity, $this->rememberMe ? 3600*24*30 : 0);
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);

        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
