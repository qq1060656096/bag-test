<?php
namespace common\z;
use yii\web\Controller;
use yii;
use yii\caching\FileCache;
class ZController extends Controller{
    /**
     * 站点名
     * @var string
     */
    public static $site_name = '大神蒜';
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
    }
    
    /**
     * 执行动作之前
     * @see \yii\base\Controller::beforeAction()
     */
    public function beforeAction($action){
        $operation = false;
        $operation = true;       
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