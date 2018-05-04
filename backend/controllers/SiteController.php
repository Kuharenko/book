<?php

namespace backend\controllers;

use backend\models\Progress;
use backend\models\QuestionAnswer;
use backend\models\Task;
use backend\modules\user\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Category;
use backend\models\Materials;
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
             //'*',                        // star allows all domains
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

    public function actionCompileCode(){
        if($post = Yii::$app->request->post()) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $output = 0;
            $source = $post['source'];
            $ret_var = 0;


            $upload_dir = Yii::getAlias('@webroot') . '/upload/';
            $full_path = $upload_dir . 'test.cpp';
            $full_path_out = $upload_dir . 'test.out';

            file_put_contents($full_path, $source);
            if (file_exists($full_path)) {


                $answer = exec('g++ ' . $full_path . ' -o ' . $full_path_out . ' 2>&1', $output, $ret_var);
                if (file_exists($full_path_out)) {
                    unset($output);
//                    $answer = exec('cd ' . $upload_dir . ' && ./test.out 2>&1', $output);
                    $answer = "Помилок немає";
                    unlink($full_path);
                    unlink($full_path_out);
                } else {
//                    $answer = $output;
                    $answer = $output;

                    foreach ($answer as $index=>$error){
                        $substr = explode('/test.cpp',$error);
                        if(count($substr)>1){
                            $answer[$index] = 'code.cpp'.  $substr[1];
                        }

                    }
                    $err = $this->findErrors($answer);
                    $arr = implode(PHP_EOL, $answer);
                    $answer = $arr;
                    unlink($full_path);

                    return array('errors'=>$answer, 'lines'=>$err);
                }
            }

            return $answer;
        }
    }

    private function checkAnswer($data)
    {
            $str = implode(',', $data);
//            $array = explode(",", $answer);
            $answers = QuestionAnswer::findAll([]);
            $user_correct = 0;
            foreach ($array as $item) {
                if (isset($data[$item]) && $data[$item] == "on") {
                    $user_correct++;
                }
            }
            return ($user_correct * 100) / count($array);

    }

    private function findErrors($array)
    {
        $errors = [];
        foreach ($array as $item){
            $er = explode(' error:', $item);
            if(count($er)>1){

                $line = explode('cpp:', $er[0]);
                array_push($errors, explode(':', $line[1])[0]);
            }
        }

        return $errors;
    }

    public function actionSetTestResult(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->getRequest()->getRawBody()) {
            $data = json_decode(\Yii::$app->getRequest()->getRawBody(), true);

            if (isset($data['token'])) {
                $user = User::findIdentityByAccessToken($data['token']);
                if ($user) {
                    $model = Progress::find()->where(['material_id' => $data['material'], 'task_id' => $data['test'], 'user_id' => $user->id])->one();
                    if (!$model) {
                        $model = new Progress();
                    }
                    $model->material_id = $data['material'];
                    $model->task_id = $data['test'];
                    $model->progress_value = $data['result'];
                    $model->user_id = $user->id;
                    $model->save();
                    return 200;
                }
            }
        }

        return 0;
    }
}


