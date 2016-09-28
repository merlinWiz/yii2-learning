<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $title
 * @property string $content
 * @property string $status
 * @property string $update_time
 * @property string $create_time
 *
 * @property User $author
 */
class Post extends \yii\db\ActiveRecord
{
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
            [['title', 'content', 'status'], 'required'],
            ['title', 'string', 'length' => [2, 128]],
            ['status', 'in', 'range' => [1,2,3]],
            [['title', 'status'], 'safe'],
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
            'title' => 'Title',
            'content' => 'Content',
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
    
    public function getUrl()
    {
	    return Url::to(['post/view', 'title' => $this->title]);
    }
}
