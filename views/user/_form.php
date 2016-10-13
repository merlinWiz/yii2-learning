<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
	<div class="col-lg-5">

		<div class="user-form>
		
		    <?php $form = ActiveForm::begin(); ?>
		
		    <?php if($this->context->action->id == 'create') {
			    
			    echo $form->field($model, 'username')->textInput(['maxlength' => true]);
			    echo $form->field($model, 'password')->passwordInput(['maxlength' => true]);			    
			    
		    }
		    ?>
		    
		    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
		
		    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
		
		    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
		
		    <div class="form-group">
		        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>
		
		    <?php ActiveForm::end(); ?>
		
		</div>
	</div>
</div>
