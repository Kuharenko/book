<?php

use yii\db\Migration;

/**
 * Class m180305_192834_check_task
 */
class m180305_192834_check_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id'=>$this->primaryKey(),
            'taskText'=>$this->text(),
            'taskType'=> $this->integer(),
            'taskAnswer'=>$this->string()
        ]);


        $this->createTable('material_task', [
            'id' => $this->primaryKey(),
            'material_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk_material_task_id',
            'material_task',
            'material_id',
            'material',
            'id'
        );

        $this->addForeignKey(
            'fk_task_id',
            'material_task',
            'task_id',
            'task',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('Task');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180305_192834_check_task cannot be reverted.\n";

        return false;
    }
    */
}
