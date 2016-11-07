<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Media */
/* @var $form ActiveForm */
?>
<div class="media-upload">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>
 
		<?= $form->field($model, 'category')->dropDownList($model->listUploadFolders()) ?>
		   
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- media-upload -->
