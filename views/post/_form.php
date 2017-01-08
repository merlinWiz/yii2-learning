<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Lookup;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="post-form-wrap">
	
    <?php $form = ActiveForm::begin(['id' => 'post-form', 'options' => ['data-pjax' => true]]); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 1]) ?>
        
    <div class="permalink-box">
    	<strong>Постоянная ссылка: </strong><?= Html::tag('span', Url::to(['post/view', 'slug' => $model->slug], true), ['id' => 'permalink']) ?>
    </div>
    
	<?= $form->field($model, 'content')->widget(TinyMce::className(), [
	    'options' => ['rows' => 16],
	    'language' => 'ru',
	    'clientOptions' => [
	        'plugins' => [
	            "advlist autolink lists link code searchreplace insertdatetime contextmenu paste image pagebreak"
	        ],
	        'menubar' => false,
	        'toolbar' => "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | paste link image | pagebreak | code",
	        'image_dimensions' => false,
	        'file_browser_callback' => new JsExpression('mediaBrowser.init')
	    ]
	    
	]);?>
	
    <?= $form->field($model, 'status_code')->dropDownList(Lookup::items('PostStatus')) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php Modal::begin(['header' => '<h3>Media Browser</h3>', 'id' => 'mediaModal', 'size' => 'modal-lg']);?>
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
<!--
			<p>
				<?= Html::button('Добавить новую категорию', ['id' => 'show_add_new_category', 'class' => 'btn btn-primary']) ?>
			</p>
-->
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
	
	<div id="mediaGridPjax"></div>
<?php Modal::end(); ?>