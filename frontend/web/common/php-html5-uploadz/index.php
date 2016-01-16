<?php
if (defined('run')){
    exit;
}/*
use PHPImageWorkshop\ImageWorkshop as ImageWorkshop;
require_once(__DIR__.'/ImageWorkshop-2.0.6/tests/autoload.php');

//设置水印文字
$text = '大神蒜';
$textLayer = ImageWorkshop::initTextLayer($text, __DIR__.'/ImageWorkshop-2.0.6/tests/Resources/fonts/yahei.ttf', 13, 'ffffff', 0);
$filename = __DIR__.'/sample1.jpg';
$newfile  = 'new.jpg';
$pinguLayer = ImageWorkshop::initFromPath($filename);
$pinguLayer->resizeInPixel(400, 400, true, 0, 0, 'MM'); 
$pinguLayer->addLayerOnTop($textLayer, 12, 12, "LB");
$pinguLayer->save('./',$newfile,true,'000000'); // We chose to show a JPG with a quality of 95%

*/
?>
<img src="new.jpg" />