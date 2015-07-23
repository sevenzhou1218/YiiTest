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
            'username'=>'账号名',
            'email'=>'邮箱'
        ];
    }

    public function check(){
        $user = User::find()->where(['username'=>$this->username,'email'=>$this->email])->one();
        if($user === null){
            $this->addError('username','账号或邮箱不正确');
        }else{
            return $user;
        }
        return false;
    }



}