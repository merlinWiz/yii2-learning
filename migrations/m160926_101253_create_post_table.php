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
            'id' => $this->PrimaryKey()->notNull()->unsigned(),
            'author_id' => $this->integer()->notNull()->unsigned(),
            'title' => $this->text()->notNull(),
            'content' => $this->text(),
            'status' => $this->integer()->unsigned(),
            'update_time' => 'datetime on update current_timestamp',
            'create_time' => 'datetime default current_timestamp',
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
        
        $this->insert('post', [
	        'id' => 1,
	        'author_id' => 1,
	        'title' => 'Hello World!',
	        'content' => 'This is your first post.',
	        'status' => 1,
        ]);
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
