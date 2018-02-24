<?php

use yii\db\Migration;

/**
 * Class m180224_093649_post
 */
class m180224_093649_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('material', [
           'id'=>$this->primaryKey(),
            'name' => $this->string(),
            'content'=> $this->text()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('material');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180224_093649_post cannot be reverted.\n";

        return false;
    }
    */
}
