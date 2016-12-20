<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\MediaCategory;
use app\models\User;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJsFile('@web/js/main.js', ['depends' => [JqueryAsset::className()]]);
$this->registerJsFile('@web/js/media-category.js', ['depends' => [JqueryAsset::className()]]);

$this->title = 'Media';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="media-index">

    <p>
        <?= Html::a('Добавить файл', ['upload'], ['id' => 'mediaUploadButton', 'class' => 'btn btn-primary']) ?>
    </p>
    
	<div class="media-upload" id="mediaUploadContainer" style="display: none;">
	    <?php $form = ActiveForm::begin([
		    'action' => ['media/upload'],
		    'options' => [
		    	'id' => 'mediaUploadForm', 
		    	'enctype' => 'multipart/form-data',
		    	]
		    ]); ?>
			<?= $form->field($uploadModel, 'files[]')->fileInput(['id' => 'mediaInput', 'multiple' => true]) ?>
	 
			<?= $form->field($uploadModel, 'category_id', ['enableAjaxValidation' => true])->dropDownList($uploadModel->listMediaCategories(), [ 'prompt' => 'Не выбрано']) ?>
			<p>
				<?= Html::button('Добавить новую категорию', ['id' => 'show_add_new_category', 'class' => 'btn btn-primary']) ?>
			</p>
			<p id="category_add" style="display: none;">
				<?= Html::textInput('added_category_title') ?>
				<?= Html::dropDownList('added_category_parent', null, $uploadModel->listMediaCategories(), [ 'prompt' => 'Родительская категория']) ?>
				<?= Html::button('Добавить', ['id' => 'add_new_category', 'class' => 'btn btn-success']) ?>
			</p>   
	        <div class="form-group">
	            <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success', 'id' => 'mediaUploadSubmit']) ?>
	        </div>
	    <?php ActiveForm::end(); ?>
	</div><!-- media-upload -->
    
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
