<?php

namespace app\controllers;

use app\models\RegisterForm;

use Yii;
use yii\filters\AccessControl;
use app\components\Main2;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class HelloController extends Controller
{
    

    public function actionIndex()
    {
       echo 'Hello World';
    }

    
}
