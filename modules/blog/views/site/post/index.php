<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//             'id',
//             'author_id',
            'title:ntext',
            'content:ntext',
            [
	            'attribute' => 'author',
	            'value' => 'author.username'
            ],
            [
	            'attribute' => 'status',
	            'value' => 'status.name'
            ],

//             'status',
            'update_time',
            'create_time',

        ],
    ]); ?>

</div>
