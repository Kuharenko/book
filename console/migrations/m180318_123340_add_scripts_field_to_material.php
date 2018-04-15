<?php

use yii\db\Migration;

/**
 * Class m180318_123340_add_scripts_field_to_material
 */
class m180318_123340_add_scripts_field_to_material extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('material', 'post_scripts',$this->text());
        $this->addColumn('material', 'announce',$this->text());
        $this->addColumn('material', 'clear_html',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('material', 'post_scripts');
        $this->dropColumn('material', 'announce');
        $this->dropColumn('material', 'clear_html');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180318_123340_add_scripts_field_to_material cannot be reverted.\n";

        return false;
    }
    */
}
