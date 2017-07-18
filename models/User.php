<?php

namespace app\models;

use yii\base\Model;
use app\traits\ClassIdentityTrait;

/**
 * Модель для данных пользователя
 */
class User extends Model
{
    /**
     * ID
     * @var int
     */
    public $id;

    /**
     * Имя пользователя
     * @var string
     */
    public $name;

    /**
     * Email пользователя
     * @var string
     */
    public $email;

    /**
     * Роль пользователя
     * @var array
     */
    public $role;

    /**
     * Секретный ключ
     * @var string
     */
    public $secretKey;

    use ClassIdentityTrait;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [["id", "name", "email", "role", "secretKey"], "required"],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'name' => "Имя",
            'email' => "Email",
            'role' => "Название роли",
            'secretKey' => "Расшифрованный ключ",
        ];
    }

    /**
     * Возвращает расшифрованный ключ (base64)
     * @return string
     */
    public function getDecryptedKey()
    {
        return base64_decode($this->secretKey);
    }

    /**
     * Получить имя роли пользователя
     * @return string
     */
    public function getRoleName()
    {
        return $this->role['name'];
    }

    /**
     * Собирает данные, используемые в таблице
     * @return array
     */
    public function getTable()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'secretKey' => $this->decryptedKey,
            'role' => $this->roleName,
        ];
    }
}
