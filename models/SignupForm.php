<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rePassword;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'max' => 32, 'min' => 4],
            ['username', 'unique', 'targetClass' => '\app\models\User',
                'message' => 'Извините, данное имя пользователя уже занято.'],

            ['verifyCode', 'trim'],
            ['verifyCode', 'captcha'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255, 'min' => 6],
            ['email', 'unique', 'targetClass' => '\app\models\User',
                'message' => 'Извините, данный адрес уже занят.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['rePassword', 'required'],
            ['rePassword', 'validateRePassword'],
        ];
    }

    public function validateRePassword($attribute)
    {
        if (!$this->hasErrors()):
            if ($this->password !== $this->rePassword):
                $this->addError($attribute, 'Пароли не совпадают.');
            endif;
        endif;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Адрес электронной почты',
            'password' => 'Пароль',
            'rePassword' => 'Повторите пароль',
            'verifyCode' => 'Проверочный код',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
