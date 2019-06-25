<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 */
class m190116_162738_create_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tag');
    }
}
