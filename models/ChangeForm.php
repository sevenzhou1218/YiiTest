<?php
namespace app\models;

use yii\base\Model;
use yii\db\Expression;

class ChangeForm extends Model{
    public $oldPassword;
    public $password;
    public $rePassword;

    public function rules(){
        return [
            [['password','rePassword','oldPassword'],'required'],
            ['rePassword','compare','compareAttribute' => 'password']
        ];
    }

    public function  attributeLabels(){
        return [
            'oldPassword'=>'旧密码',
            'password'=>'新密码',
            'rePassword'=>'重复新密码'
        ];
    }

    public function check($id){
        if($this->validate()){
            $user = User::findOne($id);
            if($user && $user->password == md5($this->oldPassword)){
                $user->password = $this->password;
                $user->updatetime = new Expression('NOW()');
                if($user->save()){
                    return true;
                }
                return false;
            }else{
                $this->addError('oldPassword','error');
            }
            return false;

        }
        return false;
    }




}