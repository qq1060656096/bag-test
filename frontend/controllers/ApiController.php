<?php 
namespace frontend\controllers;
use yii;
use yii\web\Controller;
use common\models\User;
use common\z\ZCommonFun;
use common\z\oauth\qq\QQ;
use common\z\oauth\weibo\WeiBo;
use yii\helpers\Json;
use common\models\OauthBind;
use common\z\ZCommonSessionFun;
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
        $access_token = $qq->qq_callback();
        $openid = $qq->get_openid();
        $qq = new QQ($access_token,$openid);
        $user_info = $qq->get_user_info();
        $model_User = new User();
        $return = $model_User->userBind('', '', '', $openid, OauthBind::typeQQ, $user_info['nickname'], $user_info['figureurl'],true);
        //绑定成功或者已经绑定
        if($return===0 || $return===1){
            $user = $model_User->operationData['user']->attributes;
            $user['nickname'] = $model_User->operationData['user_profile']->nickname;
            $user['head_image'] = $model_User->operationData['user_profile']->head_image;
            $user['openid'] = $openid;
            ZCommonSessionFun::set_user_session($user);
            return $this->redirect([ZCommonSessionFun::urlMyStr]);
        }
       echo $return;
        ZCommonFun::print_r_debug( $model_User->operationData );
        
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
        $openid = $uid = $uid_get['uid'];
        echo $uid;
        $user_message = $weibo->show_user_by_id($openid);//根据ID获取用户等基本信息
        if( isset( $user_message['name'] ) && count($user_message)>0){
            $model_User = new User();
            $return = $model_User->userBind('', '', '', $openid, OauthBind::typeWeiBo, $user_message['name'], $user_message['profile_image_url'],true);
            //绑定成功或者已经绑定
            if($return===0 || $return===1){
                $user = $model_User->operationData['user']->attributes;
                $user['nickname'] = $model_User->operationData['user_profile']->nickname;
                $user['head_image'] = $model_User->operationData['user_profile']->head_image;
                $user['openid'] = $openid;
                ZCommonSessionFun::set_user_session($user);
//                 ZCommonFun::print_r_debug($user_message);
//                 ZCommonFun::print_r_debug( $model_User->operationData );
//                 exit;
                return $this->redirect([ZCommonSessionFun::urlMyStr]);
            }
        }
        echo $return;
        ZCommonFun::print_r_debug( $model_User->operationData );

        ZCommonFun::print_r_debug($user_message);
        exit;
        }
    }
}