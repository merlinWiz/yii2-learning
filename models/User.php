<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
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
    
    public function validatePassword($password)
    {
	    return password_verify($password, $this->password);
    }
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'firstname', 'lastname', 'email'], 'string', 'max' => 60],
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
            'password' => 'Password',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['author_id' => 'id']);
    }
}
