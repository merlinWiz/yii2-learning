<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
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
            ['file_name', 'string'],
        ];
    }

	public function behaviors()
	{
		return [
			[
				'class' => BlameableBehavior::className(),
				'createdByAttribute' => 'user_id',
				'updatedByAttribute' => false,
			],
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
	    if($this->isImage()) {
		    foreach(UploadForm::getThumbnailSizes() as $size)
		    {
			    unlink($this->getUploadsPath() . $this->getMediaThumbnail($size['title']));
		    }
		}
	    unlink($this->getFullMediaPath());

    }

    public function getFullMediaPath()
    {
	    return $this->getUploadsPath() . $this->getMedia();
    }

    public function getUploadsPath()
    {
	    return Yii::getAlias('@uploadsPath');
    }
    
    public function getMedia()
    {
	    return $this->getMediaPath() . $this->md5 . '.' . $this->extension;
    }
    
    public function getMediaThumbnail($size)
    {
	    return $this->getMediaPath() . $this->md5 . '_' . $size . '.' . $this->extension;
    }

    public function getMediaPath()
    {
	    return $this->path . DIRECTORY_SEPARATOR;
    }    
    
    public function getUploadsURI()
    {
	    return Yii::getAlias('@uploads');
    }

    public function getImageThumbnailURI($size)
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

    public function isImage()
    {
	    return UploadForm::isImage($this->getFullMediaPath());
    }

	public function getMediaThumbnailURI($size)
	{
		if( $this->isImage() ) {
			return $this->getImageThumbnailURI($size);
		} else {
			return $this->getMediaCoverURI();
		}
	}
	public function getMediaURI()
	{
		return $this->getUploadsURI() . $this->getMedia();
	}
}
