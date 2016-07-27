<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "picture".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $path
 * @property string $description
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Picture extends \yii\db\ActiveRecord
{
    public $file;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'picture';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            ['name', 'trim'],
            ['name', 'string', 'max' => 32, 'min' => 4],
            [['path', 'description'], 'trim'],
            [['path', 'description'], 'string', 'max' => 512, 'min' => 4],
            ['file', 'file', 'skipOnEmpty' => true],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'created_at' => 'Дата добавления',
        ];
    }

    /**
     * @param Picture $picture
     * @return bool
     */
    public function updatePicture(Picture $picture)
    {
        if (!$picture->validate()) {
            return false;
        }

        $picture->user_id = Yii::$app->user->id;
        $picture->name = ($this->name != null) ? $this->name : 'Фото';
        $picture->path = $this->path;
        $picture->description = $this->description;

        return $picture->save() ? true : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id', 'user_id'])->where(['status' => self::STATUS_ACTIVE]);
    }

    /**
     * @return bool
     */
    public function deletePicture()
    {
        if (!$this->validate()){
            return false;
        }
        $this->status = self::STATUS_DELETED;
        unlink($this->path);
        $this->path = '--empty--';
        return $this->save() ? true : false;
    }
}
