<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Yii;

class UploadForm extends Model
{
	public $files;
	public $category_id;
	
	public static function getThumbnailSizes()
	{
		return [
			['width' => 100, 'height' => 100, 'title' => '100x100'],
			['width' => 800, 'height' => 600, 'title' => '800x600']
		];
	}

	public static function isImage($file)
	{
		return preg_match('/^' . str_replace('\*', '.*', preg_quote('image/*', '/')) . '$/', FileHelper::getMimeType($file));
	}
	 
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['files', 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx', 'ppt', 'pptx'], 
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
			$date_path = str_replace('-', DIRECTORY_SEPARATOR, date('Y-m-d'));
			$path = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $date_path;
			
			if(!file_exists($path)){
				if(!mkdir($path, 0777, true)){
					return false;
				}
			}
			foreach($this->files as $file) {

				$md5_file = md5_file($file->tempName);
				$extension = $file->extension;
				$file_name = $md5_file . '.' . $extension;
				$save_path = $path . DIRECTORY_SEPARATOR . $file_name;
									
				$media = new Media();
				$media->category_id = $this->category_id;
				$media->path = $date_path;
				$media->file_name = $file->baseName . '.' . $extension;
				$media->md5 = $md5_file;
				$media->extension = $extension;
				
				if($media->validate()){
					if($file->saveAs($save_path)){
						$media->save(false);
						if(self::isImage($save_path)){
							foreach(self::getThumbnailSizes() as $size) {
								Image::thumbnail($save_path, $size['width'], $size['height'])->save($path . DIRECTORY_SEPARATOR . $md5_file . '_' . $size['title'] . '.' . $extension);
							}
						}
					}
				} else {
					$this->addError('upload', $media->file_name);
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
