<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadForm extends Model
{
	public $files;
	public $category_id;
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['files', 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'pdf', 'doc', 'docx', 'ppt', 'pptx'], 
			'mimeTypes' => [
				'image/*', 
				'application/pdf', 
				'application/msword', 
				'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
				'application/vnd.ms-powerpointtd', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
				],
			'maxSize' => 1024*1024*8, 'maxFiles' => 20],
            ['category_id', 'exist', 'skipOnError' => true, 'targetClass' => MediaCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'files' => 'Загрузить файлы',
			'category_id' => 'Категория',
		];
	}

	public function upload()
	{
		if ($this->validate()) {
			$date_path = str_replace('-', '/', date('Y-m-d')) . '/';
			$path = Yii::getAlias('@webroot') . '/uploads/' . $date_path;
			$user_id = Yii::$app->user->getId();
			
			if(!file_exists($path)){
				if(!mkdir($path, 0777, true)){
					return false;
				}
			}
			foreach($this->files as $file) {

				$md5_file = md5_file($file->tempName);
				$file_name = $md5_file . '.' . $file->extension;
				$save_path = $path . $file_name;
				
				if($file->saveAs($save_path)){
					
					$media = new Media();
					$media->user_id = $user_id;
					$media->category_id = $this->category_id;
					$media->file_name = $file->baseName . '.' . $file->extension;
					$media->src = $date_path . $file_name;
					
					$media->save();
				}
			}
			return true;
		} else {
			return false;
		}
	}

    public function listMediaCategories()
    {
	    return MediaCategory::itemsTree();
    }

}
