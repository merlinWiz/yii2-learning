<?php

namespace app\components;

use Yii;
use yii\base\Component;

class Aliases extends Component
{
	public function init()
	{
		Yii::setAlias('@uploads', '@web/uploads/');
		Yii::setAlias('@uploadsPath', '@webroot/uploads/');
	}
}
	

