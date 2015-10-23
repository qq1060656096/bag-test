<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\z\ZCommonSessionFun;
/* @var $model common\models\User */
?>
<!DOCTYPE html>
<!-- saved from url=(0036)http://m.xinli001.com/account/login/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8"> 
<title>登录 - 壹心理(手机版)</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"> 
<meta content="yes" name="apple-mobile-web-app-capable"> 
<meta content="black" name="apple-mobile-web-app-status-bar-style"> 
<meta content="telephone=no" name="format-detection"> 
<link href="./bag-test/css/mobile-register.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="./bag-test/css/common.css">
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>

<link rel="stylesheet" href="./bag-test/css/Font-Awesome-master/css/font-awesome.min.css">
<style>
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

 

    
    <section class="s_reg s_login">
    	<div></div>
    	<form action="<?php echo Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlLoginUserStr]);?>" id="form1" onsubmit="return false">
    		<input type="text" id="username" name="username" placeholder="邮箱/手机号码">
    		<p class="wrong_tip" id="username_tip"></p>
    		<input type="password" id="password" name="password" placeholder="密码">
    		<p class="wrong_tip" id="password_tip"></p>
    		<div class="btn_bg">
    			<input type="submit" id="submit" value="登录">
    		</div>
    		
    		<div class="link_btn">
    	    	<a href="http://m.xinli001.com/account/forget/" class="a_forget">忘记密码?</a>
    			<a href="http://m.xinli001.com/account/register/?next=http://m.xinli001.com/" class="a_reg">注册帐号</a>
    		</div>
    	</form>
    </section>
    

    <div class="qita">
    	<ul>
    		<li class="">
    			<a href="http://m.xinli001.com/qq/login/?next=http://m.xinli001.com/"><img src="./bag-test/logo/logo-qq.jpg" />使用QQ账号登录</a>
    		</li>
    		<li class="">
    			<a href="http://m.xinli001.com/weibo/login/?next=http://m.xinli001.com/"><img src="./bag-test/logo/logo-weibo.jpg" />使用新浪微博登录</a>
    		</li>
    		<li class="">
    			<a href="http://m.xinli001.com/renren/login/?next=http://m.xinli001.com/"><img src="./bag-test/logo/logo-weixin.jpg" />使用人人账号登录</a>
    		</li>
    	</ul>
    </div>

	<footer class="footer">
    	<div>
    		<p>
    			<a href="http://m.xinli001.com/feedback/">留言</a>
    			|<span id="userspan2"></span>
    			<a href="http://m.xinli001.com/mapp/">客户端下载</a>
    		</p>
    		<p>
    			粤ICP备12051153号<span>m.xinli001.com</span>
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
			window.location = '<?php echo Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlIndexUserStr]);?>';
		} else {
			alert('用户名或密码错误');
			$this.data('lock', false);
			$('#submit').val(value);
		}
	});
	return false;
});
</script>



</body></html>
 