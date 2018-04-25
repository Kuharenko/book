<?php

use yii\db\Migration;

/**
 * Class m180402_073751_progress_table
 */
class m180402_073751_progress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('progress', [
            'id'=>$this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'material_id'=>$this->integer()->notNull(),
            'task_id'=>$this->integer()->notNull(),
            'progress_value'=>$this->integer()
        ]);

        $this->addForeignKey('progress_user_id', 'progress', 'user_id', 'user', 'id');
        $this->addForeignKey('progress_material_id', 'progress', 'material_id', 'material', 'id');
        $this->addForeignKey('progress_task_id', 'progress', 'task_id', 'tests', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('progress');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180402_073751_progress_table cannot be reverted.\n";

        return false;
    }
    */
}
