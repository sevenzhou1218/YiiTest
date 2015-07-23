<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Forget Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-change">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to forget your password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-change']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
