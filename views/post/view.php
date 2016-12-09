<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blog', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//             'id',
            [
            	'label' => 'Author',
            	'value' => $model->author->username,
            ],
            'title:ntext',
            [
				'label' => 'Status',
				'value' => $model->status->name,	            
            ],
            'update_time',
            'create_time',
        ],
    ]) ?>

	<p class="post-content">
		<?= $model->content ?>
	</p>

</div>
