<?php

use yii\db\Migration;

/**
 * Class m180224_094207_category
 */
class m180224_094207_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id'=>$this->primaryKey(),
            'name'=> $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180224_094207_category cannot be reverted.\n";

        return false;
    }
    */
}
