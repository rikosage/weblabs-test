<?php

namespace app\models;

use yii\base\Model;

class User extends Model
{
    public $id;
    public $name;
    public $email;
    public $role;
    public $secretKey;

    public function getSecretKey()
    {
        return base64_decode($this->secretKey);
    }

    public function getRoleName()
    {
        return $this->role->name;
    }
}
