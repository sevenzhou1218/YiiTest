<?php
namespace app\models;

use yii\base\Model;
use yii\db\Expression;

class ForgetForm extends Model{
    public $username;
    public $email;

    public function rules(){
        return [
            [['username','email'],'required'],
            ['email','email']
        ];
    }

    public function  attributeLabels(){
        return [
            'username'=>\Yii::t('attributes','Username'),
            'email'=>\Yii::t('attributes','Email')
        ];
    }

    public function check(){
        $user = User::find()->where(['username'=>$this->username,'email'=>$this->email])->one();
        if($user === null){
            $this->addError('username',\Yii::t('attributes','Username Or Email Incorrect'));
        }else{
            return $user;
        }
        return false;
    }



}