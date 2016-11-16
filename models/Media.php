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
            'user_id' => 'Пользователь',
            'category_id' => 'Категория',
            'file_name' => 'Имя файла',
            'upload_time' => 'Дата загрузки',
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

    public function listMediaCategories()
    {
	    return MediaCategory::itemsTree();
    }
    
    public function deleteMedia()
    {
	    unlink(Yii::getAlias('@uploadsPath') . $this->path . '/' .  $this->getMedia());
	    if($this->extension == 'jpg' || $this->extension == 'jpeg' || $this->extension == 'png') {
		    foreach(UploadForm::SIZES as $size)
		    {
			    unlink(Yii::getAlias('@uploadsPath') . $this->path . '/' . $this->getMediaThumbnail($size['title']));
		    }
		}
    }
    public function getMedia()
    {
	    return $this->md5 . '.' . $this->extension;
    }
    
    public function getMediaThumbnail($size)
    {
	    return $this->md5 . '_' . $size . '.' . $this->extension;
    }
    
}
