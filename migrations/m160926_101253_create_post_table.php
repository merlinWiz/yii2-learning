<?php

use yii\db\Migration;

/**
 * Handles the creation for table `post`.
 */
class m160926_101253_create_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->bigPrimaryKey(20),
            'author_id' => $this->bigInteger(20)->notNull(),
            'title' => $this->text()->notNull(),
            'content' => $this->text(),
            'status' => $this->string(20),
            'update_time' => 'timestamp on update current_timestamp',
            'create_time' => $this->timestamp()->defaultValue(0),
        ]);
        
        $this->createIndex(
			'idx-post-author_id',
			'post',
			'author_id'
        );
        
        $this->addForeignKey(
	        'fk-post-author_id',
	        'post',
	        'author_id',
	        'user',
	        'id',
	        'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        $this->dropForeignKey(
	        'fk-post-author_id',
	        'post'
        );

        $this->dropIndex(
			'idx-post-author_id',
			'post'
        );

        $this->dropTable('post');

    }
}
