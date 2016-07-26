<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm */
/* @var $form ActiveForm */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для регистрации:</p>

    <div class="row">
        <div class="col-lg-12">

            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-lg-5">
                    <?= $form->field($model, 'username')->textInput([
                        'pattern' => '^[0-9a-zA-ZА-Яа-яЁё\s]+$',
                        'maxlength' => '32',
                    ]) ?>
                    <?= $form->field($model, 'email')->textInput([
                        'maxlength' => '64',
                    ]) ?>
                    <?= $form->field($model, 'password')->passwordInput([
                        'maxlength' => '64',
                    ]) ?>
                    <?= $form->field($model, 'rePassword')->passwordInput([
                        'maxlength' => '64',
                    ]) ?>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-7">{input}</div></div>',
                    ]) ?>
                </div>

                <div class="col-lg-1"></div>

                <div class="col-lg-5">

                </div>
            </div>

            <div class="form-group">
                <hr>
                <?= Html::submitButton('Готово', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div><!-- site-signup -->
