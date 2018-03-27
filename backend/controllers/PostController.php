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

//    public function actions()
//    {
//        return ArrayHelper::merge([
//            [
//                'task' => [
//                    'class' => 'backend/actions/TaskAction',
//                    'modelClass' => $this->modelClass,
//                ],
//            ],
//        ], parent::actions());
//    }

//    protected function verbs()
//    {
//        return ArrayHelper::merge([
//            [
//                'task' => ['POST'],
//            ],
//        ], parent::actions());
//    }

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