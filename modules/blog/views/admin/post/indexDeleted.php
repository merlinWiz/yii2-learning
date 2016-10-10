<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post manager';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Clear deleted', ['final-delete-all'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?php Pjax::begin(); ?>

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
            'update_time',
            'create_time',

            [
            	'class' => 'yii\grid\ActionColumn', 
            	'template' => '{delete} {restore}',
            	'buttons' => [
	            	'restore' => function($url, $model, $key) {
		            	return Html::a('<span class="glyphicon glyphicon-repeat"></span>', $url);
	            	},
	            	'delete' => function($url, $model, $key) {
		            	return Html::a('<span class="glyphicon glyphicon-remove"></span>', Url::to(['admin/post/final-delete', 'id' => $model->id]));
	            	},
            	],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
