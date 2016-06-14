<?php
namespace common\z;
use yii\web\Controller;
use yii;
use yii\caching\FileCache;
use common\models\UserProfile;
use yii\base\ActionEvent;
use yii\base\InvalidRouteException;
if( !class_exists('LoginRedirectYii2') ){
    include_once  __DIR__ .'/login-redirect/extend/LoginRedirectYii2.php';
}

class ZController extends Controller{

    /**
     * 站点名
     * @var string
     */
    public static $site_name = '大神蒜';
    /**
     * 关键词
     * @var string
     */
    public static $keywords  = '大神蒜 | 大神算,最强大的心理测试网站';
    /**
     * 网站描述
     * @var string
     */
    public static $description = '大神蒜,大神算,让你[认识自己、确幸未来].只要你精通星座,神学,心理学,就可以在大神蒜创建自己的测试.[大神蒜],强!准!全!全球众多大师入驻,现已进入中国!';
    /**
     * 缓存文件名
     * @var FileCache
     */
    private static $fileCache = null;
    public static $debug = '';
    /**
     * 初始化
     * @see \yii\base\Object::init()
     */
    public function init(){
        parent::init();


        $sessionUser = ZCommonSessionFun::get_user_session();
        //没有设置用户信息
        if(ZCommonSessionFun::get_user_id()>0&&!isset($sessionUser['is_set_profile'])){
            $sessionUser['is_set_profile'] = true;
            $model_UserProfile = new UserProfile();
            $condition['uid']  = ZCommonSessionFun::get_user_id();
            if($model_UserProfile = $model_UserProfile->findOne($condition)){
                $sessionUser['head_image']  = $model_UserProfile->getHeadImage0();
                $sessionUser['nickname']    = $model_UserProfile->getNickname0();
                $sessionUser['intro']       = $model_UserProfile->getIntro0();
                ZCommonSessionFun::set_user_session($sessionUser);
            }
        }

    }




    /**
     * 执行动作之前
     * @see \yii\base\Controller::beforeAction()
     */
    public function beforeAction($action){
        $operation = false;
        $operation = true;
        $LoginRedirect = new \LoginRedirectYii2();
        //设置第一次访问url
        $controller_action = Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;
        $controller_action = strtolower($controller_action);
        $controller = strtolower(Yii::$app->controller->id);
        if($controller_action=='login/login'){

        }else if( $controller=='api' ){

        }else if( $controller_action=='answer/resulte' ){
            $LoginRedirect->setFirstVisitUrl([$controller_action,'au_id'=>Yii::$app->request->get('au_id')]);
        }else if( $controller=='answer' ){
            $LoginRedirect->setFirstVisitUrl([$controller_action,'id'=>Yii::$app->request->get('id')]);
        }else if(  $controller_action=='survey/my' ){
//             $LoginRedirect->setFirstVisitUrl($controller_action);
        }else{
            $LoginRedirect->setFirstVisitUrl($controller_action);
        }

//         ZCommonFun::print_r_debug($LoginRedirect->getFirstVisitUrl());
//         ZCommonFun::print_r_debug($LoginRedirect->getFirstVisitUrl());
//         ZCommonFun::print_r_debug(Yii::$app->session[$LoginRedirect->prefix]);
//         exit;
        return $operation ;
    }

    /**
     * 获取文件缓存
     * @return \yii\caching\FileCache
     */
    public static function  getFileCache(){
        if (!self::$fileCache)
            self::$fileCache = new FileCache();

        return self::$fileCache;
    }

    public static function setFileCache($name,$key,$id){
        $key = md5($name.$key);
        $fileCache = self::getFileCache();
        $fileCache->set( $key , $value);
    }

}