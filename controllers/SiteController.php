<?php

namespace app\controllers;

use app\models\ChangeForm;
use app\models\ForgetForm;
use app\models\RegisterForm;

//use app\models\User;
use app\models\User;
use app\models\UserForgetInfo;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
//use app\components\Main2;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
//use yii\jui\DatePicker;
use app\components\ActionTimeFilter;
use yii\web\HttpException;

//use yii\swiftmailer\Mailer;

class SiteController extends Controller
{
    //public $defaultAction = 'login';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','change','register','login'],
                'rules' => [
                    [
                        'actions' => ['logout','change'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions'=>['register','login'],
                        'allow'=>true,
                        'roles'=>['?']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'seven'=>[
                'class' => ActionTimeFilter::className(),
                'only'=>['index']
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength'=>5,
                'minLength'=>5,
                'offset'=>2
            ],
            /*
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 5,
                'minLength' => 5
            ],
            */
        ];
    }

    public function actionIndex()
    {
        //Yii::trace("Action spent  second.");

        //Yii::info('dddddddddddddddddd');
        //var_dump(Yii::$app->user->id);
        //var_dump(Yii::$app->security->generateRandomString());
        //print_r(Yii::$app->getUser());
        //var_dump(Main2::getIP());
        /*
        var_dump(Yii::$app->request->userIP);
        $request = Yii::$app->request;
        $params = $request->bodyParams;
        print_r($params);
        print_r($request->get());
            */
        /*
        echo DatePicker::widget([
                'language' => 'zh-CN',
                'name'  => 'country',
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' => [
                    'dateFormat' => 'yy-mm-dd',
                ],

        ]);
        */
        //$model = new \app\models\User();
        //print_r($model->attributes);
        //print_r(Yii::$app->mailer);
        /*
        try{
            $mail = Yii::$app->mailer->compose();
            $mail->setTo('370500790@qq.com');
            $mail->setSubject("邮件测试");
            //$mail->setTextBody('zheshisha ');   //发布纯文字文本
            $mail->setHtmlBody("<br>问我我我我我");    //发布可以带html标签的文本
            if ($mail->send())
                echo "success";
            else
                echo "failse";
        }catch(Exception $e){
            print_r($e);
        }
        */
        print_r(Yii::$app->request->get());
        return $this->render('index');
    }

    public function actionLogin(){
        /*
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        */
        /*
        $model = new TbUser();
        if(isset($_POST['LoginForm'])){
            $model->attributes = $_POST['LoginForm'];
            if($model->validate() && $model->login()){
                return $this->goBack();
            }else{
                return $this->render('login', [
                    'model' => $model
                ]);
            }
        }
        */

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            //print_r(Yii::$app->request->post());
            return $this->render('login', [
                'model' => $model,
            ]);
        }

    }

    public function actionRegister(){
        /*
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        */
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->register()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }


    /*
     * 更改密码
     */
    public function actionChange(){
        //$model = User::findOne(Yii::$app->user->id);
        //print_r($model);
        $model = new ChangeForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->check(Yii::$app->user->id)) {
                return $this->goHome();
            }
        }
        return $this->render('change',[
            'model'=>$model
        ]);
    }

    /*
     * 忘记密码
     */
    public function actionForgetPassword(){
        $model = new ForgetForm();

        if ($model->load(Yii::$app->request->post())) {
            //print_r(Yii::$app->request->post('ForgetForm'));
            if($user = $model->check()){
                $emailModel = new UserForgetInfo();
                $emailModel->uid = $user->id;
                $emailModel->expiredtime = time();//new Expression('NOW()');
                $emailModel->random = Yii::$app->security->generateRandomString();
                $emailModel->createtime = new Expression('NOW()');

                if($emailModel->save()){
                    $mail = Yii::$app->mailer->compose('seven',['user'=>$user,'model'=>$emailModel]);
                    $mail->setTo($user->email);
                    $mail->setSubject('找回密码');
                    //$mail->setHtmlBody("亲爱的用户:". $user->username . "您好!<br>"."");
                    if($mail->send()){
                        Yii::$app->session->setFlash('sendEmailSuccess','发送成功');
                    }
                }

                /*$mail = Yii::$app->mailer->compose();
                $mail->setTo('370500790@qq.com');
                $mail->setSubject("邮件测试");
                //$mail->setTextBody('zheshisha ');   //发布纯文字文本
                $mail->setHtmlBody("<br>问我我我我我");    //发布可以带html标签的文本
                if ($mail->send())
                    echo "success";
                else
                    echo "failse";*/

            }
        }

        return $this->render('forget',[
            'model'=>$model
        ]);
    }

    public function actionReset(){
        $model = UserForgetInfo::find()->where('random=:r',[':r'=>Yii::$app->request->get('_')])->one();
        if($model === null) throw new HttpException('404','没找到');
        //var_dump($model);

        $time = time()- $model->expiredtime;
        if($time > 86400) throw new HttpException('404','没找到');






    }



}
