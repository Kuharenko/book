<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24.02.18
 * Time: 12:13
 */

namespace backend\models;
use yii\db\ActiveRecord;
use backend\models\MaterialCategories;
use backend\models\Category;


class Progress extends ActiveRecord
{

    // Настраиваем имя таблицы
    public static function tableName()
    {
        return 'progress';
    }
}