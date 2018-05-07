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
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'content' => $this->text(),
            'post_scripts' => $this->text(),
            'announce' => $this->text(),
            'clear_html' => $this->text(),
            'parent' => $this->integer()->defaultValue(0),
            'sortIndex' => $this->integer()->defaultValue(0),
            'sources'=> $this->text()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('material');
    }
}
