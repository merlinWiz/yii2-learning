<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Media;

/**
 * MediaSearch represents the model behind the search form about `app\models\Media`.
 */
class MediaSearch extends Media
{
	public $category;
	public $user;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'user_id'], 'integer'],
            [['file_name', 'category', 'user'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Media::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
	            'defaultOrder' => [
		            'upload_time' => SORT_DESC,
	            ],
	        ],
	        'pagination' => ['defaultPageSize' => 5],
        ]);

		$query->joinWith(['category', 'user']);

        $dataProvider->sort->attributes['category'] = [
	        'asc' => ['media_category.title' => SORT_ASC],
	        'desc' => ['media_category.title' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['user'] = [
	        'asc' => ['user.username' => SORT_ASC],
	        'desc' => ['user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'file_name', $this->file_name])
        	->andFilterWhere(['like', 'media_category.id', $this->category])
        	->andFilterWhere(['like', 'user.id', $this->user]);

        return $dataProvider;
    }
}
