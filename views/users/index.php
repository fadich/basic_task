<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsersList */
/* @var $form ActiveForm */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Список пользователей системы:</p>

    <?php $form = ActiveForm::begin() ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'name')->textInput([
                'pattern' => '^[0-9a-zA-ZА-Яа-яЁё\s]+$',
                'maxlength' => '32',
                'placeholder' => 'Поиск пользователя по имени...',
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'email')->textInput([
                'maxlength' => '64',
                'placeholder' => 'Поиск по адресу эл. почты...',
            ]) ?>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <div style="height: 25px"></div>
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', [
                    'class' => 'btn btn-default',
                ]) ?>
            </div>
        </div>
    </div>

    <table width="100%">
        <tr>
            <td width="25%" height="45px" align="center">
                <?= Html::submitButton('Имя пользователя' . $model->iconUsername, [
                    'class' => 'btn btn-default',
                    'name' => 'username',
                    'value' => $model->order['username'] ?? null,
                    'style' => 'width: 100%;'
                ]) ?>
            </td>
            <td width="25%" align="center">
                <?= Html::submitButton('Адрес эл. почты' . $model->iconEmail, [
                    'class' => 'btn btn-default',
                    'name' => 'email',
                    'value' => $model->order['email'] ?? null,
                    'style' => 'width: 100%;'
                ]) ?>
            </td>
            <td width="25%" align="center">
                <?= Html::submitButton('Время создание' . $model->iconCreatedAt, [
                    'class' => 'btn btn-default',
                    'name' => 'created_at',
                    'value' => $model->order['created_at'] ?? null,
                    'style' => 'width: 100%;'
                ]) ?>
            </td>
            <td width="25%" align="center">
                <?= Html::submitButton('Последнее обновление' . $model->iconUpdatedAt, [
                    'class' => 'btn btn-default',
                    'name' => 'updated_at',
                    'value' => $model->order['updated_at'] ?? null,
                    'style' => 'width: 100%;'
                ]) ?>
            </td>
        </tr>
        <?php foreach ($model->getUsers() as $item): ?>
            <tr class="user-table-tr"
                title="Для просмотра более подробной информации о данном пользователе, кликните по его имени.">
                <td height="45px" align="center">
                    <?= Html::a($item['username'], '/basic_task/www/index.php/users/profile?id=' . $item['id'], [
                        'class' => 'name-a',
                        'title' => 'Подробнее о пользователе ' . $item['username'] . '...',
                    ]) ?>
                </td>
                <td align="center">
                    <?= $item['email'] = (strlen($item['email']) > 32) ?
                        substr($item['email'], 0, 32) . '...' : $item['email']; ?></td>
                <td align="center" class="user-table-td"><?= date('d.m.Y H:i:s', $item['created_at']) ?></td>
                <td align="center" class="user-table-td"><?= date('d.m.Y H:i:s', $item['updated_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php ActiveForm::end(); ?>
    <?php ActiveForm::begin(); ?>

    <?php if ($model->getSize() / 25 > 1): ?>
        <p align="center">
            <?php for ($page = 0; $page < $model->getSize() / 5; $page++):
                if ($model->limit != $page + 1): ?>
                    <?= Html::submitButton($page + 1, [
                        'class' => 'page',
                        'name' => 'page',
                        'value' => $page + 1,
                    ]) ?>
                <?php else: ?>
                    <span style="font-size: 16px"><?= $page + 1 ?></span>
                <?php endif; ?>
            <?php endfor; ?>
        </p>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>
</div>
