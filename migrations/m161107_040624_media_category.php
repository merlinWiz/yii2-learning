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
            'name' => $this->string(20),
        ]);

        $this->insert('media_category', [
	        'id' => 1,
	        'slug' => 'images',
	        'name' => 'Изображения',
        ]);

        $this->insert('media_category', [
	        'id' => 2,
	        'slug' => 'docs',
	        'name' => 'Документы',
        ]);

        $this->insert('media_category', [
	        'id' => 3,
	        'parent_id' => 2,
	        'slug' => 'pdf',
	        'name' => 'PDF',
        ]);
	}

    public function safeDown()
    {
        $this->dropTable('media_category');
    }

}
