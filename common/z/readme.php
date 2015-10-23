<?php 
/**
 * yii2 app advance
 * yii2 高级版
 * 自定义类库
 * @author andy
 * @email 1060656096@qq.com
 * @version 1.0
 * @yii_version yii2
 */


/***======(常量定义配置)请把以下代码复制到bootstrap.php中 start ========***/
//====== config start ======
/**
 * 上传文件夹
 * @var string
 */
define('UPLOAD_DIR', Yii::getAlias('@frontend').'/web/uploads/real/');
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
/***======(常量定义配置)请把以上代码复制到bootstrap.php中 end ========***/



/***======XXX(常用配置)请把main-local复制到common/config/下 start XXX========***/




