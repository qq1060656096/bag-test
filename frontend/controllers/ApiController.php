<?php 
namespace frontend\controllers;
use yii;
use yii\web\Controller;
use common\models\User;
use common\z\ZCommonFun;
use common\z\oauth\qq\QQ;
use common\z\oauth\weibo\WeiBo;
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
        echo $qq->qq_callback();
        echo $qq->get_openid();
        $data = $qq->get_info();
        
        ZCommonFun::print_r_debug($data);
        exit;
    }
    
    
    /**
     * 微博登录
     */
    public function actionLoginWeibo(){
        $weibo = new WeiBo(WB_AKEY , WB_SKEY);
        $code_url = $weibo->getAuthorizeURL( WB_CALLBACK_URL );
        header('Location:'.$code_url);
        exit;
         
    }
    /**
     * 微博回调地址
     */
    public function actionCallbackWeibo(){
        $weibo = new WeiBo(WB_AKEY , WB_SKEY);
        
        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = WB_CALLBACK_URL;
            try {
                $token = $weibo->getAccessToken( 'code', $keys ) ;
            } catch (OAuthException $e) {
            }
        }
        
        if ($token) {
            $_SESSION['token'] = $token;
            setcookie( 'weibojs_'.$weibo->client_id, http_build_query($token) );
            
        $uid_get = $weibo->get_uid();
        $uid = $uid_get['uid'];
        $user_message = $weibo->show_user_by_id($uid);//根据ID获取用户等基本信息

        ZCommonFun::print_r_debug($user_message);
        exit;
        }
    }
}