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
	    $query = Post::find();
	    
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
	        'asc' => ['lookup.name' => SORT_ASC],
	        'desc' => ['lookup.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['author'] = [
	        'asc' => ['user.firstname' => SORT_ASC, 'user.lastname' => SORT_ASC],
	        'desc' => ['user.firstname' => SORT_DESC, 'user.lastname' => SORT_DESC],
        ];

	    if(!($this->load($params) && $this->validate())) {
		    $query->joinWith(['status', 'author']);
		    return $dataProvider;
	    }
	    
	    $query->andFilterWhere(['like', 'title', $this->title]);
		
		return $dataProvider;
    }
    
}
