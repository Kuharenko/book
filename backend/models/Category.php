<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24.02.18
 * Time: 12:18
 */

namespace backend\models;
use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public static function loadMaterials()
    {
        return Category::find()
            ->asArray()
            ->all();
    }
}