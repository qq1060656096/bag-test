<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\z\ZCommonSessionFun;
use common\z\oauth\qq\QQ;
use common\z\ZController;
/* @var $model common\models\User */
$this->title = '登录';

// $qq = new QQ();
// $qq_login = $qq->qq_login();

$qq_login = Yii::$app->urlManager->createUrl(['api/login-qq']);

$gourl = isset($_GET['gourl'])  && !empty($_GET['gourl'])? $_GET['gourl']:'';
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
h1{
	text-align: center;
    font-size: 2em;
    font-weight: bold;
    margin-top: 15px;
	color: #999;
	display: block;
}
.btn_bg{
	width:39% !important;
	float: left;

}
.btn_bg2{
	float: right;
}
.footer-nav .fa{
	display: inline-block;
	vertical-align: middle;
	font-size: 1.2em;

}
.footer-nav .fa:before{
	color: #FE8C78;
}
</style>

</head>
<body>
    <div id="main_body">
    	<header class="s_header">
    		<nav>
    			<a href="javascript:history.back();" class="bg"> <span class="fa fa-home"></span></a>
    			<span style="font-size: 1.4rem">登录</span>
    			<span id="more">&nbsp;&nbsp;&nbsp;&nbsp;</span>
    		</nav>
    	</header>

    </div>


    <section  class="s_reg s_login" style="margin-top: 100px;margin-bottom: 0;">

        <div class="qita">
        	<ul>
        		<li class="">
        			<a href="<?php echo $qq_login; ?>"><img src="./bag-test/logo/logo-qq.jpg" />使用QQ账号登录</a>
        		</li>
        		<li class="">
        			<a href="<?php echo Yii::$app->urlManager->createUrl(['api/login-weibo']); ?>"><img src="./bag-test/logo/logo-weibo.jpg" />使用新浪微博登录</a>
        		</li>
        		<li class="">
        			<a href="<?php echo Yii::$app->urlManager->createUrl(['api/login-wei-xin']); ?>"><img src="./bag-test/logo/logo-weixin.jpg" />使用微信登录</a>
        		</li>
        	</ul>
        </div>
    </section>
    <h1>
        <?php echo ZController::$site_name;?>账号登录
    </h1>
    <section class="s_reg s_login" style="margin-top:-25px;">
    	<div></div>
    	<form action="<?php echo Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlLoginUserStr]);?>" id="form1" onsubmit="return false">
    		<input type="text" id="username" name="username" placeholder="邮箱/手机号码">
    		<p class="wrong_tip" id="username_tip"></p>
    		<input type="text" id="password" name="password" placeholder="密码">
    		<p class="wrong_tip" id="password_tip"></p>

    		<div class="btn_bg">
    			<input type="button"  value="注册" onclick="javascript:window.top.document.location='<?php echo Yii::$app->urlManager->createUrl(['login/register','gourl'=>($gourl)])?>' ">
    		</div>

    		<div class="btn_bg btn_bg2">
    			<input type="submit" id="submit" value="登录">
    		</div>

    		<div class="link_btn" style="display:none;">
    	    	<a href="" class="a_forget">忘记密码?</a>
    			<a href="" class="a_reg">注册帐号</a>
    		</div>
    	</form>
    </section>




	<footer class="footer">
    	<div sytle="text-align: center;">
    		<p>
    			商务联系： dashensuan@qq.com
    		</p>
    		<p>
    			大神蒜，可以自己创建小测试的网站
    		</p>
    		<p>
    			京ICP备09042499号-10<span><a href="http://dashensuan.com" >dashensuan.com</a></span>
    		</p>
    	</div>
    </footer>
</div>
<script>
$('#more').click(function(){
	if($('#toplist').css('display')!='none') {
		$('#toplist').hide();
	} else {
		$('#toplist').show();
	}
});
</script>

<script>
$('#form1').submit(function(){

	var $this = $(this);
	if($this.data('lock')) {
		return false;
	}

	var username = $.trim($('#username').val());
	var check1 = false, check2 = false;
	if(username == '') {
		$('#username_tip').html('请输入邮箱/手机号码');
	} else {
		$('#username_tip').html('');
		check1 = true;
	}
	var password = $.trim($('#password').val());
	if(password == '') {
		$('#password_tip').html('请输入密码');
		return false;
	} else {
		$('#password_tip').html('');
		check2 = true;
	}
	if (!(check1 && check2)) {
		return false;
	}
	var value = $('#submit').val();
	$('#submit').val('提交中...');

	$this.data('lock', true);
	var url = $this.attr('action');
	var data = $this.serialize();
	$.post(url, data, function(resp) {
		if (resp.code == 0) {
			var url = '<?php echo Yii::$app->request->getHostInfo().urldecode($gourl);?>';
// 			alert(url);
			window.top.document.location = url;
		} else {
			alert('用户名或密码错误');
			$this.data('lock', false);
			$('#submit').val(value);
		}
	});
	return false;
});
</script>



<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>
