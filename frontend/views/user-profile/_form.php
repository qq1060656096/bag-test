<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserProfile;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

echo $this->renderFile(__DIR__.'/../layouts/head.php');
?>
<div id="main_body">
    <header class="s_header">
		<nav>


			 <span style="font-size: 1.4rem"><?php echo $this->title;?></span>
		</nav>
	</header>
	<section class="s_reg s_login">
    	<div class="notice" title="太好了，完成最后一步吧^o^~">&nbsp;</div>
    	<?php $form = ActiveForm::begin(); ?>
    	
    		
    		<div class="input-wrap">
    			<?= $form->field($model, 'nickname')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'昵称']) ?>
    		</div>
    	
    		<div class="input-wrap">
    			<?= $form->field($model, 'sex')->dropDownList(UserProfile::$sexData,['maxlength' => true,'class'=>'','placeholder'=>'性别']) ?>
    		</div>
    		<div class="input-wrap">
    			<?= $form->field($model, 'birthday')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'生日']) ?>
    		</div>
    		<div class="input-wrap">
    			<?= $form->field($model, 'address')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'地址']) ?>
    		</div>
    		<div class="input-wrap">
    			<?= $form->field($model, 'intro')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'简介']) ?>
    		</div>
    		<div class="input-wrap">
    			<?= $form->field($model, 'qq')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'QQ']) ?>
    		</div>
    		
    		<div class="input-wrap">
    			<?= $form->field($model, 'school')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'学校']) ?>
    		</div>
    		<input type="submit" id="submit" value="完 成">
    	<?php ActiveForm::end(); ?>
    </section>

</div>


<link href="./bag-test/bootstrap/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="./bag-test/bootstrap/datetimepicker.css" rel="stylesheet" media="screen">
<style>
div.notice{
margin: 0;
}
.s_login div{
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
.s_reg input[type="text"], .s_reg input[type="password"], .s_reg textarea {
    padding: 0 5px;
    height: 40px;
    border: 1px solid #B1B1B1;
    border: 1px solid #a7bed4;
    border-radius: 5px;
    width: 220px;
}
</style>
<script type="text/javascript" src="./bag-test/bootstrap/jquery.min.js"></script>    

<script src="./bag-test/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="./bag-test/bootstrap/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
(function($){
	$.fn.datetimepicker.dates['zh-CN'] = {
			days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
			daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
			daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
			months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
			monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
			today: "今天",
			suffix: [],
			meridiem: ["上午", "下午"]
	};
}(jQuery));
$(document).ready(function(){
	 $("#userprofile-birthday").datetimepicker({
		 format:'yyyy-mm-dd',
		 language:'zh-CN',
		 startView:4,
// 		 viewSelect:'day',
		 todayBtn: true,
		 todayHighlight:true,
		 minView: 2,
		 autoclose: true
		
     }).on('changeDate', function(ev){
    	    console.log(ev.date);
     });
});
   
</script> 

<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>