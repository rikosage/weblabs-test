<?php

namespace app\components;

use Yii;
use app\interfaces\ApiRequestInterface;

/**
 * Простая обертка над расширение Curl
 * Возможно, здесь неплохо смотрелся бы Singleton, но я стараюсь их не использовать
 */
class Curl extends \linslin\yii2\curl\Curl
{

    /**
     * Статус ошибки
     * @var integer
     */
    const BAD_REQUEST_STATUS = 400;

    /**
     * Выполнить запрос на получение токена
     * @param  ApiRequestInterface $model Модель, аттрибуты который выступят в качестве данных
     * @return stdObject Ответ от API, с уже распарсенным json
     * @throws Exception
     */
    public function getToken($model)
    {
        if (!$model instanceof ApiRequestInterface) {
            throw new \Exception("Model must implements ApiRequestInterface!");
        }

        return json_decode(
            $this->setPostParams($model->attributes)
            ->post(Yii::$app->params["api"]["login"])
        );
    }

    /**
     * Выполнить запрос на получение данных о пользователе
     * @param  ApiRequestInterface $model     Модель, аттрибуты который выступят в качестве данных
     * @return array                          Данные о пользователе в виде ассоциативного массива
     * @throws Exception
     */
    public function getUser($model)
    {
        if (!$model instanceof ApiRequestInterface) {
            throw new \Exception("Model must implements ApiRequestInterface!");
        }

        return json_decode(
            $this->setHeaders([
                'Authorization' => "Bearer {$model->getToken()}",
            ])
            ->get(Yii::$app->params['api']['user'])
        , true);
    }
}
