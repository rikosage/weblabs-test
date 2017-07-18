<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\Curl;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $curlname;

    private $_token;
    private $_userdata;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password', 'curlname'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => "Email",
            'password' => "Пароль",
            'curlname' => "Компания",
        ];
    }

    public function setErrors()
    {
        $map = [
            'curlname' => "company",
        ];

        foreach ($this->attributes as $key => $value) {
            $attribute = $key;
            if (array_key_exists($key, $map)) {
                $attribute = $map[$key];
            }

            if (property_exists($this->token->message, $attribute)) {
                $this->addError($key, $this->token->message->$attribute);
            }
        }
    }

    private function setToken()
    {
        $token = (new Curl)->getToken($this);

        if (
            isset($token->status) &&
            $token->status === Curl::BAD_REQUEST_STATUS
        ) {
            $this->setErrors();
            return false;
        }

        $this->_token = $token->token;
        return true;
    }

    private function setUserdata()
    {
        $this->_userdata = (new Curl)->getUser($this);
    }

    public function getUserdata()
    {
        return $this->_userdata;
    }


    public function getUserDataAsForm($modelName)
    {
        return [
            $modelName => $this->_userdata,
        ];
    }

    public function send()
    {

        if (!$this->setToken()) {
            return false;
        }

        $this->setUserdata();

        return (bool)$this->_userdata;

    }

    public function getToken()
    {
        return $this->_token;
    }
}
