<?php

namespace app\controllers;

use app\models\UsersList;
use Yii;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UsersController extends \yii\web\Controller
{

    /**
     * Можно редиректить на логин
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['index'],
//                'rules' => [
//                    [
//                        'actions' => ['index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Для просмотра списка пользователей необходимо авторизироваться');
            return $this->goHome();
        }

        $model = new UsersList();
        $model->name = Yii::$app->request->get('f-name');
        $model->email = Yii::$app->request->get('f-email');
        $model->limit = Yii::$app->request->post('page') ?? 1;
        $model->orderUsername(Yii::$app->request->get('o-un'));
        $model->orderEmail(Yii::$app->request->get('o-ea'));
        $model->orderCreatedAt(Yii::$app->request->get('o-ca'));
        $model->orderUpdatedAt(Yii::$app->request->get('o-ua'));

        if (Yii::$app->request->post('username') || Yii::$app->request->post('email') ||
            Yii::$app->request->post('created_at') || Yii::$app->request->post('updated_at') ||
            Yii::$app->request->post('UsersList')) {
            return $this->redirect(['index',
                'o-un' => Yii::$app->request->post('username'),
                'o-ea' => Yii::$app->request->post('email'),
                'o-ca' => Yii::$app->request->post('created_at'),
                'o-ua' => Yii::$app->request->post('updated_at'),
                'f-name' => Yii::$app->request->post('UsersList')['name'],
                'f-email' => Yii::$app->request->post('UsersList')['email'],
            ]);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
