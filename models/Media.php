<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $file_name
 * @property string $src
 * @property string $alt
 * @property string $upload_time
 *
 * @property User $user
 * @property MediaCategory $category
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_id', 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['category_id', 'exist', 'skipOnError' => true, 'targetClass' => MediaCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'file_name' => 'File Name',
            'alt' => 'Alt',
            'upload_time' => 'Upload Time',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(MediaCategory::className(), ['id' => 'category_id']);
    }
    
}
