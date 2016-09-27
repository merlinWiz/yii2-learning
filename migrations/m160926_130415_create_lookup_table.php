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
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lookup');
    }
}
