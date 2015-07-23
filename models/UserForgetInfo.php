<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_forget_info".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $expiredtime
 * @property string $random
 * @property string $createtime
 */
class UserForgetInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_forget_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid'], 'integer'],
            [['createtime'], 'safe'],
            ['random', 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'expiredtime' => 'Expiredtime',
            'random' => 'Random',
            'createtime' => 'Createtime',
        ];
    }
}
