<?php
/**
 * upload.php
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */
use PHPImageWorkshop\ImageWorkshop as ImageWorkshop;
require_once(__DIR__.'/ImageWorkshop-2.0.6/tests/autoload.php');
#!! 注意
#!! 此文件只是个示例，不要用于真正的产品之中。
#!! 不保证代码安全性。

#!! IMPORTANT:
#!! this file is just an example, it doesn't incorporate any security checks and
#!! is not recommended to be used in production environment as it is. Be sure to
#!! revise it and customize to your needs.


// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


// Support CORS
// header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // finish preflight CORS requests here
}


if ( !empty($_REQUEST[ 'debug' ]) ) {
    $random = rand(0, intval($_REQUEST[ 'debug' ]) );
    if ( $random === 0 ) {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}

// header("HTTP/1.0 500 Internal Server Error");
// exit;


// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Settings
// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";

$new_dir = $targetFile = './uploads/';

$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds
// echo '<pre>';
// print_r($_POST);

$filename_new = microtime(true);
if(!empty($_POST['file'])){
    $base64_image_content = $_POST['file'];
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
        $type = $result[2];
        $filename_new = $targetFile.$filename_new.".{$type}";
        if (file_put_contents($filename_new, base64_decode(str_replace($result[1], '', $base64_image_content)))){
//             echo '新文件保存成功：', $new_file;
            $newfile = microtime(true).'-'.rand(1,20).'.'.$type;
            $filename_new_2 = $new_dir.$newfile;
            $text = '大神蒜';
            //设置水印文字
            $color = '000000';
            $textLayer = ImageWorkshop::initTextLayer($text, __DIR__.'/ImageWorkshop-2.0.6/tests/Resources/fonts/yahei.ttf', 13, $color, 0);
            $pinguLayer = ImageWorkshop::initFromPath($filename_new);
//             $pinguLayer->resizeInPixel(400, 400, true, 0, 0, 'MM'); 
            $pinguLayer->resize(null,400, 400,true);
            $pinguLayer->addLayerOnTop($textLayer, 12, 12, "LB");
            $color = 'ffffff';
            $pinguLayer->save($new_dir,$newfile,true,$color,95); // We chose to show a JPG with a quality of 95%
            @unlink($filename_new);
            $filename_new = $filename_new_2;
            $message['status']=1;
            $message['message'] = '文件上传成功';
            $message['filename'] = pathinfo($filename_new,PATHINFO_BASENAME);
            
        }else{
            $message['status']=901;
            $message['message'] = '文件保存失败';
            $message['filename'] = pathinfo($filename_new,PATHINFO_BASENAME);
        }
    
    }else{
        $message['status']=900;
        $message['message'] = '文件类型无法匹配';
        $message['filename'] = pathinfo($filename_new,PATHINFO_BASENAME);
    }
    die('{"jsonrpc" : "2.0", "result" : '.json_encode($message).', "id" : "'.pathinfo($filename_new,PATHINFO_BASENAME).'"}');
}
//目录不存在
if( !is_dir($targetFile) ){
    //创建目录失败
    if(!mkdir($targetFile,777) ){
        $message['status'] = -2;
        $message['message'] = '目录创建失败';

    }
}
if (!empty($_FILES) ) {
    $tempFile = $_FILES['file']['tmp_name'];
    

    // Validate the file type
    $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
    $fileParts = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    $filename_new = $filename_new.'.' . $fileParts;
    $targetFile = $targetFile . $filename_new;
    if (in_array($fileParts,$fileTypes)) {
        if( move_uploaded_file($tempFile,$targetFile) ){
//             $newfile = microtime(true).'-'.rand(1,20);
//             $filename_new_2 = $new_dir.$newfile.'.'.$fileParts;
//             watermark('',$filename_new, $new_dir, $newfile.'.'.$fileParts);
            $message['status'] = 1;
            $message['filename'] = $filename_new_2;
            $message['message'] = '文件上传成功';
            $message['targetFile']=$targetFile;
        }else{
            $message['status'] = -3;
            $message['message'] = '文件移动失败';
        }
    } else {
        $message['status'] = -4;
        $message['message'] = '文件类型不对，文件类型只能是jpg,jpeg,gif,png';
    }
  
}else{
    $message['status'] = -1;
    $message['filename'] = '';
    $message['message'] = '上传文件不存在';

}

// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : '.json_encode($message).', "id" : "'.pathinfo($filename_new,PATHINFO_BASENAME).'"}');


function file_ext($filename){

    $file = fopen($filename, "rb");
    $bin = fread($file, 2); //只读2字节
    fclose($file);
    $strInfo = @unpack("c2chars", $bin);
    $typeCode = intval($strInfo['chars1'].$strInfo['chars2']);
    $fileType = '';
    switch ($typeCode)
    {
        case 7790:
            $fileType = 'exe';
            break;
        case 7784:
            $fileType = 'midi';
            break;
        case 8297:
            $fileType = 'rar';
            break;
        case 255216:
            $fileType = 'jpg';
            break;
        case 7173:
            $fileType = 'gif';
            break;
        case 6677:
            $fileType = 'bmp';
            break;
        case 13780:
            $fileType = 'png';
            break;
        default:
            $fileType = false;
    }
    
    return $fileType;
}

function watermark($text = '大神蒜',$file,$newdir,$newfile){
//   error_reporting(1); 
    empty($text) ? $text : $text = '大神蒜';
    //设置水印文字
    $textLayer = ImageWorkshop::initTextLayer($text, __DIR__.'/ImageWorkshop-2.0.6/tests/Resources/fonts/yahei.ttf', 13, 'ffffff', 0);
    $pinguLayer = ImageWorkshop::initFromPath($file);
    $pinguLayer->resizeInPixel(400, 400, true, 0, 0, 'MM'); 
    $pinguLayer->addLayerOnTop($textLayer, 12, 12, "LB");
    $pinguLayer->save($newdir,$newfile,true,'000000',95); // We chose to show a JPG with a quality of 95%
    @unlink($file);
}

function get_extension($file)
{
    substr(strrchr($file, '.'), 1);
}