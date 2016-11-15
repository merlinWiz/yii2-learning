<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Media';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="media-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Upload Media', ['upload'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
	    'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'Изображение',
				'format' => 'html',
				'value' => function($model){return Html::img(Yii::getAlias('@uploads') . $model['src'], ['width' => '100px']);}
			],
			'user_id',
			'category_id',
			'file_name',
			['class' => 'yii\grid\ActionColumn'],
			],
    ]) ?>
<?php Pjax::end(); ?></div>
