<?php

use yii\db\Migration;

/**
 * Class m180224_094235_posts_categories
 */
class m180224_094235_posts_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('material_categories', [
            'id' => $this->primaryKey(),
            'material_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk_material_id',
            'material_categories',
            'material_id',
            'material',
            'id'
        );

        $this->addForeignKey(
            'fk_category_id',
            'material_categories',
            'category_id',
            'category',
            'id'
        );
    }

    /**
     * Удаляем таблицу
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('material_categories');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180224_094235_posts_categories cannot be reverted.\n";

        return false;
    }
    */
}
