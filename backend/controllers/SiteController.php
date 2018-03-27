<?php

namespace backend\controllers;

use backend\models\Task;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Category;
use backend\models\Material;
use backend\models\MaterialCategories;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            // For cross-domain AJAX request
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to domains:
                    'Origin' => static::allowedDomains(),
                    'Access-Control-Request-Method' => ['GET', 'POST'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Max-Age' => 3600,                 // Cache (seconds)
                ],
            ],

        ]);
    }

    public static function allowedDomains()
    {
        return [
             '*',                        // star allows all domains
//            'http://test1.example.com',
//            'http://book.my',
            'http://kuharenko.xyz',
//            'http://backend.kuharenko.xyz',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionPosts()
    {
        $materials = Material::loadMaterials();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $materials;
    }

    public function actionPost($id)
    {
        $material = Material::loadMaterial($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $material;
    }

    public function actionCategories()
    {
        $material = Category::loadMaterials();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $material;
    }

    public function actionCheckTask($taskId=null, $taskType=null)
    {
        if($post = Yii::$app->request->post()){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $task = Task::findOne($post['task_id']);
            $answer = $this->checkAnswer($post, $task->taskAnswer, $task->taskType);

            return $answer;
        }
    }

    private function checkAnswer($data, $answer, $type)
    {

        if ($type == 1) {

            $array = explode(",", $answer);

            $user_correct = 0;
            foreach ($array as $item) {
                if (isset($data[$item]) && $data[$item] == "on") {
                    $user_correct++;
                }
            }
            return ($user_correct * 100) / count($array);
        }else{
            $output = 0;
            $source = $data['source'];
            $ret_var = 0;


            $upload_dir = Yii::getAlias('@webroot').'/upload/';
            $full_path = $upload_dir.'test.cpp';
            $full_path_out = $upload_dir.'test.out';

            file_put_contents($full_path, $source);
            if(file_exists($full_path)){


                $answer = exec('g++ '.$full_path.' -o '.$full_path_out.' 2>&1', $output, $ret_var);
                if(file_exists($full_path_out)){
                    unset($output);
                    $answer = exec('cd '.$upload_dir.' && ./test.out 2>&1', $output);
                    $answer = "Помилок немає";
                    unlink($full_path);
                    unlink($full_path_out);
                }else{
//                    $answer = $output;
                    $answer = "Присутня помилка!";
                    unlink($full_path);
                }
            }

            return $answer;
        }
    }
}


