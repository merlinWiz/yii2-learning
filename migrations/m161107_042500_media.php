<?php

use yii\db\Migration;

class m161107_042500_media extends Migration
{
    public function safeUp()
    {
        $this->createTable('media', [
            'id' => $this->PrimaryKey()->notNull()->unsigned(),
            'user_id' => $this->integer()->notNull()->unsigned(),
            'category_id' => $this->integer()->unsigned(),
            'file_name' => $this->string(100)->notNull(),
            'src' => $this->string()->notNull(),
            'alt' => $this->string(100),
            'upload_time' => 'datetime default current_timestamp',
        ]);
        
        $this->createIndex(
			'idx-media-category_id',
			'media',
			'category_id'
        );
        
        $this->addForeignKey(
	        'fk-media-category_id',
	        'media',
	        'category_id',
	        'media_category',
	        'id',
	        'CASCADE'
        );

        $this->addForeignKey(
	        'fk-media-user_id',
	        'media',
	        'user_id',
	        'user',
	        'id',
	        'CASCADE'
        );

	}

    public function safeDown()
    {
        
        $this->dropForeignKey(
	        'fk-media-user_id',
	        'media'
        );

        $this->dropForeignKey(
	        'fk-media-category_id',
	        'media'
        );

        $this->dropIndex(
			'idx-media-category_id',
			'media'
        );

        $this->dropTable('media');

    }
}
