<?php

namespace backend\controllers;

use backend\models\Material;
use backend\models\QuestionAnswer;
use backend\models\TestQuestion;
use Yii;
use backend\models\Tests;
use backend\models\TestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\filters\AccessControl;

/**
 * TestsController implements the CRUD actions for Tests model.
 */
class TestsController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view','create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index',  'view',  'create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tests models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }

        $searchModel = new TestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tests model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }


        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }

        $modelTest = new Tests();
        $modelsQuestions = [new TestQuestion()];
        $modelsAnswers = [[new QuestionAnswer]];

        $appendTo = Yii::$app->request->get('appendTo');

        if ($modelTest->load(Yii::$app->request->post())) {

            $modelsQuestions = Model::createMultiple(TestQuestion::classname());
            Model::loadMultiple($modelsQuestions, Yii::$app->request->post());

            // validate person and houses models
            $valid = $modelTest->validate();
            $valid = Model::validateMultiple($modelsQuestions) && $valid;

            if (isset($_POST['QuestionAnswer'][0][0])) {
                foreach ($_POST['QuestionAnswer'] as $indexHouse => $rooms) {
                    foreach ($rooms as $indexRoom => $room) {
                        $data['QuestionAnswer'] = $room;
                        $modelAnswers = new QuestionAnswer;
                        $modelAnswers->load($data);
                        $modelsAnswers[$indexHouse][$indexRoom] = $modelAnswers;
                        $valid = $modelAnswers->validate();
                    }
                }
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelTest->save(false)) {

                        if(!is_null($appendTo)){
                            $material = Material::findOne($appendTo);
                            if(!is_null($material)) {
                                $material->testId = $modelTest->id;
                                $material->save(false);
                            }else{
                                $appendTo=null;
                            }
                        }

                        foreach ($modelsQuestions as $indexHouse => $modelQuestion) {

                            if ($flag === false) {
                                break;
                            }

                            $modelQuestion->testId = $modelTest->id;

                            if (!($flag = $modelQuestion->save(false))) {
                                break;
                            }

                            if (isset($modelsAnswers[$indexHouse]) && is_array($modelsAnswers[$indexHouse])) {
                                foreach ($modelsAnswers[$indexHouse] as $indexRoom => $modelAnswer) {
                                    $modelAnswer->questionId = $modelQuestion->id;
                                    if (!($flag = $modelAnswer->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        if(!is_null($appendTo)){
                            return $this->redirect(['/materials/update', 'id' => $appendTo]);
                        }

                        return $this->redirect(['view', 'id' => $modelTest->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelTest' => $modelTest,
            'modelsQuestions' => (empty($modelsQuestions)) ? [new TestQuestion] : $modelsQuestions,
            'modelsAnswers' => (empty($modelsAnswers)) ? [[new QuestionAnswer]] : $modelsAnswers
        ]);
    }

    /**
     * Updates an existing Tests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }


        $modelTest = $this->findModel($id);;
        $modelsQuestions = $modelTest->testQuestions;
        $modelsAnswers = [];
        $oldAnswers = [];

        if (!empty($modelsQuestions)) {
            foreach ($modelsQuestions as $indexQuestion => $modelQuestion) {
                $questions = $modelQuestion->questionAnswers;
                $modelsAnswers[$indexQuestion] = $questions;
                $oldAnswers = ArrayHelper::merge(ArrayHelper::index($questions, 'id'), $oldAnswers);
            }
        }

        if ($modelTest->load(Yii::$app->request->post())) {

            // reset
            $modelsAnswers = [];

            $oldQuestionIDs = ArrayHelper::map($modelsQuestions, 'id', 'id');
            $modelsQuestions = Model::createMultiple(TestQuestion::classname(), $modelsQuestions);
            Model::loadMultiple($modelsQuestions, Yii::$app->request->post());
            $deletedQuestionIDs = array_diff($oldQuestionIDs, array_filter(ArrayHelper::map($modelsQuestions, 'id', 'id')));

            // validate person and houses models
            $valid = $modelTest->validate();
            $valid = Model::validateMultiple($modelsQuestions) && $valid;

            $AnswersIDs = [];
            if (isset($_POST['QuestionAnswer'][0][0])) {
                foreach ($_POST['QuestionAnswer'] as $indexQuestion => $answers) {
                    $AnswersIDs = ArrayHelper::merge($AnswersIDs, array_filter(ArrayHelper::getColumn($answers, 'id')));
                    foreach ($answers as $indexAnswer => $answer) {
                        $data['QuestionAnswer'] = $answer;
                        $modelAnswer = (isset($answer['id']) && isset($oldAnswers[$answer['id']])) ? $oldAnswers[$answer['id']] : new QuestionAnswer;
                        $modelAnswer->load($data);
                        $modelsAnswers[$indexQuestion][$indexAnswer] = $modelAnswer;
                        $valid = $modelAnswer->validate();
                    }
                }
            }

            $oldAnswersIDs = ArrayHelper::getColumn($oldAnswers, 'id');
            $deletedAnswersIDs = array_diff($oldAnswersIDs, $AnswersIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelTest->save(false)) {

                        if (! empty($deletedAnswersIDs)) {
                            QuestionAnswer::deleteAll(['id' => $deletedAnswersIDs]);
                        }

                        if (! empty($deletedQuestionIDs)) {
                            TestQuestion::deleteAll(['id' => $deletedQuestionIDs]);
                        }

                        foreach ($modelsQuestions as $indexQuestion => $modelQuestion) {

                            if ($flag === false) {
                                break;
                            }

                            $modelQuestion->testId = $modelTest->id;

                            if (!($flag = $modelQuestion->save(false))) {
                                break;
                            }

                            if (isset($modelsAnswers[$indexQuestion]) && is_array($modelsAnswers[$indexQuestion])) {
                                foreach ($modelsAnswers[$indexQuestion] as $indexAnswer => $modelAnswer) {
                                    $modelAnswer->questionId = $modelQuestion->id;
                                    if (!($flag = $modelAnswer->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelTest->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelTest' => $modelTest,
            'modelsQuestions' => (empty($modelsQuestions)) ? [new TestQuestion] : $modelsQuestions,
            'modelsAnswers' => (empty($modelsAnswers)) ? [[new QuestionAnswer]] : $modelsAnswers
        ]);
    }

    /**
     * Deletes an existing Tests model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can("admin")) {
            throw new HttpException(403, 'You are not allowed to perform this action.');
        }


        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tests::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
