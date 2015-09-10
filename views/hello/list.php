<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = '文章';
?>
<div class="content-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute'=>'ID'
            ]
        ],
        'tableOptions'=>['class' => 'table table-striped']
    ]); ?>

</div>
