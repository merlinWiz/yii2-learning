<?php

use yii\helpers\Html;
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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Upload Media', ['upload'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Delete Selected', ['batchDelete'], ['class' => 'btn', 'id' => 'batchMediaDelete']) ?>
    </p>
<?php Pjax::begin([
		'id' => 'mediaGridPjax',
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
				'format' => 'html',
				'value' => function($model){ return Html::img($model->getMediaThumbnailURI());}
			],
			'file_name',
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
			['class' => 'yii\grid\ActionColumn'],
			],
    ]) ?>
<?php Pjax::end(); ?></div>
