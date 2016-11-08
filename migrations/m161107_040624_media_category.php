<?php

use yii\db\Migration;

class m161107_040624_media_category extends Migration
{
    public function safeUp()
    {
        $this->createTable('media_category', [
            'id' => $this->PrimaryKey()->notNull()->unsigned(),
            'parent_id' => $this->integer()->unsigned(),
            'slug' => $this->string(60)->notNull(),
            'title' => $this->string(20),
        ]);

        $this->addForeignKey(
	        'fk-media_category-parent_id',
	        'media_category',
	        'parent_id',
	        'media_category',
	        'id',
	        'CASCADE'
        );

        $this->insert('media_category', [
	        'id' => 1,
	        'slug' => 'images',
	        'title' => 'Изображения',
        ]);

        $this->insert('media_category', [
	        'id' => 2,
	        'slug' => 'docs',
	        'title' => 'Документы',
        ]);

        $this->insert('media_category', [
	        'id' => 3,
	        'parent_id' => 2,
	        'slug' => 'pdf',
	        'title' => 'PDF',
        ]);
	}

    public function safeDown()
    {

        $this->dropForeignKey(
	        'fk-media_category-parent_id',
	        'media_category'
        );

        $this->dropTable('media_category');
    }

}
