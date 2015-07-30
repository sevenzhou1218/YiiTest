<?php

namespace app\controllers;


use app\models\ResetForm;
use app\models\User;
use app\models\UserForgetInfo;
use Yii;
//use yii\base\Exception;
use yii\web\HttpException;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;
use app\components\Main2;
use app\models\ChangeForm;
use app\models\ForgetForm;
use app\models\RegisterForm;
use app\components\ActionTimeFilter;


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
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin(){
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
        echo Yii::$app->language;
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
            }
        }

        return $this->render('forget',[
            'model'=>$model
        ]);
    }

    public function actionReset(){
        $model = UserForgetInfo::find()->where('random=:r',[':r'=>Yii::$app->request->get('_')])->one();

        if($model === null) throw new NotFoundHttpException('请求的页面不存在.');

        $time = time()- $model->expiredtime;
        if($time > Main2::EXPIRED_TIME) {
            throw new HttpException('200','已经过期');
            //return $this->render('expired');
        }

        $resetModel = new ResetForm();
        if ($resetModel->load(Yii::$app->request->post())){
            if($resetModel->resetPassword($model->uid)){
                //TODO
                echo 'd';
            }else{
                echo 'f';
            }
        }

        return $this->render('reset',[
            'model'=>$resetModel
        ]);

        //$user = User::findOne($model->uid);
        //$user->resetPassword();

        //$user->setScenario('ddd');
        //$user = new User();
        //print_r($user->getScenario());
        //$user->password = md5('seven');
        //$user->updatetime = new Expression('NOW()');
        //echo md5('seven');
        //$user->save();
        //print_r($user->errors);
        //print_r(Yii::$app->params['adminEmail']);
    }



}
