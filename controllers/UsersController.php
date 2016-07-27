<?php

namespace app\controllers;

use app\models\Picture;
use app\models\UsersList;
use Yii;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class UsersController extends \yii\web\Controller
{

//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['index', 'profile'],
//                'rules' => [
//                    [
//                        'actions' => ['index', 'profile'],
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
            Yii::$app->session->setFlash('error', 'Для просмотра пользователей необходимо авторизироваться.');
            return $this->goHome();
        }

        $model = new UsersList();
        $model->name = Yii::$app->request->get('f-name');
        $model->email = Yii::$app->request->get('f-email');
        $model->limit = Yii::$app->request->post('page') ?? 1;
        if (isset($_GET['o-un'])) {
            $model->orderUsername(Yii::$app->request->get('o-un'));
        }
        if (isset($_GET['o-ea'])) {
            $model->orderEmail(Yii::$app->request->get('o-ea'));
        }
        if (isset($_GET['o-ca'])) {
            $model->orderCreatedAt(Yii::$app->request->get('o-ca'));
        }
        if (isset($_GET['o-ua'])) {
            $model->orderUpdatedAt(Yii::$app->request->get('o-ua'));
        }

        if (Yii::$app->request->post('username') || Yii::$app->request->post('email') ||
            Yii::$app->request->post('created_at') || Yii::$app->request->post('updated_at') ||
            Yii::$app->request->post('UsersList')
        ) {
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

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Для просмотра профиля пользователя необходимо авторизироваться.');
            return $this->goHome();
        }

        $model = ($model = User::findOne(Yii::$app->request->get('id'))) ? $model : new User();

        if (!isset($_GET['id'])) {
            $model = ($model = User::findOne(Yii::$app->user->id)) ? $model : new User();
        }

        if (!$model->id) {
            Yii::$app->session->setFlash('error', 'Пользователь не найден.');
            return $this->redirect('index');
        }

        $picture = new Picture();
        if ($picture->load(Yii::$app->request->post())) {
            $picture->file = UploadedFile::getInstance($picture, 'file');
            if ($picture->validate() && $picture->file != null) {
                if (isset($picture->file)) {
                    if ($picture->file->extension != 'png' && $picture->file->extension != 'gif' &&
                        $picture->file->extension != 'jpg' && $picture->file->extension != 'jpeg'
                    ) {
                        Yii::$app->session->setFlash('photo', 'Файл должен иметь расширение *.png, *.gif,' .
                            '*.jpg или *.jpeg .');
                    } else {
                        $picture->file->saveAs('uploads/pictures/photo' .
                            str_replace('\'', '', (str_replace('"', '', str_replace(' ', '_', $model->username)))) .
                            time() . '.' . $picture->file->extension);
                        $picture->path = 'uploads/pictures/photo' .
                            str_replace('\'', '', (str_replace('"', '', str_replace(' ', '_', $model->username)))) .
                            time() . '.' . $picture->file->extension;
                        $picture->updatePicture($picture);
                        Yii::$app->session->setFlash('photo', 'Новое фото успешно добавлено.');
                    }
                }
            } else {
                Yii::$app->session->setFlash('photo',
                    'Новое фото не может быть добавлено.<br>' .
                    '<span style="font-size: 12px;">Проверьте правильность заполнения полей.</span>');
            }
        }

        $model->createdAt = date('d.m.Y H:i:s', $model->created_at);
        $model->updatedAt = date('d.m.Y H:i:s', $model->updated_at);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->updateUser($model)) {
                Yii::$app->session->setFlash('profile', 'Редактирование произведено успешно.');
            }
        }

        if (Yii::$app->request->post('delete')) {
            $pictureToDelete = ($pictureToDelete = Picture::findOne((int)Yii::$app->request->post('delete'))) ?
                $pictureToDelete : new Picture();
            ($pictureToDelete->deletePicture()) ? Yii::$app->session->setFlash('photo', 'Фото успешно удалено.') :
                Yii::$app->session->setFlash('photo', 'Ошибка удаления фото.');
        }

        return $this->render('profile', [
            'model' => $model,
            'picture' => $picture
        ]);
    }
}
