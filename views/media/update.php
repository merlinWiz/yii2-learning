<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Media */

$this->title = 'Media: ' . $model->file_name;
$this->params['breadcrumbs'][] = ['label' => 'Media', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->file_name;
?>
<div class="media-update">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?= Html::img($model->getMediaThumbnailURI('800x600'), ['alt' => $model->file_name]) ?>

    <h2>Прямая ссылка:</h2>
    <?= Html::a($model->getMediaURI(), $model->getMediaURI()) ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
