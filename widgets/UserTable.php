<?php

namespace app\widgets;

use \yii\base\Widget;

/**
 * Виджет для вывода данных о юзере в виде таблицы
 */
class UserTable extends Widget
{
    /**
     * Модель юзера
     * @var \app\models\User
     */
    public $user;

    public function run()
    {
        if (!$this->user->id) {
            return false;
        }

        return $this->render("user", [
            'user' => $this->user,
        ]);
    }
}
