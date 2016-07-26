<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = 'Ошибка: ' . $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <strong><?= nl2br(Html::encode($message)) ?></strong>
    </div>

    <h4>
        Ошибка запроса к web-серверу (<span class="error-request"><?= \yii\helpers\Url::to() ?></span>).
    </h4>
    <h4>
        Пожалуйста, проверте правильность введенного Вами запроса и повторите попытку.
    </h4>

</div>
