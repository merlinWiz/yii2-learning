<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MediaCategory */

$this->title = 'Create Media Category';
$this->params['breadcrumbs'][] = ['label' => 'Media Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="media-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
