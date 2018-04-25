<?php

namespace backend\controllers;

use backend\models\Tests;
use Yii;
use backend\models\Materials;
use backend\models\MaterialsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * MaterialsController implements the CRUD actions for Materials model.
 */
class MaterialsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Materials models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaterialsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Materials model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Materials model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Materials();
        $modelTests = Tests::find()->all();
        $modelParents = Materials::find()->asArray()->all();
        $items = ArrayHelper::map($modelTests,'id','question');
        $arr = [];

        foreach ($modelParents as $index=>$modelParent) {
            $len = 0;
            $arr[$index] = $this->makeTreeRelatives($modelParent, $len);
            if($arr[$index]>0){
                $add = "";
                for($i = 0; $i<$arr[$index]; $i++){
                    $add.= " ---";
                }
                $modelParents[$index]['name'] = $add." ".$modelParents[$index]['name'];
            }
        }


        $parents = ArrayHelper::map($modelParents,'id','name');
        ArrayHelper::setValue($parents,'0', 'Корень');
        ksort($parents);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'testItems' => $items,
            'parents' => $parents
        ]);
    }

    /**
     * @param $array
     * @return mixed
     */
    protected function makeTreeRelatives($item, $len){
        if($item['parent'] != 0){
            $len ++;
            $model = Materials::find()->where(['id'=>$item['parent']])->asArray()->one();
            return $this->makeTreeRelatives($model, $len);
        }else{
            return $len;
        }
    }

    /**
     * Updates an existing Materials model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelTests = Tests::find()->all();
        $modelParents = Materials::find()->asArray()->all();
        $items = ArrayHelper::map($modelTests,'id','question');
        $arr = [];

        foreach ($modelParents as $index=>$modelParent) {
            $len = 0;
            $arr[$index] = $this->makeTreeRelatives($modelParent, $len);
            if($arr[$index]>0){
                $add = "";
                for($i = 0; $i<$arr[$index]; $i++){
                    $add.= " ---";
                }
                $modelParents[$index]['name'] = $add." ".$modelParents[$index]['name'];
            }
        }




        $parents = ArrayHelper::map($modelParents,'id','name');
        ArrayHelper::setValue($parents,'0', 'Корень');
        ksort($parents);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'testItems' => $items,
            'parents' => $parents
        ]);
    }

    /**
     * Deletes an existing Materials model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Materials model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Materials the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Materials::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
