<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\User;

/**
 * Контроллер для основного экшена
 */
class SiteController extends Controller
{
    /**
     * Точка обработки запросов с главной страницы
     * @return [type] [description]
     */
    public function actionIndex()
    {
        $model = new LoginForm;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->load($post);
            $model->send();
        }

        $user = new User;
        $user->load($model->getUserdataAsForm($user));

        return $this->render("index", [
            'model' => $model,
            'user' => $user,
        ]);
    }
}
