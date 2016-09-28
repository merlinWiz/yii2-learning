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
   
           'id' => $this->bigPrimaryKey(20),
           'username' => $this->string(60),
           'password' => $this->string(60),
           'email' => $this->string(100),
           'authKey' => $this->string(100)->unique(),
           'profile' => $this->string(60),
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
