<?php

use yii\db\Migration;

class m161107_040624_media_category extends Migration
{
    public function safeUp()
    {
        $this->createTable('media_category', [
            'id' => $this->PrimaryKey()->notNull()->unsigned(),
            'parent_id' => $this->integer()->unsigned(),
            'sort' => $this->integer()->notNull()->unsigned(),
            'title' => $this->string(20),
        ]);

        $this->createIndex(
			'idx-media_category_parent_sort',
			'media_category',
			['parent_id', 'sort']
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
	        'sort' => 1,
	        'title' => 'Изображения',
        ]);

        $this->insert('media_category', [
	        'id' => 2,
	        'sort' => 2,
	        'title' => 'Документы',
        ]);

        $this->insert('media_category', [
	        'id' => 3,
	        'parent_id' => 2,
	        'sort' => 3,
	        'title' => 'PDF',
        ]);
        $this->insert('media_category', [
	        'id' => 4,
	        'parent_id' => 1,
	        'sort' => 4,
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
			'idx-media_category_parent_sort',
			'media_category'	
		);

        $this->dropTable('media_category');
    }

}
