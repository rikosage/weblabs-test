<?php

namespace app\interfaces;

interface ApiRequestInterface
{
    /**
     * Получить токен по запросу к API
     * @return string|null Токен, или null в случае отсутствия
     */
    public function getToken();

    /**
     * Получить данные о пользователе через API
     * @return array Данные о пользователе в виде ассоциативного массива
     */
    public function getUserdata();
}
