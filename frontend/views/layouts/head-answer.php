<?php 
use common\z\ZCommonFun;

?>
<!DOCTYPE html>
<!-- saved from url=(0037)http://m.xinli001.com/ceshi/99897421/ -->
<html class="ui-mobile">
<head>
<?php echo $this->renderFile(__DIR__.'/../layouts/title.php');?>
<meta name="apple-itunes-app" content="app-id=591341152">
<meta name="viewport"
	content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	
<link rel="stylesheet" href="./bag-test/css/jquery.mobile-1.2.0.min.css">
<link rel="stylesheet" href="./bag-test/css/mobile.css">
<link href="./bag-test/css/csshare.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="./bag-test/css/common.css">
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>

<style>

.question-item{
	display: none;
}
.question-item:first-child{
	display: block;
}
</style>

</head>
<body class="ui-mobile-viewport ui-overlay-c">
<?php 
$url = Yii::$app->requestedAction->controller->id.'/'.Yii::$app->requestedAction->id;
// echo $url;
// ZCommonFun::print_r_debug($this);
// exit;

global $share_url,$image;
$aid = isset($model_Answer->a_id)&& $model_Answer->a_id>0?$model_Answer->a_id :0;
$id = isset($model->id)? $model->id : 0;
$share_url = yii::$app->urlManager->createAbsoluteUrl([$url,'id'=>$id,'aid'=>$aid]);
$image = isset( $model->images->image ) ? UPLOAD_DIR.$model->images->image : DEFAULT_IMAGE;
$image = Yii::$app->request->hostInfo.Yii::$app->request->baseUrl.'/'.$image;

?>