<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this); ?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link type="text/css" rel="stylesheet" href="/html/basic_task/www/css/frontend/style.css"/>
    <script type="text/javascript" src="/scripts/common/jquery.min.js"></script>
    <script type="text/javascript" src="/scripts/frontend/script.js"></script>
    <?php $this->head() ?>
</head>
<body>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Главная',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-inverse navbar-fixed-top my-nav',
//            'style' =>
//                'background-color: rgba(0, 0, 0, 0.5);'
        ],
    ]);
    $menuItems = [
        ['label' => 'Пользователи', 'url' => ['/users/index']],
    ];
    if (!Yii::$app->user->isGuest) {
        $username = \app\models\User::findOne(Yii::$app->user->id)->username;
        $menuItems[] = [
            'label' => 'Пользователь (' .
                $username
                . ')',
            'items' => [
                ['label' => 'Профиль', 'url' => ['/users/profile']],
                ['label' => 'Выйти', 'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']],
            ]
        ];
    } else {
        $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <div class="col-lg-12">
            <?php if (Yii::$app->session->allFlashes): ?>
                <?php foreach (Yii::$app->session->allFlashes as $item): ?>
                    <div class="alert alert-info" role="alert"
                         style="background-color: rgba(225, 225, 255, 0.4); border-color: rgba(175, 175, 200, 0.8);">
                        <?= $item ?> <br>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"><span class="glyphicon glyphicon-list"></span> My task, <?= date('F Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
