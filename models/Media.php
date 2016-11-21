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
	    unlink($this->getUploadsPath() . $this->getMedia());
	    if($this->extension == 'jpg' || $this->extension == 'jpeg' || $this->extension == 'png') {
		    foreach(UploadForm::getThumbnailSizes() as $size)
		    {
			    unlink($this->getUploadsPath() . $this->getMediaThumbnail($size['title']));
		    }
		}
    }
    public function getMedia()
    {
	    return $this->getMediaPath() . $this->md5 . '.' . $this->extension;
    }
    
    public function getMediaThumbnail($size)
    {
	    return $this->getMediaPath() . $this->md5 . '_' . $size . '.' . $this->extension;
    }
    
    public function getUploadsPath()
    {
	    return Yii::getAlias('@uploadsPath');
    }
    
    public function getUploadsURI()
    {
	    return Yii::getAlias('@uploads');
    }
    public function isImage()
    {
	    return $this->extension == 'jpg' || $this->extension == 'jpeg' || $this->extension == 'png';
    }
    public function getMediaThumbnailURI($size)
    {
	    return $this->getUploadsURI() . $this->getMediaThumbnail($size);
    }
    public function getMediaCoverURI()
    {
	    $path = 'covers' . DIRECTORY_SEPARATOR;
	    $cover = $path . $this->extension . '.png';
	    
	    if(file_exists($this->getUploadsPath() . $cover)){
		    return $this->getUploadsURI() . $cover;
	    } else {
	    	return $this->getUploadsURI() . $path . 'blank.png';
	    }
    }
    public function getMediaPath()
    {
	    return $this->path . DIRECTORY_SEPARATOR;
    }
}
