<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\MediaCategory;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJsFile('@web/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'Media';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="media-index">

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
	            'attribute' => 'user',
	            'label' => 'Пользователь',
	            'value' => 'user.username',
	            'filter' => User::users()
            ],
            [
	            'attribute' => 'category',
	            'label' => 'Категория',
	            'value' => 'category.title',
	            'filter' => MediaCategory::itemsTree()
            ],
            'upload_time',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
			],
		],
    ]) ?>
<?php Pjax::end(); ?>

</div>

