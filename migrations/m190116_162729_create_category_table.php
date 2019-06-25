<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m190116_162729_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
