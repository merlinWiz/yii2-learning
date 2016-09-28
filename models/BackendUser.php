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
 * @property string $profile
 *
 * @property Post[] $posts
 */
class BackendUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
	    return $this->password === $password;
    }
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'profile'], 'string', 'max' => 60],
            [['email'], 'string', 'max' => 100],
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
            'email' => 'Email',
            'profile' => 'Profile',
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
