<?php
/* *
 * User: Administrator
 * Date: 2015/7/29 10:11
 * */

namespace app\models;

use yii\base\Model;
//use app\models\User;
use yii\db\Expression;

class ResetForm extends Model{
    public $password;
    public $rePassword;
    public $verifyCode;


    public function rules(){
        return [
            [['password','rePassword','verifyCode'],'required'],
            ['rePassword','compare','compareAttribute' => 'password'],
            ['verifyCode', 'captcha']
        ];
    }


    public function resetPassword($id){
        $model = User::findOne($id);
        if($model){
            $model->password = $model->encrypt($this->password);
            $model->updatetime = new Expression('NOW()');
            if($model->save()) return true;
            return false;
        }
        return false;
    }




}