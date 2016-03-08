<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserProfile;
use common\z\ZCommonSessionFun;
use common\z\ZCommonFun;
use common\z\ZController;
use common\models\OauthBind;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

$this->title = ZController::$site_name.'账号绑定';
echo $this->renderFile(__DIR__ . '/../layouts/head.php');

$sessionUser = ZCommonSessionFun::get_user_session();

$const_BindList = OauthBind::constBindList();
$model_OauthBind = new OauthBind();
$uid = ZCommonSessionFun::get_user_id();
$user_BindList = $model_OauthBind->getUserBindList($uid);
?>

<link href="./bag-test/bootstrap/bootstrap.min.css" rel="stylesheet"
	media="screen">
<link href="./bag-test/bootstrap/datetimepicker.css" rel="stylesheet"
	media="screen">
<style>
div.notice {
	margin: 0;
}

.s_login div {
	padding: 2px;
	margin: 0;
}

label, label input {
	vertical-align: middle;
	width: 30px;
	display: inline-block;
	text-align: right;
	padding-right: 5px;
}

.s_reg input[type="text"], .s_reg input[type="password"], .s_reg textarea
	{
	padding: 0 5px;
	height: 40px;
	border: 1px solid #B1B1B1;
	border: 1px solid #a7bed4;
	border-radius: 5px;
	width: 220px;
}

.a-left, .a-right {
	padding: 0px 5px;
	float: left;
	border: 1px solid #ddd;
	display: inline-block;
}

.user-info {
	border-bottom: 1px solid #ddd;
	margin-top: 15px;
}
.user-info1{
	margin-top: 50px;
	padding-bottom: 10px;
}
.user-info table {
	width: 100%;
}

.user-info td {
	width: 50%;
	text-align: center;
}

.user-info td.td-r {
	text-align: left;
	padding-bottom: 5px;
}

.user-info2 {
	text-align: center;
	padding-bottom: 5px;
}

.user-info2>input {
	width: 80%;
	display: inline-block;
	border: 1px solid #ddd;
	background: #FE8C78;
	padding: 5px;
	margin: auto;
	color: #fff;
}

.user-info2>input.btn-z-bind {
	margin-top: 12px;
	margin-bottom: 12px;
}
.input-wrap{
	margin-top: 10px;
}
.bind-row{
	border: 1px solid #999;
    background: none;
    padding: 5px;
    color: #999;
    min-width: 75px;
    display: inline-block;
    text-align: center;
}
.bind-exists{
	border: 1px solid #FE8C78;
	background: #FE8C78;
	color: #fff;
}
</style>
<div id="main_body">
	<header class="s_header">
		<nav>


			<span style="font-size: 1.4rem"><?php echo $this->title;?></span>
		</nav>
	</header>

	<div class="user-info user-info1">
		<table>
			<tr>
				<td class="td-l"></td>

			</tr>
			<tr>
				<td class="td-l">当前<span style="color:#FE8C78;">账号</span>登录</td>
				<td class="td-r"></td>
			</tr>
		</table>
	</div>


	<section class="s_reg s_login">
		<div class="notice" title="太好了，完成最后一步吧^o^~">&nbsp;</div>
    	<?php $form = ActiveForm::begin(); ?>
    	   <div class="input-wrap">
    			<div class="form-group field-userprofile-nickname">
    			     
    				<label class="control-label" for="userprofile-nickname">账号</label> 
    				<?php
    				$user_info2 = ZCommonSessionFun::get_login_type();
    				if($user_info2['register_type']=='user'):   
    				?>
    				    <a class="bind-row bind-exists">已注册</a>	
    				<?php 
    				else:
    				?>
    				    <a class="bind-row">未注册</a>	
    				<?php endif;?>
    			</div>
    		</div>
    	    <?php 
    	    foreach ($const_BindList as $key=>$row):
    	       if($key=='user')
    	           continue;
    	       $url = '';
    	       switch ($key){
    	           case OauthBind::typeQQ:
    	               $url = Yii::$app->urlManager->createUrl(['api/login-qq']);
    	               break;
	               case OauthBind::typeWeiBo:
	                   $url = Yii::$app->urlManager->createUrl(['api/login-weibo']);
	                   break;
                   case OauthBind::typeWeiXin:
                       $url = Yii::$app->urlManager->createUrl(['api/login-wei-xin']);
                       break;
    	       }
    	       
    	    ?>   
    		<div class="input-wrap">
    			<div class="form-group field-userprofile-nickname">
    			     
    				<label class="control-label" for="userprofile-nickname"><?php echo $row;?></label> 
    				<?php 
    				if(OauthBind::bindTypeIsBind($key, $user_BindList)):   
    				?>
    				    <a herf="#" class="bind-row bind-exists">已绑定</a>	
    				<?php 
    				else:
    				?>
    				    <a  href="<?php echo $url;?>" class="bind-row">绑&nbsp;&nbsp;定</a>	
    				<?php endif;?>
    			</div>
    		</div>
    		<?php endforeach;?>
    	<?php ActiveForm::end(); ?>
    </section>

</div>



<script type="text/javascript" src="./bag-test/bootstrap/jquery.min.js"></script>

<script src="./bag-test/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript"
	src="./bag-test/bootstrap/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
// (function($){
// 	$.fn.datetimepicker.dates['zh-CN'] = {
// 			days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
// 			daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
// 			daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
// 			months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
// 			monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
// 			today: "今天",
// 			suffix: [],
// 			meridiem: ["上午", "下午"]
// 	};
// }(jQuery));
$(document).ready(function(){
// 	 $("#userprofile-birthday").datetimepicker({
// 		 format:'yyyy-mm-dd',
// 		 language:'zh-CN',
// 		 startView:4,
// // 		 viewSelect:'day',
// 		 todayBtn: true,
// 		 todayHighlight:true,
// 		 minView: 2,
// 		 autoclose: true
		
//      }).on('changeDate', function(ev){
//     	    console.log(ev.date);
//      });
});
   
</script>

<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>