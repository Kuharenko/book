<?php

use yii\db\Migration;

/**
 * Class m180422_174138_added_parent
 */
class m180422_174138_added_parent extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('material','parent', $this->integer()->defaultValue(0));
        $this->addColumn('material','sortIndex', $this->integer()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('material', 'parent');
        $this->dropColumn('material', 'sortIndex');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180422_174138_added_parent cannot be reverted.\n";

        return false;
    }
    */
}
