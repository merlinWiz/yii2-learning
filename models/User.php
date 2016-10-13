<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_reset_token
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property bool $isadmin
 *
 * @property Post[] $posts
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'user';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username', 'firstname', 'lastname', 'email'], 'string', 'max' => 60],
			[['username', 'email'], 'trim'],
			[['username', 'email'], 'required'],
			[['username', 'email'], 'unique'],
			['email', 'email'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'username' => 'Username',
			'firstname' => 'First Name',
			'lastname' => 'Last Name',
			'fullname' => 'Full Name',
			'email' => 'Email',
		];
	}
	
	public static function findIdentity($id)
	{
		 return static::findOne($id);
	}
	
	public static function findIdentityByAccessToken($token, $type = null)
	{
		 throw new NotSupportedException();
	}
	
	public function getId()
	{
		 return $this->id;
	}
	
	public function getAuthKey()
	{
		 throw new NotSupportedException();
	}
	
	public function validateAuthKey($authKey)
	{
		 throw new NotSupportedException();
	}
	
	public static function findByUsername($username)
	{
		 return self::findOne(['username' => $username]);
	}
	
	public static function findByPasswordResetToken($token)
	{
		 if(!static::isPasswordResetTokenValid($token)) {
			  return null;
		 }
		 
		 return static::findOne([
			'password_reset_token' => $token,
		 ]);
	}
	
	public static function isPasswordResetTokenValid($token)
	{
		 if(empty($token)) {
			  return false;
		 }
		 
		 $timestamp = (int) substr($token, strrpos($token, '_') + 1);
		 $expire = Yii::$app->params['user.passwordResetTokenExpire'];
		 return $timestamp + $expire >= time();
	}
	
	public function generatePasswordResetToken()
	{
		 $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}
	
	public function removePasswordResetToken()
	{
		 $this->password_reset_token = null;
	}
	
	public function validatePassword($password)
	{
		 return Yii::$app->getSecurity()->validatePassword($password, $this->password);
	}
	
	public function setPassword($password)
	{
		$this->password = Yii::$app->security->generatePasswordHash($password);
	}

	public function beforeSave($insert) {
		if(parent::beforeSave($insert)) {
			
// 			$this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);

			return true;
		} else {
			return false;
		}
	}
	
	
	public function getFullName()
	{
		 return $this->firstname . ' ' . $this->lastname;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPosts()
	{
		return $this->hasMany(Post::className(), ['author_id' => 'id']);
	}
}
