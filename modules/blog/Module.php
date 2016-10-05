<?php

namespace app\modules\blog;

class Module extends \yii\base\Module
{
	public function init()
	{
		parent::init();
	}
	
	public $defaultRoute = 'post';
}