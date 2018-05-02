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

use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use backend\modules\user\models\forms\LoginForm;
use backend\modules\user\models\User;
use backend\modules\user\models\Profile;
use backend\modules\user\models\Role;

class UserLoginController extends ActiveController
{
    public $modelClass = 'backend\modules\user\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];

        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ["http://kuharenko.xyz"],
                    'Access-Control-Request-Method' => ['POST'],
                    'Access-Control-Request-Headers'=>['*'],
                    'Access-Control-Allow-Credentials' => true
                ],
            ],
        ], parent::behaviors());
    }

    public function actionLogin()
    {
        if (\Yii::$app->getRequest()->getRawBody()) {
            $data = json_decode(\Yii::$app->getRequest()->getRawBody(), true);

            $form = new LoginForm();
            $form->email = $data['email'];
            $form->password =  $data['password'];

            if($form->validate()){
                $user = $form->getUser();
                return ["status"=>200,'access_token'=> $user->access_token,'username'=> $user->email];
            }else{
                return ['status'=> 301, 'errors'=>$form->errors];
            }

        }
        throw new \yii\web\HttpException(405);
    }

    public function actionRegister()
    {
//        $user = $this->module->model("User", ["scenario" => "register"]);
        $user = new User(['scenario' => 'register']);
        $profile = new Profile();



        if (\Yii::$app->getRequest()->getRawBody()) {
            $data = json_decode(\Yii::$app->getRequest()->getRawBody(), true);

            $user->email = $data['register_email'];
            $user->newPassword =  $data['register_password'];
            $user->newPasswordConfirm =  $data['register_password'];

            if($user->validate()){

                $role = new Role();
                $user->setRegisterAttributes($role::ROLE_USER);
                $user->status = 1;
                $user->save();
                $profile->setUser($user->id)->save();
                return ["status"=>200,'access_token'=> $user->access_token,'username'=> $user->email];
            }else{
                return ["status"=>301,  'errors'=> $user->errors];
            }

        }
        throw new \yii\web\HttpException(405);
    }

}