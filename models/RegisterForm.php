<?php
namespace app\models;

use yii\base\Model;
use yii\db\Expression;

class RegisterForm extends Model{
    public $username;
    public $password;
    public $repassword;
    public $verifyCode;
    public $email;


    public function rules(){
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username','validateUsernameUnique'],
            [['password','repassword','email','username','verifyCode'],'required'],
            ['repassword','compare','compareAttribute' => 'password'],
            ['verifyCode', 'captcha'],
            ['email','email'],
            ['username', 'string', 'max' => 20],
            ['password', 'string', 'max' => 32],
            ['email', 'string', 'max' => 50]
        ];
    }

    public function register(){
        if($this->validate()){
            $user = new User();
            //$user->innerid = new Expression('UPPER(UUID())');
            $user->username = $this->username;
            $user->password = $this->password;
            $user->email = $this->email;
            $user->authkey = \Yii::$app->security->generateRandomString();
            $user->createtime = new Expression('NOW()');
            if($user->save()){
                return $user;
            }
        }
        return null;
    }


    /* *
     * 验证账户名唯一
     * */
    public function validateUsernameUnique()
    {
        $user = User::findByUsername($this->username);
        if($user){
            $this->addError('username', 'Username must be unique.');
        }
    }

}