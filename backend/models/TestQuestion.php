<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "test_question".
 *
 * @property int $id
 * @property int $testId
 * @property string $question
 *
 * @property QuestionAnswer[] $questionAnswers
 * @property Tests $test
 */
class TestQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question'], 'required'],
            [['testId'], 'integer'],
            [['question'], 'string', 'max' => 255],
            [['testId'], 'exist', 'skipOnError' => true, 'targetClass' => Tests::className(), 'targetAttribute' => ['testId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'testId' => 'Test ID',
            'question' => 'Question',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionAnswers()
    {
        return $this->hasMany(QuestionAnswer::className(), ['questionId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Tests::className(), ['id' => 'testId']);
    }
}
