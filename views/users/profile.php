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
            'header' => 'Добавление фото',
            'toggleButton' => [
                'label' => '<span class="glyphicon glyphicon-plus"></span> Добавить',
                'class' => 'btn btn-default',
            ],
        ]);
        ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

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
    <br><br>
    <?php if ($model->pictures): ?>
        <?php foreach ($model->pictures as $picture): ?>
        <?php Modal::begin([
            'header' => $picture->name,
            'toggleButton' => [
                'label' => '<img src="/basic_task/www/' . $picture->path . '" class="modal-button-image-content">',
                'class' => 'btn btn-link modal-button-image',
                'id' => $picture->id,
            ],
        ]); ?>
        <p align="center">
            <?= Html::img('/basic_task/www/' . $picture->path, [
                'class' => 'modal-image',
            ]) ?>
        </p>
    <?php if (Yii::$app->user->id == $model->id): ?>
        <p id="delete<?= $picture->id ?>" align="right">
            <?= Html::button('<span class="glyphicon glyphicon-trash" style="color: red;"></span>', [
                'class' => 'btn btn-default',
                'onclick' => 'tryDelete' . $picture->id . '()',
            ]) ?>
        </p>
        <?php ActiveForm::begin(); ?>
        <p id="delete-buttons<?= $picture->id ?>" align="right"></p>
    <?php ActiveForm::end(); ?>
    <?php endif; ?>
        <script>
            function tryDelete<?= $picture->id ?>() {
                document.getElementById("delete<?= $picture->id ?>").innerHTML =
                    'Вы уверены, что хотите удалить фото?';
                document.getElementById("delete-buttons<?= $picture->id ?>").innerHTML =
                    '<?= Html::submitButton('Да', [
                        'class' => 'btn btn-default',
                        'name' => 'delete',
                        'value' => $picture->id,
                    ]) ?>' +
                    '&nbsp;' + '<?= Html::button('Нет', [
                        'class' => 'btn btn-success', 'align' => 'right',
                        'onclick' => 'deleteCancel' . $picture->id . '()',
                    ]) ?>';
            }
            function deleteCancel<?= $picture->id ?>() {
                document.getElementById("delete<?= $picture->id ?>").innerHTML =
                    '<?= Html::button('<span class="glyphicon glyphicon-trash" style="color: red;"></span>', [
                        'class' => 'btn btn-default',
                        'onclick' => 'tryDelete' . $picture->id . '()',
                    ]) ?>';
                document.getElementById("delete-buttons<?= $picture->id ?>").innerHTML = '';
            }
        </script>
    <?php if ($picture->description): ?>
        <h4>Описание:</h4><span><?= $picture->description ?></span>
    <?php endif; ?>
    <?php ActiveForm::begin(); ?>
    <?php ActiveForm::end(); ?>
    <?php Modal::end(); ?>
    <?php endforeach; ?>
    <?php else: ?>
        <p align="center">Нет загруженных фото...</p>
    <?php endif; ?>
</div><!-- users-profile -->

<style>
    .modal-dialog {
        width: 80%;
    }

    .modal-content {
        background-color: rgba(255, 255, 255, 0.75);
    }

    .modal-content:hover {
        background-color: rgba(255, 255, 255, 0.95);
    }

    .modal-header {
        height: 48px;
        font-size: 18px;
        text-align: center;
    }

    .modal-image {
        max-width: 80vw;
        max-height: 80vh;
    }

    .modal-button-image {
        height: 125px;
        max-width: 125px;
    }

    .modal-button-image-content {
        max-height: 115px;
        max-width: 115px;
    }
</style>

