<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24.02.18
 * Time: 12:19
 */

namespace backend\models;
use yii\db\ActiveRecord;
use backend\models\Category;

class MaterialCategories extends ActiveRecord
{
    public static function tableName()
    {
        return 'material_categories';
    }

    public function getNames()
    {
        return $this->hasMany(Category::className(), ['id'=>'category_id']);
    }

}