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
            'status_code' => $this->integer()->unsigned(),
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
	        'title' => 'First post',
	        'content' => 'This is your content.',
	        'status_code' => 1,
        ]);

        $this->insert('post', [
	        'id' => 2,
	        'author_id' => 1,
	        'title' => 'Second post',
	        'content' => 'This is your content.',
	        'status_code' => 2,
        ]);

        $this->insert('post', [
	        'id' => 3,
	        'author_id' => 1,
	        'title' => 'Third post',
	        'content' => 'This is your content.',
	        'status_code' => 2,
        ]);

        $this->insert('post', [
	        'id' => 4,
	        'author_id' => 1,
	        'title' => 'Fourth post',
	        'content' => 'This is your content.',
	        'status_code' => 3,
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
