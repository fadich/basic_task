<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */
/* @var $form ActiveForm */

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для авторизации:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Вход', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div><!-- site-login -->
