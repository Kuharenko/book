<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24.03.18
 * Time: 11:27
 */

namespace backend\controllers;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;

class PostController extends ActiveController
{
    public $modelClass = 'backend\models\Materials';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ["http://kuharenko.xyz"],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Request-Method' => ['GET'],
                    'Access-Control-Request-Headers'=>['*'],
                    'Access-Control-Allow-Headers' => true
                ],
            ],
        ], parent::behaviors());
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        // подготовить и вернуть провайдер данных для действия "index"
        $model = new $this->modelClass;
        $query = $model::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => [

//                    'parent' => SORT_ASC,
//                    'sortIndex' => SORT_ASC,
                    'id' => SORT_ASC,

                ]
            ],
        ]);


        return $provider;

    }

}