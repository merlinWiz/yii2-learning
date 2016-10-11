<?php
	
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;
		
		$manageUser = $auth->createPermission('manageUser');
		$manageUser->description = 'Manage a user';
		$auth->add($manageUser);
				
		$admin = $auth->createRole('admin');
		$auth->add($admin);
		$auth->addChild($admin, $manageUser);
		
        $auth->assign($admin, 1);
        
    }
}