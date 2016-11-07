<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media_category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $slug
 * @property string $name
 *
 * @property Media[] $media
 */
class MediaCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['slug'], 'required'],
            [['slug'], 'string', 'max' => 60],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'slug' => 'Slug',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['category_id' => 'id']);
    }
}
