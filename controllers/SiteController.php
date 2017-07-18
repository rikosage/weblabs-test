<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\User;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $model = new LoginForm;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->load($post);
            $model->send();
        }

        $user = new User;
        $user->load($model->getUserdata());

        var_dump($user);exit;

        return $this->render("index", [
            'model' => $model,
        ]);
    }
}
