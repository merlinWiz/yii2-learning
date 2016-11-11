<?php

use yii\db\Migration;

class m161107_040624_media_category extends Migration
{
    public function safeUp()
    {
        $this->createTable('media_category', [
            'id' => $this->PrimaryKey()->notNull()->unsigned(),
            'parent_id' => $this->integer()->unsigned(),
            'title' => $this->string(20),
        ]);

        $this->createIndex(
			'idx-media_category_parent_id',
			'media_category',
			['parent_id']
        );

        $this->addForeignKey(
	        'fk-media_category-parent_id',
	        'media_category',
	        'parent_id',
	        'media_category',
	        'id',
	        'SET NULL'
        );

        $this->insert('media_category', [
	        'id' => 1,
	        'title' => 'Изображения',
        ]);

        $this->insert('media_category', [
	        'id' => 2,
	        'title' => 'Документы',
        ]);

        $this->insert('media_category', [
	        'id' => 3,
	        'parent_id' => 2,
	        'title' => 'PDF',
        ]);
        $this->insert('media_category', [
	        'id' => 4,
	        'parent_id' => 1,
	        'title' => 'JPEG',
        ]);
	}

    public function safeDown()
    {

        $this->dropForeignKey(
	        'fk-media_category-parent_id',
	        'media_category'
        );

		$this->dropIndex(
			'idx-media_category_parent_id',
			'media_category'	
		);

        $this->dropTable('media_category');
    }

}
