<?php

namespace app\modules\blog\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\blog\models\Post;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
	    $condition = ['id' => $id];
	    
	    if(Yii::$app->user->isGuest) {
		    $condition['status_code'] = [Post::STATUS_PUBLISHED];
	    }
	    
        if (($model = Post::findOne($condition)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelbySlug($slug)
    {
	    if(($model = Post::findOne(['slug' => $slug])) !== null)
	    {
		    return $model;
	    } else {
		    throw new NotFoundHttpException('The requested page does not exist.');
	    }
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id = null, $slug = null)
    {
	    if($slug){
	        return $this->render('view', [
	            'model' => $this->findModelbySlug($slug),
	        ]);
	    } elseif($id) {
	        return $this->render('view', [
	            'model' => $this->findModel($id),
	        ]);
	    } else {
		    throw new NotFoundHttpException('The requested page does not exist.');
	    }
    }

}
