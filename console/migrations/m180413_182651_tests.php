<?php

use yii\db\Migration;

/**
 * Class m180413_182651_tests
 */
class m180413_182651_tests extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tests', [
            'id' => $this->primaryKey(),
            'question' => $this->string()->notNull()
        ]);

        $this->createTable('test_question', [
            'id' => $this->primaryKey(),
            'testId' => $this->integer()->notNull(),
            'question' => $this->string()->notNull(),
        ]);

        $this->createTable('question_answer', [
            'id' => $this->primaryKey(),
            'questionId' => $this->integer()->notNull(),
            'variant' => $this->string()->notNull(),
            'isRight' => $this->integer()
        ]);

        $this->addColumn('material', 'testId',$this->integer());

        $this->addForeignKey('FkTestId', 'test_question', 'testId', 'tests', 'id', 'CASCADE');
        $this->addForeignKey('FkQuestionId', 'question_answer', 'questionId', 'test_question', 'id', 'CASCADE');
        $this->addForeignKey('FkMaterialTestId', 'material', 'testId', 'tests', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('question_answer');
        $this->dropTable('test_question');
        $this->dropTable('tests');
        $this->dropColumn('material', 'testId');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180413_182651_tests cannot be reverted.\n";

        return false;
    }
    */
}
