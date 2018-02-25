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


class Material extends ActiveRecord
{

    // Настраиваем имя таблицы
    public static function tableName()
    {
        return 'material';
    }

    /**
     * Загружаем статьи и категории к ним
     * @return array|ActiveRecord[]
     */
    public static function loadMaterials()
    {
        return Material::find()
            ->with('categories')
            ->limit(20)
            ->asArray()
            ->all();
    }

    /**
     * Загружаем статьи и категории к ним
     * @return array|ActiveRecord[]
     */
    public static function loadMaterial($id)
    {
        return Material::find()
            ->where(['id'=>$id])
            ->with('categories')
            ->asArray()->one();
    }

    /* Получаем категории из связующей таблицы */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('material_categories', ['material_id' => 'id'])->asArray();
    }
}