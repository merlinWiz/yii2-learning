<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Post;
use app\models\PostSearch;
use app\models\UploadForm;
use yii\web\Response;

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
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
	            'class' => AccessControl::className(),
	            'only' => ['manage', 'create', 'update', 'delete'],
	            'rules' => [
		            [
			            'allow' => true,
			            'roles' => ['@'],
		            ],
	            ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */

    public function actionManage()
    {	    		
		$searchModel = new PostSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		
        return $this->render('manage', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

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

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {
	    if($id){
		    $model = $this->findModel($id);
	    } else {
	        $model = new Post();
	    }
	    
	    $request = Yii::$app->request;
		$post = $request->post();
		$uploadModel = new UploadForm();
		
	    if ($model->load($post) && $model->save()) {
	    	return $this->redirect(['update',
	            'id' => $model->id,
	        ]);
	    } else {
	        return $this->render('create', [
	            'model' => $model,
	            'uploadModel' => $uploadModel,
	        ]);
	    }
	}
    
    public function actionSaveDraft($id = null)
    {
	    $request = Yii::$app->request;
	    
	    if($request->isAjax && $request->isPost){
		    if($id){
		    	$model = $this->findModel($id);
		    } else {
		        $model = new Post();
		    }
	        $model->load($request->post());
	        $model->status_code = 1;
	        	        
	        Yii::$app->response->format = Response::FORMAT_JSON;
	        
	        if($model->save()){
		        return ['status' => 'success', 'postID' => $model->id];
	        } else {
		        return ['status' => 'error'];
	        }
	        
	    }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$uploadModel = new UploadForm();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	return $this->refresh();
        } else {
            return $this->render('update', [
                'model' => $model,
                'uploadModel' => $uploadModel,
            ]);
        }
    }


    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'blog admin index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['manage']);
    }

}
