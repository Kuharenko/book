<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24.03.18
 * Time: 11:27
 */

namespace backend\controllers;
use yii\rest\ActiveController;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;

class PostController extends ActiveController
{
    public $modelClass = 'backend\models\Material';

    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ["http://kuharenko.xyz"],
                    'Access-Control-Request-Method' => ['GET'],
                ],
            ],
        ], parent::behaviors());
    }


}