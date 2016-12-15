<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\MediaCategory;
use app\models\User;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJsFile('@web/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'Media';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="media-index">

    <p>
        <?= Html::a('Upload Media', ['upload'], ['id' => 'mediaUploadButton', 'class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Delete Selected', ['batchDelete'], ['class' => 'btn', 'id' => 'batchMediaDelete']) ?>
    </p>
<?php Pjax::begin([
		'id' => 'mediaGridPjax',
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
				'buttons' => [
					'delete' => function($url, $model, $key){return Html::a(Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]), $url, ['class' => 'mediaDelete', 'title' => 'delete', 'aria-label' => 'delete', 'data' => ['pjax' => 'mediaGridPjax', 'method' => 'post', 'confirm' => 'Are you sure you want to delete this item?']]);},
				],
			],
		],
    ]) ?>
<?php Pjax::end(); ?>

</div>

<?php Modal::begin(['header' => '<h3>Media Upload</h3>', 'id' => 'mediaUploadModal', 'size' => 'modal-md']); Modal::end(); ?>
