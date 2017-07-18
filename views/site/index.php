<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\widgets\UserTable;

/* @var $this yii\web\View */
$this->title = 'Weblabs Task';
?>

<div class="wrap">
    <div class="row">
        <div class="well">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
            ]); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'curlname')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    </div>


    <?php ActiveForm::end(); ?>
</div>
<hr>
<div class="row">
    <?= UserTable::widget(['user' => $user]); ?>
</div>
