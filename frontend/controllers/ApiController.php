<?php 
namespace frontend\controllers;
use yii;
use yii\web\Controller;
use common\models\User;
use common\z\ZCommonFun;
use common\z\oauth\qq\QQ;
use yii\helpers\Json;
/**
 * 登录
 * @author pc
 *
 */
class ApiController extends Controller{
    
    public $enableCsrfValidation = false;
    
    /**
     * qq登录
     */
    public function actionLoginQq(){
       $qq = new QQ();
        
      $qq->qq_login();
      exit;
       
    }
    /**
     * qq回调地址
     */
    public function actionCallbackQq(){
        $qq = new QQ();
       

        $data = $qq->get_info();
        echo $qq->get_openid();
        ZCommonFun::print_r_debug($data);
        exit;
    }
}