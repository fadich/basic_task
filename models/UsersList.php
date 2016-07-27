<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class UsersList extends Model
{
    public $name;
    public $email;
    public $order;
    public $iconUsername;
    public $iconEmail;
    public $iconCreatedAt;
    public $iconUpdatedAt;
    public $limit;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя пользователя',
            'email' => 'Адрес электронной почты',
        ];
    }

    /**
     * Выбор всех записей с фильтрацией и сортировкой
     * @return array
     */
    public function getUsers()
    {
        $params = [
            'status' => User::STATUS_ACTIVE,
        ];

        $order = $this->order ?? ['username'];
        return Yii::$app->db->createCommand('SELECT id, username, email, created_at, updated_at FROM user ' .
            'where status = :status and id != '. Yii::$app->user->id .
            ' and username like "%' . $this->name . '%" and email like "%' . $this->email . '%" ' .
            'order by ' . implode($order) . ' limit ' . ($this->limit - 1) * 25 . ', 25')
            ->bindValues($params)
            ->queryAll();
    }

    /**
     * Вариант 2
     */
//    public function getUsers()
//    {
//        $order = $this->order ?? ['username'];
//        return User::find()->where(['status' => User::STATUS_ACTIVE,])
//            ->filterWhere(['like', 'username', '%' . $this->name . '%', false])
//            ->filterWhere(['like', 'email', '%' . $this->email . '%', false])
//            ->orderBy(implode($order))->all();
//    }

    public function orderUsername($value)
    {
        switch ($value) {
            case null:
                $this->order['username'] = 'username';
                $this->iconUsername = ' <span class="glyphicon glyphicon-chevron-up"></span>';
                break;
            case 'username':
                $this->order['username'] = 'username desc';
                $this->iconUsername = ' <span class="glyphicon glyphicon-chevron-down"></span>';
                break;
            case 'username desc':
                $this->order = null;
                $this->iconUsername = null;
                break;
        }
    }

    public function orderEmail($value)
    {
        switch ($value) {
            case null:
                $this->order['email'] = 'email';
                $this->iconEmail = ' <span class="glyphicon glyphicon-chevron-up"></span>';
                break;
            case 'email':
                $this->order['email'] = 'email desc';
                $this->iconEmail = ' <span class="glyphicon glyphicon-chevron-down"></span>';
                break;
            case 'email desc':
                $this->order = null;
                $this->iconEmail = null;
                break;
        }
    }

    public function orderCreatedAt($value)
    {
        switch ($value) {
            case null:
                $this->order['created_at'] = 'created_at';
                $this->iconCreatedAt = ' <span class="glyphicon glyphicon-chevron-up"></span>';
                break;
            case 'created_at':
                $this->order['created_at'] = 'created_at desc';
                $this->iconCreatedAt = ' <span class="glyphicon glyphicon-chevron-down"></span>';
                break;
            case 'created_at desc':
                $this->order = null;
                $this->iconCreatedAt = null;
                break;
        }
    }

    public function orderUpdatedAt($value)
    {
        switch ($value) {
            case null:
                $this->order['updated_at'] = 'updated_at';
                $this->iconUpdatedAt = ' <span class="glyphicon glyphicon-chevron-up"></span>';
                break;
            case 'updated_at':
                $this->order['updated_at'] = 'updated_at desc';
                $this->iconUpdatedAt = ' <span class="glyphicon glyphicon-chevron-down"></span>';
                break;
            case 'updated_at desc':
                $this->order = null;
                $this->iconUpdatedAt = null;
                break;
        }
    }

    public function getSize()
    {
        $params = [
            'status' => User::STATUS_ACTIVE,
        ];
        return Yii::$app->db->createCommand('SELECT count(id) FROM user ' .
            'where status = :status and username like "%' . $this->name . '%" and email like "%' . $this->email . '%" ')
            ->bindValues($params)
            ->queryScalar();
    }
}