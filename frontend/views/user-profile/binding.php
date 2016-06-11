<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\z\ZCommonFun;
use common\z\ZController;
/* @var $model common\models\User */

$gourl = isset($_GET['gourl'])  && !empty($_GET['gourl'])? $_GET['gourl']:'';
$LoginRedirect = new LoginRedirectYii2();
$gourl = $LoginRedirect->getFirstVisitUrl() ;
$gourl = $gourl ? $gourl : 'survey/my';
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
.control-label{
	display: none;
}
.btn_bg{
	/*width:39% !important;*/
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
.btn1{
	width: 35%;
    margin-bottom: 20px;
	margin-top: 0;
}
.btn1:first-child{
	float: left;
	margin-left: 3%;
}
.btn1.active,.bind0.active{
	background-color: #fff;
	background: #fff;
	color: #000 !important;

}
.btn1.active{
border: 1px solid #FE8C78;
}
.hide{
	display: none;
}
</style>
<body>
    <div id="main_body">
    	<header class="s_header">
    		<nav>
    			<a href="<?php echo Yii::$app->homeUrl;?>" class="bg"> <span class="fa fa-home"></span></a>
    			<span style="font-size: 1.4rem"><?php echo ZController::$site_name;?>账号绑定</span>
    			<span id="more">&nbsp;&nbsp;&nbsp;&nbsp;</span>
    		</nav>
    	</header>

    </div>

    <section class="survey-form ">
        <div class="btn_bg btn_bg2 btn1 active">
            <button type="button"  class="bind0 bind1 active">绑定已有账号</button>
        </div>
        <div class="btn_bg btn_bg2 btn1">
            <button type="button" class="bind0 bind2">绑定新账号</button>
        </div>
        <br />
        <br />
        <br />
        <br />
        <?php $form = ActiveForm::begin(['action' => ['login/register','gourl'=>urldecode($gourl)]]); ?>
        <?= $form->field($model, 'user')->textInput(['maxlength' => true,'placeholder'=>'邮箱/手机号'])->label('账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;号') ?>
        <?= $form->field($model, 'pass')->textInput(['maxlength' => true,'placeholder'=>'密码'])->label('密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;码') ?>

        <div class="form-group field-user-pass2 required hide">
            <label class="control-label" for="user-pass2">确认密码</label>
            <input type="text" id="user-pass2" class="form-control" name="User[pass]" value="<?php echo $model->pass;?>" maxlength="255" placeholder="确认密码">

            <div class="help-block"></div>
        </div>

        <div class="form-group">
            <!--
            <div class="btn_bg">
                <button type="button"  onclick="javascript:window.top.document.location='<?php echo Yii::$app->urlManager->createUrl(['login/login'])?>' "
                    class="">登录</button>
            </div>
            -->
            <div class="btn_bg btn_bg2" >
                <button type="submit" id="submit" class="">绑定</button>
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
var is_login  = true;

$('form').submit(function(){

	var $this = $(this);


	var username = $.trim($('#user-user').val());
	var check1 = false, check2 = false,check3=false;
	if(username == '') {
		$('.field-user-user .help-block').html('请输入账号');
	} else {
		$('.field-user-user .help-block').html('');
		check1 = true;
		if( is_phone(username) ){

	    }else if( is_mail(username) ){

		}else{
			check1 = false;
	    	$('.field-user-user .help-block').html('帐号不是手机或邮箱哦？');
		}
		if(is_login){
			check1 = true;
			$('.field-user-user .help-block').html('');
		}
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
		if(is_login){
			$('.field-user-pass .help-block').html('');
			check2 = true;
		}
	} else if(check2 ){
		$('.field-user-pass .help-block').html('');
		check2 = true;
	}

	var password2 = $.trim($('#user-pass2').val());
	if(is_login){
		password2 = password;
	}
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
    	$('#submit').html('提交中...');
    	setTimeout(function(){}, 200);
    	var login_url = '<?php echo Yii::$app->urlManager->createUrl(['login/login']); ?>';
    	var regist_url = '<?php echo Yii::$app->urlManager->createUrl(['login/register','is_ajax'=>'1']); ?>';
    	var submit_url = '';
    	if(is_login){
    		submit_url = login_url;
    		var data = {"username":username,"password":password}
    		$.post(submit_url, data, function(resp) {
    			if (resp.code == 0) {
    				var url = '<?php echo Yii::$app->urlManager->createUrl($gourl);?>';
//    	 			alert(url);
    				window.top.document.location = url;
    			} else {
    				is_submit = false;
    				$('#submit').val('绑定');
    				alert('用户名或密码错误');
    				$this.data('lock', false);
    				$('#submit').html("绑定");
    			}
    		});
        }else{
        	submit_url = regist_url;
        	var data = $('form').serialize();
        	$.post(submit_url, data, function(resp) {
        		if (resp.code == 0) {
        			var url = '<?php echo Yii::$app->urlManager->createUrl($gourl);?>';
//         			alert(url);
        			window.top.document.location = url;
        		} else {
        			alert(resp.msg);
        			$this.data('lock', false);
        			$('#submit').val(value);
        			is_submit = false;
        			$('#submit').html("绑定");
        		}
        	});
        }
 	   return false;
	}

});

function is_phone(str){
	var pattern = /^1\d{10}$/;
    return is_valid(pattern,str);
}
function is_mail(str){
	var pattern = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
    return is_valid(pattern,str);
}
function is_valid(pattern,str){
	if(pattern.test(str))
		 return true;
	 return false;
}

$(".bind1,.bind2").click(function(){
	$(".bind1,.bind2").removeClass('active');
	$(".btn1").removeClass('active');
	$(this).addClass('active');
	$(this).parent().addClass('active');
	var has_class = $(this).hasClass('bind1');
	has_class ? $(".field-user-pass2").addClass('hide') : $(".field-user-pass2").removeClass('hide');
	has_class ? is_login=true : is_login=false;
	return false;
});
</script>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>