<?php

namespace app\components;

use Yii;

class Curl extends \linslin\yii2\curl\Curl
{

    const BAD_REQUEST_STATUS = 400;

    public function getToken($model)
    {
        return json_decode(
            $this->setPostParams($model->attributes)
            ->post(Yii::$app->params["api"]["login"])
        );
    }

    public function getUser($model)
    {
        return json_decode(
            $this->setHeaders([
                'Authorization' => "Bearer {$model->getToken()}",
            ])
            ->get(Yii::$app->params['api']['user'])
        , true);
    }
}
