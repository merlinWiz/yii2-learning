<?php

namespace app\modules\blog\controllers\site;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\modules\blog\models\Post;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends \app\modules\blog\controllers\PostController
{
    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {	    
		$condition['status_code'] = [Post::STATUS_PUBLISHED];
		
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where($condition)->orderBy('update_time'),
            'pagination' => [
	            'pagesize' => 5,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
