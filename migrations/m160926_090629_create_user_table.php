<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160926_090629_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user', [
   
           'id' => $this->PrimaryKey()->notNull()->unsigned(),
           'username' => $this->string(60),
           'password' => $this->string(60),
           'password_reset_token' => $this->string(60),
           'firstname' => $this->string(60),
           'lastname' => $this->string(60),
           'email' => $this->string(60),
        ]);
        
        $this->insert('user', [
	        'id' => 1,
	        'username' => '_dev',
	        'password' => '$2y$10$gdB.xsoyeWg4xm7XR.HkAeq4I54m6rHH3xCJXxJGDxtkF7AsqGtkO',
	        'email' => 'egorkryazh@gmail.com',
        ]);

        $this->insert('user', [
	        'id' => 2,
	        'username' => 'editor',
	        'password' => '$2y$10$gdB.xsoyeWg4xm7XR.HkAeq4I54m6rHH3xCJXxJGDxtkF7AsqGtkO',
	        'email' => 'user@example.com',
        ]);
    }


    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
