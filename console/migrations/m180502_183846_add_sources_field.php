<?php

use yii\db\Migration;

/**
 * Class m180502_183846_add_sources_field
 */
class m180502_183846_add_sources_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('material', 'sources', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('material', 'sources');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180502_183846_add_sources_field cannot be reverted.\n";

        return false;
    }
    */
}
