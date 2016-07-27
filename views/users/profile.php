<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $picture app\models\Picture */
/* @var $form ActiveForm */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-profile">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пользователь <?= $model->username ?>:</p>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <div class="col-lg-5">
            <?= $form->field($model, 'username')->textInput([
                'pattern' => '^[0-9a-zA-ZА-Яа-яЁё\s]+$',
                'maxlength' => '32',
                'readOnly' => (Yii::$app->user->id != $model->id),
            ]) ?>
            <?= $form->field($model, 'email')->textInput([
                'readOnly' => true,
            ]) ?>
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-5">
            <?= $form->field($model, 'createdAt')->textInput([
                'readOnly' => true,
            ]) ?>
            <?= $form->field($model, 'updatedAt')->textInput([
                'readOnly' => true,
            ]) ?>
        </div>
    </div>
    <?php if (Yii::$app->user->id == $model->id): ?>
        <div class="form-group">
            <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>
    <hr>
    <h2>Фотографии:</h2>

    <?php if (Yii::$app->user->id == $model->id): ?>
        <?php Modal::begin([
            'header' => '<h2 align="center">Добавление фото</h2>',
            'toggleButton' => [
                'label' => '<span class="glyphicon glyphicon-plus"></span> Добавить',
                'class' => 'btn btn-default',
            ],
        ]);
        ActiveForm::begin(); ?>

        <?= $form->field($picture, 'name')->textInput(['pattern' => '^[0-9a-zA-ZА-Яа-яЁё\s]+$']) ?>
        <?= $form->field($picture, 'file')->fileInput() ?>
        <?= $form->field($picture, 'description')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Добавить',
                ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end();
        Modal::end(); ?>
    <?php endif; ?>
    <?php if ($model->pictures):
        foreach ($model->pictures as $picture): ?>
            <?= $picture->name; ?>
        <?php endforeach;
    else: ?>
        <p align="center">Нет загруженных фото...</p>
    <?php endif; ?>

</div><!-- users-profile -->
