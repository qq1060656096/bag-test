<?php 
namespace common\z;
use yii;
class ZCommonFun{
    /**
     *生成订单号
     */
    public static function get_order_no($uid){
        $arr = range(0, 9);
        shuffle($arr);
        $time_arr = explode(' ', microtime()); ;
        // 		print_r($time_arr);
        $time = substr($time_arr[0], 2,4);
        $no = date('ymdHis').''.$time.''.$arr[0].$arr[1];
        // 		$no = substr($no, 2);
        return $no;
    }
    
    /**
     * 随机字符串
     * @param number $length
     * @return Ambigous <NULL, string>
     */
    public static function getRandChar($length=6,$is_int=false){
        $str = null;
        if($is_int){
            $strPol = "0123456789";
        }else{
            $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        }
    
        $max = strlen($strPol)-1;
    
        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
    
        return $str;
    }
    
    /**
     * 生成随机数字
     * @param number $len
     * @return int
     */
    public static function get_use_code($len=6){
        $code = '';
        $arr=range(0,9);
        shuffle($arr);
        for($i=1;$i<=$len;$i++){
            $code .= $arr[mt_rand(0, 9)];
        }
         
        return $code;
    }
    
    /**
     * 距离计算
     * @param float $x 经度
     * @param float $y 纬度
     * @param float $point_x 到达进度
     * @param float $point_y 到达纬度
     * @return number 多少米
     */
    static function distance($x,$y,$point_x,$point_y){
        return round(6378.138*2*asin(sqrt(pow(
            sin( ($y*pi()/180-$point_y*pi()/180)/2),2)+cos($y*pi()/180)*cos($point_y*pi()/180)*
            pow(sin( ($x*pi()/180-$point_x*pi()/180)/2),2)))*1000);
    }
    
    /**
     *格式化金额
     * @param float $money 金额
     * @return string 
     */
    public static function money_format($money){
    
        $temp = 0;
        $s_temp_money = 0 ;
        //亿
        if($money>=100000000){
            	
            $s_temp_money.=(int)($money/100000000).'亿';
            $money = $money%100000000;
        }
        //千万
        if($money>=10000000){
            $s_temp_money.=(int)($money/10000000).'千万';
            $money = $money%10000000;
        }
        //百万
        if($money>=1000000){
            	
            $s_temp_money.=(int)($money/1000000).'百万';
            $money = $money%1000000;
        }
        //万
        if($money>=10000){
            	
            $s_temp_money.=(int)($money/10000).'万';
            $money = $money%10000;
        }
        $money != 0 ? $s_temp_money.=$money : null;
    
    
        return $s_temp_money;
    }
    
    /**
     * 调试打印
     * @param mixed $data
     * @param string 分割开始
     * @param string 分割结束符
     * @param string $line 行号
     * @param string $file 文件名
     */
    public static function print_r_debug($data,$seperater_start='',$seperater_end='',$line='',$file=''){
        header('content-type:text/html;charset=utf-8;');
        echo '<pre><b style="color:red;">',
        $seperater_start,'{{{start</b><br/>',
        'line：<b style="color:red;">',$line,'</b><br/>',
        'file：<b style="color:red;">',$file,'</b><br/>';
        
        print_r($data);
        echo '<br/><b style="color:red;">',$seperater_end,'}}}end</b></pre>';
        
    }
    
    /**
     *
     * @param unknown $data 返回数据
     * @param integer $status 状态
     * @param string $message 消息
     */
    public static function output_json($data,$status,$message)
    {
        header('content-type:text/json;charset=utf-8;');
    
        $json_data=[
            'data'  =>$data,
            'status'  =>$status,
            'message'  =>$message,
        ];
    
        echo json_encode( $json_data);
        exit;
    }
    
    
    /**
     * 根据模型获取属性键值数组
     *@param $a_model array ActiveRecord
     *@param $s_key string ActiveRecord Attribute
     *@param $s_value string ActiveRecord Attribute
     *@return array or empty array
     */
    public static function listData($a_model,$s_key,$s_value){
        $temp = array();
        if( count($a_model)<1 || empty($a_model) ){
            return $temp;
        }
        foreach ( $a_model as $key=>$model ){
            $temp[$model->$s_key]=$model->$s_value;
        }
        return $temp;
    }
    
    
    /**
     * 获取二维码url
     * @param unknown $qrcode
     * @return string
     */
    public static function getRQCodeUrl($qrcode){
        return Yii::$app->urlManager->hostInfo.Yii::$app->request->baseUrl.'/common/phpqrcode/index2.php?qrcode='.$qrcode;
    }
    /**
     * 获取文件名
     * @param string $suffix
     * @return string
     */
    public static function getFileName($suffix){
        $fileName = NOW_TIME_STAMP.rand(1, 10).'.'.$suffix;
        return $fileName;
    }
    
    public static function getPageSize(){
        return $pageSize = 1;
    }
    
    /**
     * 多少天以前，多少分钟以前
     * @param string $the_time Y-m-d H:i:s
     * @return string
     */
    public static function time_tran($the_time) {
        $now_time = date("Y-m-d H:i:s", time());
        //echo $now_time;
        $now_time = strtotime($now_time);
        $show_time = strtotime($the_time);
        $dur = $now_time - $show_time;
        if ($dur < 0) {
            return $the_time;
        } else {
            if ($dur < 60) {
                return $dur . '秒前';
            } else {
                if ($dur < 3600) {
                    return floor($dur / 60) . '分钟前';
                } else {
                    if ($dur < 86400) {
                        return floor($dur / 3600) . '小时前';
                    } else {
                        if ($dur < 259200) {//3天内
                            return floor($dur / 86400) . '天前';
                        } else {
                            return $the_time;
                        }
                    }
                }
            }
        }
    }
}