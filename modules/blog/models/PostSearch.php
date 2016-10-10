<?php

namespace app\modules\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostSearch extends Post
{
	
    public function rules()
    {
        return [
	        [['id'], 'integer'],
            [['title'], 'safe'],
        ];
    }
    
    public function scenarios()
    {
	    return Model::scenarios();
    }
    
    public function search($params)
    {
	    $query = Post::find()->where(['not', ['status_code' => Post::STATUS_DELETED]]);
	    
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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

	    if(!($this->load($params) && $this->validate())) {
		    return $dataProvider;
	    }
	    
	    $query->andFilterWhere(['like', 'title', $this->title]);
		
		return $dataProvider;
    }
    
}
