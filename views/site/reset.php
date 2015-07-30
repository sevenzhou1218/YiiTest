<?php
/* *
 * User: Administrator
 * Date: 2015/7/29 10:57
 * */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('attributes','Reset Password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to forget your password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-reset']); ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rePassword')->passwordInput() ?>
            <?= $form->field($model, 'verifyCode', [
                'options' => ['class' => 'form-group form-group-lg'],
            ])->widget(Captcha::className(),[
                'template' => "{input}{image}",
                'imageOptions' => ['alt' => '验证码'],
            ]); ?>
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'reset-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>