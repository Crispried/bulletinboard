<?php

namespace app\models\entities;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';
    public static function tableName()
    {
        return 'user';
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }
    public function getId()
    {
        return $this->userId;
    }
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return user|null
     */
    public static function findByUsername($username)
    {
        $user = User::findOne(['username' => $username]);
        if ($user != null) {
            return $user;
        }
        return null;
    }
    /**
     * Finds user by email
     *
     * @param  string      $email
     * @return user|null
     */
    public static function findByEmail($email)
    {
        $user = User::findOne(['email' => $email]);
        if ($user != null) {
            return $user;
        }
        return null;
    }
    public static function getUsernameById($id){
        $user = User::findOne(['userId' => $id]);
        if ($user != null) {
            return $user->username;
        }
        return null;
    }
    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}