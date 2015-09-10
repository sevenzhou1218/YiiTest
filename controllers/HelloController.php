<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Content;
use dosamigos\ckeditor\CKEditor;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;


class HelloController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'=>true,
                        'roles'=>['@']
                    ]
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }



    public function actionIndex()
    {
        //print_r(CKEditor::className());
        //print_r(Yii::$classMap['yii\web\Controller']);
        $model = new Content();

        //print_r(Yii::$app->request->post());

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post())){
            if($model->save()){
                //TODO
                echo '成功';
            }
        }


        return $this->render('index',[
            'model'=>$model
        ]);
    }



    public function actionList(){
        $dataProvider = new ActiveDataProvider([
            'query' => Content::find(),
            'pagination' => [
                'pageSize' => 2,
            ]
        ]);


        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);

    }

}
