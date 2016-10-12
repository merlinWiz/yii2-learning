<?php

namespace app\modules\blog\models;

use Yii;
use yii\helpers\Url;
use app\models\User;
use app\models\Lookup;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $title
 * @property string $content
 * @property string $status_code
 * @property string $update_time
 * @property string $create_time
 *
 * @property User $author
 */
class Post extends \yii\db\ActiveRecord
{
	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_NOT_PUBLISHED=3;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status_code', 'author_id'], 'required'],
            ['title', 'string', 'length' => [2, 128]],
            ['status_code', 'in', 'range' => [1,2,3]],
            [['title', 'status', 'author'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'fullname' => 'Author',
            'title' => 'Title',
            'content' => 'Content',
            'status_code' => 'Status Code',
            'status' => 'Status',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
        
    public function getStatus()
    {
        return $this->hasOne(Lookup::className(), ['code' => 'status_code'])->andWhere(['type' => 'PostStatus']);
    }
    
    public function getUrl()
    {
	    return Url::to(['post/view', 'title' => $this->title]);
    }
    
    public function beforeValidate()
    {
	    if (parent::beforeValidate()) {
		    if($this->isNewRecord) {
			    $this->author_id=Yii::$app->user->getId();
		    }
		    return true;
	    }
		return false;
    }
}
