<?php

use yii\db\Migration;

/**
 * Handles the creation for table `lookup`.
 */
class m160926_130415_create_lookup_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lookup', [
            'id' => $this->bigPrimaryKey(20),
            'name' => $this->string(20),
            'code' => $this->integer(),
            'type' => $this->string(20),
            'position' => $this->integer(),
        ]);
        
        $this->insert('lookup', [
	        'id' => 1,
	        'name' => 'Draft',
	        'code' => 1,
	        'type' => 'PostStatus',
	        'position' => 1
        ]);

        $this->insert('lookup', [
	        'id' => 2,
	        'name' => 'Published',
	        'code' => 2,
	        'type' => 'PostStatus',
	        'position' => 2
        ]);

        $this->insert('lookup', [
	        'id' => 3,
	        'name' => 'Archived',
	        'code' => 3,
	        'type' => 'PostStatus',
	        'position' => 3
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lookup');
    }
}
