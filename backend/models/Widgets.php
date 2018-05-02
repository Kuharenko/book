<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "widgets".
 *
 * @property int $id
 * @property int $status
 * @property string $name
 * @property string $template
 * @property string $html
 * @property string $js
 * @property string $parameters
 */
class Widgets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widgets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['template', 'html', 'js', 'parameters'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Статус',
            'name' => 'Назва',
            'template' => 'Шаблон',
            'html' => 'Html',
            'js' => 'Js',
            'parameters' => 'Параметри віджету',
        ];
    }
}
