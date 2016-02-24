<?php 
namespace frontend\controllers;
use yii;
use yii\web\Controller;
use common\models\User;
use common\z\ZCommonFun;
use yii\helpers\Json;
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
            $url = Yii::$app->urlManager->createUrl(['survey/my']);
            return $this->redirect($url);
            //             ZCommonFun::print_r_debug($post);
        }
        return $this->render('register',[
            'model'=>$model,
            'success'=>$success,
        ]);
    }
}