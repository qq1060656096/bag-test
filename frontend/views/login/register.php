<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\z\ZCommonFun;
use common\z\ZController;
/* @var $model common\models\User */
?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->renderFile(__DIR__.'/../layouts/title.php');?>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"> 
<meta content="yes" name="apple-mobile-web-app-capable"> 
<meta content="black" name="apple-mobile-web-app-status-bar-style"> 
<meta content="telephone=no" name="format-detection"> 
<link href="./bag-test/css/mobile-register.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="./bag-test/css/common.css">
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>

<link rel="stylesheet" href="./bag-test/css/Font-Awesome-master/css/font-awesome.min.css">
<style>
.survey-form{
	text-align: center;
    margin-top: 30px;
}
.help-block{
	margin-bottom: 10px;
	color: red;
}
.btn_bg{
	width:39% !important;
	background-color: #245D94;
    height: 44px;
    padding: 0;
    width: 90%;
    border-radius: 5px;
    margin: 0 auto;
    text-align: center;
    padding: 0 9px;
	float: left;
	    background: #FE8C78;
    color: white;
	margin-left: 3%;
	margin-top: 20px;
}
.btn_bg button{
   
    border-radius: 5px;
	height: 100%;
    width: 100%;
    background: none;
    border: none;
    color: white;
    font-weight: bold;
}
.btn_bg2{

	margin-right: 3%;
	float: right;
}
</style>
<body>
    <div id="main_body">
    	<header class="s_header">
    		<nav>
    			<a href="<?php echo Yii::$app->homeUrl;?>" class="bg"> <span class="fa fa-home"></span></a>
    			<span style="font-size: 1.4rem"><?php echo ZController::$site_name;?>站内账户注册</span>
    			<span id="more">&nbsp;&nbsp;&nbsp;&nbsp;</span>
    		</nav>
    	</header>
    	
    </div>
    
    <section class="survey-form ">
    
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'user')->textInput(['maxlength' => true])->label('账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;号') ?>
        <?= $form->field($model, 'pass')->textInput(['maxlength' => true])->label('密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;码') ?>
        
        <div class="form-group field-user-pass2 required">
            <label class="control-label" for="user-pass2">确认密码</label>
            <input type="text" id="user-pass2" class="form-control" name="User[pass]" value="<?php echo $model->pass;?>" maxlength="255">
            
            <div class="help-block"></div>
        </div>

        <div class="form-group">
            <div class="btn_bg">
                <button type="button"  onclick="javascript:window.top.document.location='<?php echo Yii::$app->urlManager->createUrl(['login/login'])?>' " 
                    class="">登录</button>
            </div>
  
            <div class="btn_bg btn_bg2">
                <button type="submit" class="">注册</button>
            </div>
        </div>
        <div class="form-group">
            <?php 
            //ZCommonFun::print_r_debug($model->errors);
            
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    
    </section>    
<script>
var is_submit = false;
$('form').submit(function(){
	
	var $this = $(this);
	
	
	var username = $.trim($('#user-user').val());
	var check1 = false, check2 = false,check3=false;
	if(username == '') {
		$('.field-user-user .help-block').html('请输入账号');
	} else {
		$('.field-user-user .help-block').html('');
		check1 = true;
	}
	var password = $.trim($('#user-pass').val());
	if(password == '') {
		$('.field-user-pass .help-block').html('请输入密码');
	
	} else {
		$('.field-user-pass .help-block').html('');
		check2 = true;
	}

	if(password.length<6 && check2) {
		$('.field-user-pass .help-block').html('密码不能小于6位');
		check2 = false;
	} else if(check2 ){
		$('.field-user-pass .help-block').html('');
		check2 = true;
	}

	var password2 = $.trim($('#user-pass2').val());
	if(password2 == '') {
		$('.field-user-pass2 .help-block').html('请输入确认密码');
		
	} else {
		$('.field-user-pass2 .help-block').html('');
		check3 = true;
	}
	if(!check1|| !check2 || !check3){
		return false;
	}
	
	if(password2!==password){
		$('.field-user-pass2 .help-block').html('两次输入密码不一致');
		return false;
	}
	if(is_submit){
		return false;
	}else{
		is_submit = true;
    	var value = $('#submit').val();
    	$('#submit').val('提交中...');
	return true;
	}
	
});
</script>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>