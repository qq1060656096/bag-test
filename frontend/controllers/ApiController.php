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
use common\z\oauth\weixin\WeiXin;
/**
 * 登录
 * @author pc
 *  
 */
class ApiController extends Controller{
    
    public $enableCsrfValidation = false;
    public $bind_url = ['user-profile/bind-list'];
    
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
        $zhao_uid = ZCommonSessionFun::get_user_id();
        $zhao_uid =  $zhao_uid>0 ? $zhao_uid : '';
//         ZCommonSessionFun::set_user_session($access_token);
//         exit;
        $openid = $qq->get_openid();
        $qq = new QQ($access_token,$openid);
        $user_info = $qq->get_user_info();
        $model_User = new User();
        $return = $model_User->userBind('', '', $zhao_uid, $openid, OauthBind::typeQQ, $user_info['nickname'], $user_info['figureurl'],true);
        //绑定成功或者已经绑定
        if($return===0 || $return===1){
            $user = $model_User->operationData['user']->attributes;
            $user['nickname'] = $model_User->operationData['user_profile']->nickname;
            $user['head_image'] = $model_User->operationData['user_profile']->head_image;
            $user['openid'] = $openid;
            ZCommonSessionFun::set_user_session($user);
            //qq登录类型
            if(intval($zhao_uid)>0){          
                $bind_url = ['user-profile/bind-list'];
                return $this->redirect($bind_url);
            }else{
                ZCommonSessionFun::set_login_type(OauthBind::typeQQ);
            }
            return $this->redirect([ZCommonSessionFun::urlMyStr]);
        }
       
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
        $zhao_uid = ZCommonSessionFun::get_user_id();
        $zhao_uid =  $zhao_uid>0 ? $zhao_uid : '';
        $weibo = new WeiBo(WB_AKEY , WB_SKEY);
        
        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = WB_CALLBACK_URL;
            try {
                $token = $weibo->getAccessToken( 'code', $keys ) ;
            } catch (\OAuthException $e) {
            }
        }
        
        if ($token) {
            $_SESSION['token'] = $token;
            setcookie( 'weibojs_'.$weibo->client_id, http_build_query($token) );
            
        $uid_get = $weibo->get_uid();
//         ZCommonFun::print_r_debug($uid_get);
//         exit;
        if(isset($uid_get['error_code'])){
            die('微博授权登陆错误，错误码：'.$uid_get['error_code'].',请联系管理员');
        }
        $openid = $uid = $uid_get['uid'];
//         echo $uid;
        
        $user_message = $weibo->show_user_by_id($openid);//根据ID获取用户等基本信息
        if( isset( $user_message['name'] ) && count($user_message)>0){
            $model_User = new User();
            $return = $model_User->userBind('', '', $zhao_uid, $openid, OauthBind::typeWeiBo, $user_message['name'], $user_message['profile_image_url'],true);
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
                //微博登录类型
                if(intval($zhao_uid)>0){
                    
                    return $this->redirect($this->bind_url);
                }else{
                    ZCommonSessionFun::set_login_type(OauthBind::typeWeiBo);
                }
                return $this->redirect([ZCommonSessionFun::urlMyStr]);
            }
        }
//         echo $return;
        ZCommonFun::print_r_debug( $model_User->operationData );

        ZCommonFun::print_r_debug($user_message);
        exit;
        }
    }
    
    /**
     * 微信认证
     */
    public function actionWeiXinValid(){
        $o_WeiXin = new WeiXin();
        $o_WeiXin->valid();
    }
    
    /**
     * 微信登录授权
     */
    public function actionLoginWeiXin(){
        $redirect_uri = Yii::$app->urlManager->createAbsoluteUrl(['api/wei-xin-callback']);
        $o_WeiXin = new WeiXin();
        $url = $o_WeiXin->oauth2_url($o_WeiXin->APPID, $redirect_uri,true);
//         echo $url;
//         exit;
        header('Location: '.$url);
        exit;
    }
    /**
     * 授权回调地址
     */
    public function actionWeiXinCallback(){
        $zhao_uid = ZCommonSessionFun::get_user_id();
        $zhao_uid =  $zhao_uid>0 ? $zhao_uid : '';
        $o_WeiXin = new WeiXin();
//         echo '<pre>';
        if( isset($_GET['code'])){
            $code = $o_WeiXin->oautch_get_code();
            if($code){
                    $data = $o_WeiXin->oautch_access_token($o_WeiXin->APPID, $o_WeiXin->SECRETS, $code,false);
                    //设置access_token
                    if( isset( $data->openid ) && $data->openid ){
                        $basic_access_token = Yii::$app->cache->get('basic_access_token');
                        //if( !$basic_access_token ){
                          //$basic_access_token = $o_WeiXin->oau(null,null,false);
                            //echo $basic_access_token,'token','<br/>';
//                           print_r($data);
//                           print_r($basic_access_token);
//                           exit;
//                           print_r($basic_access_token);
                            //Yii::$app->cache->set('basic_access_token', $basic_access_token,7000);
                        //}
//                         echo $basic_access_token,'token2222222','<br/>';
                        $user_info = $o_WeiXin->user_info( $data->access_token , $data->openid,null,true );
                        if(!isset($user_info->nickname)){
                            echo '<br/>','userinfo';
                            print_r($user_info);
                            exit;
                        }
                        $openid = $data->openid;
                        
                        $model_User = new User();
                        $return = $model_User->userBind('', '', $zhao_uid, $openid, OauthBind::typeWeiXin, $user_info->nickname , $user_info->headimgurl ,true);
                        //绑定成功或者已经绑定
                        if($return===0 || $return===1){
                            $user = $model_User->operationData['user']->attributes;
                            $user['nickname'] = $model_User->operationData['user_profile']->nickname;
                            $user['head_image'] = $model_User->operationData['user_profile']->head_image;
                            $user['openid'] = $openid;
                            ZCommonSessionFun::set_user_session($user);
//                                             ZCommonFun::print_r_debug($user);
//                                             ZCommonFun::print_r_debug( $model_User->operationData );
//                                             exit;
                            //微信登陆类型
                            if(intval($zhao_uid)>0){
                                
                                return $this->redirect($this->bind_url);
                            }else{
                                ZCommonSessionFun::set_login_type(OauthBind::typeWeiXin);
                            }
                            return $this->redirect([ZCommonSessionFun::urlMyStr]);
                        }
                        
                    }else{
                      
//                         print_r( $data );
                    }

                
               
                
//                 
            }
            
            
            echo $code,'code';
            print_r( $data );
        }
        
    }
}