<?php

use yii\db\Migration;

/**
 * Class m180406_155417_widgets
 */
class m180406_155417_widgets extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('widgets', [
            'id'=>$this->primaryKey(),
            'status'=>$this->integer()->defaultValue(1),
            'name'=>$this->string(),
            'template'=>$this->text(),
            'html'=>$this->text(),
            'js'=>$this->text(),
            'params'=>$this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('widgets');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180406_155417_widgets cannot be reverted.\n";

        return false;
    }
    */
}
