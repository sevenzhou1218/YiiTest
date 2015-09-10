<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use dosamigos\ckeditor\CKEditor;

$this->title = '测试文本编辑器';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-change">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'test']); ?>
            <?/*= $form->field($model, 'post_content'); */?>
            <?= $form->field($model, 'post_title'); ?>
            <?= $form->field($model, 'post_content')->widget(CKEditor::className(), [
                'options' => ['rows' => 6],
                'preset' => 'basic'
            ]); ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
