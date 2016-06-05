<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;
use common\models\User;
use common\z\ZCommonFun;
use yii\helpers\Json;
use common\z\ZCommonSessionFun;
/**
 * 登录
 * @author pc
 *
 */
class LoginController extends Controller{
    public $enableCsrfValidation = false;
    /**
     * 登录
     */
    public function actionLogin(){

        $this->layout = false;
        $model = new User();
        $post = Yii::$app->request->post();

        if(isset($post['username'])){
            $model->user = isset($post['username']) ? $post['username']: '';
            $model->pass = isset($post['password']) ? $post['password']: '';

            $error = $model->login($model->user, $model->pass);
            if($error==0){
                //账号登陆类型
                ZCommonSessionFun::set_login_type('user');
            }
            $data['code'] = $model->operationError;
            header('content-type:text/json;charset=utf-8;');
            echo Json::encode($data);
            exit;
//             ZCommonFun::print_r_debug($post);
        }
        $gourl = !empty($_GET['gourl']) ? $_GET['gourl'] : Yii::$app->urlManager->createUrl( 'survey/my' );
        return $this->render('login',[
            'model'=>$model,
            'gourl'=>$gourl,

        ]);
    }

    /**
     * 注册
     */
    public function actionRegister(){
        $this->layout = false;
        $model = new User();
        $post = Yii::$app->request->post();
        $success = '';
        if(isset($post['User'])){
            $model->load($post);
            $success = $model->register();
            $gourl = !empty($_GET['gourl']) ? ($_GET['gourl']) :'';
            $url = $gourl ? $gourl : Yii::$app->urlManager->createUrl(['survey/step1']);
            if($success){
                return $this->redirect($url);
            }
            //             ZCommonFun::print_r_debug($post);
        }
        return $this->render('register',[
            'model'=>$model,
            'success'=>$success,
        ]);
    }
    /**
     * 退出
     */
    public function actionLogout(){
        ZCommonSessionFun::set_user_session(null);
        return $this->redirect(['survey/index']);
    }
}