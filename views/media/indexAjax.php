<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\MediaCategory;
use app\models\User;
?>
    <p>
        <?= Html::a('Upload Media', ['upload'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Delete Selected', ['batchDelete'], ['class' => 'btn', 'id' => 'batchMediaDelete']) ?>
    </p>
<?php Pjax::begin([
		'id' => 'mediaGridPjax',
		'enablePushState' => false,
		'timeout' => 3000,
	]); ?>
<?= GridView::widget([
		'id' => 'mediaGrid',
        'dataProvider' => $dataProvider,
	    'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\CheckboxColumn'],
			[
				'attribute' => 'preview',
				'label' => 'Превью',
				'format' => 'raw',
				'value' => function($model){ return Html::a(Html::img($model->getMediaThumbnailURI('100x100')), Url::to(['media/update', 'id' => $model->id]), ['target' => '_blank', 'data' => [ 'pjax' => 0]]);}
			],
			[
				'attribute' => 'file_name',
				'format' => 'raw',
				'value' => function($model){ return Html::a($model->file_name, Url::to(['media/update', 'id' => $model->id]), ['target' => '_blank', 'data' => ['pjax' => 0]]);},
			],
            [
	            'attribute' => 'category',
	            'label' => 'Категория',
	            'value' => 'category.title',
	            'filter' => MediaCategory::itemsTree()
            ],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{select} {delete}',
				'buttons' => [
					'select' => function($url, $model, $key){ return Html::a(Html::tag('span', '', ['class' => "glyphicon glyphicon-plus"]), $model->getMediaURI(), ['class' => 'media_src', 'data' => ['pjax' => 0]]);},
				]
			],
		],
    ]) ?>
<?php Pjax::end(); ?>
