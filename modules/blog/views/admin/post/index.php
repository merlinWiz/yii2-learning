<?php

use yii\helpers\Html;
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
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <p>
        <?= Html::a('View deleted', ['index-deleted'], ['class' => 'btn btn-default']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//             'id',
//             'author_id',
            [
	            'attribute' => 'title',
	            'filterInputOptions' => [
		            'class' => 'form-control',
		        	'placeholder' => 'Поиск по названию...',    
	            ], 
            ],
            'content:ntext',
            [
	            'attribute' => 'author',
	            'value' => 'author.username'
            ],
            [
	            'attribute' => 'status',
	            'value' => 'status.name'
            ],
            'update_time',
            'create_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
