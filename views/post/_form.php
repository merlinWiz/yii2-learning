<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Lookup;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap\Modal;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 1]) ?>

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
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php Modal::begin(['header' => '<h3>Media Browser</h3>', 'id' => 'mediaModal', 'size' => 'modal-lg']); Modal::end(); ?>