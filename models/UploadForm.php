<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadForm extends Model
{
	public $files;
	public $category;
	private $uploads_root;
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['files', 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'pdf', 'doc', 'docx'], 'maxSize' => 1024*1024, 'maxFiles' => 20],
			['category', 'string', 'min' => 1],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'files' => 'Загрузить файлы',
			'category' => 'Категория',
		];
	}

	public function upload()
	{
		if ($this->validate()) {
			foreach($this->files as $file) {
				$file->saveAs(Yii::getAlias('@webroot') . '/uploads/' . $this->category . '/'  . $file->baseName . '.' . $file->extension);
			}
			return true;
		} else {
			return false;
		}
	}

	public function listUploadFolders()
	{
		$dir = Yii::getAlias('@webroot') . '/uploads';
		return self::scanFolder($dir);
	}
	
	private static function scanFolder($dir)
	{
	    $dh = scandir($dir);
	    $return = array();
	
	    foreach ($dh as $folder) {
		    if($folder != '.' && $folder != '..' && is_dir($dir . '/' . $folder)){
// 			    $return[$folder] = self::scanFolder($dir . '/' . $folder);
				$return[$folder] = $folder;
		    }
		    
	    }
	    
	    return $return;
	}
}
