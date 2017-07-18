<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\Curl;
use app\interfaces\ApiRequestInterface;


/**
 * Форма логина отправляет данные в API, валидирует их, и обрабатывает
 */
class LoginForm extends Model implements ApiRequestInterface
{
    /**
     * Email: test@user.demo
     * @var string
     */
    public $email;

    /**
     * Пароль: 1234567A
     * @var string
     */
    public $password;

    /**
     * Название компании: web-2015
     * @var string
     */
    public $curlname;

    /**
     * Хранимый токен
     * @var string
     */
    private $_token;

    /**
     * Данные о пользователе
     * @var array
     */
    private $_userdata;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            // email валидатор специально не ставлю, он есть в API
            [['email', 'password', 'curlname'], 'required'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'email' => "Email",
            'password' => "Пароль",
            'curlname' => "Компания",
        ];
    }

    /**
     * Установить ошибки от API как штатные ошибки модели
     * @param stdObject $response Ответ от API
     */
    public function setErrors($response)
    {
        // Поскольку имя данного поля в API отличается - объявляем простую карту соответствий
        $map = [
            'curlname' => "company",
        ];

        foreach ($this->attributes as $key => $value) {
            $attribute = $key;
            if (array_key_exists($key, $map)) {
                $attribute = $map[$key];
            }

            if (property_exists($response->message, $attribute)) {
                if (is_array($response->message->$attribute)) {
                    foreach ($response->message->$attribute as $counter => $error) {
                        $this->addError($key, $error);
                    }
                } else {
                    $this->addError($key, $response->message->$attribute);
                }
            }
        }
    }

    /**
     * Запросить токен у API
     * @return boolean TRUE в случае успеха
     */
    private function setToken()
    {
        $response = (new Curl)->getToken($this);

        if (
            isset($response->status) &&
            $response->status === Curl::BAD_REQUEST_STATUS
        ) {
            $this->setErrors($response);
            return false;
        }

        $this->_token = $response->token;
        return true;
    }

    /**
     * Запросить данные пользователя от API
     * @return null
     */
    private function setUserdata()
    {
        $this->_userdata = (new Curl)->getUser($this);
    }

    /**
     * Получить данные пользователя
     * @return array
     */
    public function getUserdata()
    {
        return $this->_userdata;
    }

    /**
     * Получить данные в виде стандартной формы
     * Реализовано для того, чтобы работал стандартный метод load
     * @param  Model $model  Зависимая модель, в которую предполагается загружать данные
     * @return array
     */
    public function getUserDataAsForm($model)
    {
        if (!method_exists($model, "getShortClassName")) {
            throw new \Exception("Model must use ClassIdentityTrait!");
        }

        return [
            $model->getShortClassName() => $this->_userdata,
        ];
    }

    /**
     * Выполнить последовательные запросы по токену и данным юзера
     * @return TRUE в случае успеха
     */
    public function send()
    {

        if (!$this->setToken()) {
            return false;
        }

        $this->setUserdata();

        return (bool)$this->_userdata;

    }

    /**
     * Получить токен
     * @return string|null 
     */
    public function getToken()
    {
        return $this->_token;
    }
}
