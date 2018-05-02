<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "question_answer".
 *
 * @property int $id
 * @property int $questionId
 * @property string $variant
 * @property int $isRight
 *
 * @property TestQuestion $question
 */
class QuestionAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['variant'], 'required'],
            [['questionId', 'isRight'], 'integer'],
            [['variant'], 'string', 'max' => 255],
            [['questionId'], 'exist', 'skipOnError' => true, 'targetClass' => TestQuestion::className(), 'targetAttribute' => ['questionId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'questionId' => 'ID запитання',
            'variant' => 'Варіант відповіді',
            'isRight' => 'Чи є відповідь вірною?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(TestQuestion::className(), ['id' => 'questionId']);
    }
}
