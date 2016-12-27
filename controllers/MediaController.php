<?php

namespace app\controllers;

use Yii;
use app\models\Media;
use app\models\MediaSearch;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * MediaController implements the CRUD actions for Media model.
 */
class MediaController extends Controller
{
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
                    'batchDelete' => ['POST'],
                ],
            ],
            'access' => [
	            'class' => AccessControl::className(),
	            'only' => ['index', 'create', 'update', 'delete', 'batchDelete', 'upload'],
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
     * Lists all Media models.
     * @return mixed
     */
    public function actionIndex()
    {
		$request = Yii::$app->request;
        $uploadModel = new UploadForm();
        $searchModel = new MediaSearch();
        $dataProvider = $searchModel->search($request->queryParams);
		
	    return $this->render('index', [
		    'uploadModel' => $uploadModel,
	        'searchModel' => $searchModel,
	        'dataProvider' => $dataProvider,
	    ]);
		
    }

    public function actionIndexModal()
    {
		$request = Yii::$app->request;
        $searchModel = new MediaSearch();
        $dataProvider = $searchModel->search($request->queryParams);
		
		if($request->isAjax){
		    return $this->renderAjax('indexModal', [
		        'searchModel' => $searchModel,
		        'dataProvider' => $dataProvider,
		    ]);
		}		

    }

    /**
     * Displays a single Media model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	public function actionUpload()
	{
		$request = Yii::$app->request;
	    $model = new UploadForm();
		Yii::$app->response->format = Response::FORMAT_JSON;
		
	    if ($request->isAjax && $model->load($request->post())) {
		    $model->files = UploadedFile::getInstances($model, 'files');			

			if($model->upload()){
				return ['status' => 'success', 'errors' => $model->getErrors()];
			} else {
				return ActiveForm::validate($model);
			}
			
	    } else {
		    return ['status' => 'errors', 'errors' => $model->getErrors(), 'post' => $request->post()];
	    }
	
	}
	
    /**
     * Updates an existing Media model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Media model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$this->deleteModel($id);
		
		$request = Yii::$app->request;
        $searchModel = new MediaSearch();
        $dataProvider = $searchModel->search($request->queryParams);
		$uploadModel = new UploadForm();
		
	    return $this->render('index', [
	        'searchModel' => $searchModel,
	        'dataProvider' => $dataProvider,
	        'uploadModel' => $uploadModel,
	    ]);

    }

    public function actionDeleteModal($id)
    {
		$this->deleteModel($id);
		
		$request = Yii::$app->request;
        $searchModel = new MediaSearch();
        $dataProvider = $searchModel->search($request->queryParams);
		
		if($request->isAjax){
		    return $this->renderAjax('indexModal', [
		        'searchModel' => $searchModel,
		        'dataProvider' => $dataProvider,
		    ]);
		}		

    }

	public function actionBatchDelete()
	{
		$request = Yii::$app->request;
		if ($request->isAjax && $request->isPost) {
			$data = $request->post();
			$keys = $data['keys'];
		    if ($keys) {
		        if (!is_array($keys)) {
		            echo Json::encode([
		                'status' => 'error',
		            ]);
		            return;
		        }
		        foreach ($keys as $id) {
			        $this->deleteModel($id);
		        }
		        echo Json::encode([
		            'status' => 'success',
		        ]);
		    } else {
			    echo Json::encode([
			        'status' => 'error',
			    ]);
		    }
		}	    

	}
	
	protected function deleteModel($id)
	{
	    $model = $this->findModel($id);
	    
	    $model->deleteMedia();
	    $model->delete();
	}
	
    /**
     * Finds the Media model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Media the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Media::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
