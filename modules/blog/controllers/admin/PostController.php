<?php

namespace app\modules\blog\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\modules\blog\models\Post;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends \app\modules\blog\controllers\PostController
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
                ],
            ],
            'access' => [
	            'class' => AccessControl::className(),
	            'only' => ['index', 'create', 'update', 'delete'],
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

    public function actionIndex()
    {	    		
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['not', ['status_code' => Post::STATUS_DELETED]]),
            'sort' => [
	            'defaultOrder' => [
		            'id' => SORT_DESC,
	            ],
            ],
            'pagination' => [
	            'pagesize' => 5,
            ],
        ]);
        
        $dataProvider->sort->attributes['status'] = [
	        'asc' => ['status_code' => SORT_ASC],
	        'desc' => ['status_code' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['author'] = [
	        'asc' => ['author_id' => SORT_ASC],
	        'desc' => ['author_id' => SORT_DESC],
        ];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexDeleted()
    {	    		
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['status_code' => Post::STATUS_DELETED]),
            'sort' => [
	            'defaultOrder' => [
		            'id' => SORT_DESC,
	            ],
            ],
            'pagination' => [
	            'pagesize' => 5,
            ],
        ]);

        $dataProvider->sort->attributes['author'] = [
	        'asc' => ['author_id' => SORT_ASC],
	        'desc' => ['author_id' => SORT_DESC],
        ];

        return $this->render('indexDeleted', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
	    $model = $this->findModel($id);
	    $model->status_code = Post::STATUS_DELETED;
	    $model->save();
	    
	    return $this->redirect(['admin/post']);
    }


    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'blog admin index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionFinalDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin/post']);
    }
    
}
