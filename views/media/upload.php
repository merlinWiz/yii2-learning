<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Media */
/* @var $form ActiveForm */

$this->registerJsFile('@web/js/media-category.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>


<div class="media-upload">
<?php Pjax::begin(['id' => 'mediaUploadPjax', 'enablePushState' => false]) ?>
    <?php $form = ActiveForm::begin(['options' => ['id' => 'mediaUploadForm', 'enctype' => 'multipart/form-data', 'data-pjax' => true]]); ?>
		<?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>
 
		<?= $form->field($model, 'category_id')->dropDownList($model->listMediaCategories(), [ 'prompt' => 'Не выбрано']) ?>
		
		<?= Html::button('Добавить новую категорию', ['id' => 'show_add_new_category', 'class' => 'btn btn-primary']) ?>
		<p id="category_add">
			<?= Html::textInput('added_category_title') ?>
			<?= Html::dropDownList('added_category_parent', null, $model->listMediaCategories(), [ 'prompt' => 'Родительская категория']) ?>
			<?= Html::button('Добавить', ['id' => 'add_new_category', 'class' => 'btn btn-success']) ?>
		</p>   
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'id' => 'mediaUploadSubmit']) ?>
        </div>
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
</div><!-- media-upload -->
