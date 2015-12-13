<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');


//====== config start ======
/**
 * 上传文件夹
 * @var string
 */
define('UPLOAD_DIR', './common/php-html5-uploadz/uploads/');
/**
 * 默认图片
 * @var string
 */
define('DEFAULT_IMAGE', './bag-test/test-images/103754b6unkvhquepniein.jpg!50');
/**
 * 上传零时文件夹
 * @var string
*/
define('UPLOAD_TEMP_DIR',Yii::getAlias('@frontend').'/web/uploads/temp/');
//====== config end ====== 


/**
 * 当前微秒时间戳
 * @var float
 */
define('NOW_TIME_MICROTIME',$_SERVER['REQUEST_TIME_FLOAT'] ); //microtime(true)

/**
 * 当前时间
 * @var string
 */
define('NOW_TIME_YmdHis',date('Y-m-d H:i:s',NOW_TIME_MICROTIME));
/**
 * 当前时间戳
 * @var int
 */
define('NOW_TIME_STAMP',(int)NOW_TIME_MICROTIME);


/**
 * 测试类型
 */
$survey_tax = [
    '1'=>'奇趣测试',
    '2'=>'分数型心里测试',
    '3'=>'跳转型心里测试',
];

/**
 * 是否启用调试信息
 * @var boolean
 */
define('Z_DEBUG', false);

if(Z_DEBUG)
register_shutdown_function('z_shutdown_function');
/**
 * 错误脚本退出，打印调试信息
 */
function z_shutdown_function(){
    $error = error_get_last();

    if(isset($error['type'])){       
        header('content-type:text/html;charset=utf-8;');
 
        echo '<pre><b style="color:red;">',
        '脚本意外退出$EEE$start</b><br/>',
        'line：<b style="color:red;">',$error['line'],'</b><br/>',
        'file：<b style="color:red;">',$error['file'],'</b><br/>';
        
        print_r($error);
        echo '<br/><b style="color:red;">脚本意外退出$EEE$end</b></pre>';
        exit;
    }
}