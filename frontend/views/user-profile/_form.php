<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserProfile;
use common\z\ZCommonSessionFun;
use common\z\ZCommonFun;
use common\z\ZController;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

echo $this->renderFile(__DIR__.'/../layouts/head.php');

$sessionUser = ZCommonSessionFun::get_user_session();
?>

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

.a-left,.a-right{
	padding: 0px 5px;
    float: left;
    /*border: 1px solid #ddd;*/
	display: inline-block;
	color: #999;
}
.user-info{
	border-bottom: 1px solid #ddd;
	margin-top: 15px;
	
}
.user-info table{
	width: 100%;
}
.user-info td{
	width: 40%;
	text-align: center;
}
.user-info td.td-r{
	width: 60%;
	text-align: left;
	padding-bottom: 5px;
}
.user-info2{
	text-align: center;
	padding-bottom: 5px;
}
.user-info2>input{
	width: 80%;
	display: inline-block;
	border: 1px solid #ddd;
	background: #FE8C78;
	padding: 5px;
	margin: auto;
	color: #fff;
	
}
.user-info2>input,.user-info2 input.btn-z-bind{
	font-size: 13px !important;
	font-weight: 100;
}
.user-info2>input.btn-z-bind{
	margin-top: 12px;
	margin-bottom: 12px;
	
}
</style>
<div id="main_body">
    <header class="s_header">
		<nav>


			 <span style="font-size: 1.4rem"><?php echo $this->title;?></span>
		</nav>
	</header>
	
	<div class="user-info">
    	<table>
    		<tr>
    			<td class="td-l">
    			     头像
    			</td>
    			<td class="td-r">
    			    <?php echo $model->getHeadImage0() ? '<img id="head_image" width="48" height="48" src="'.$model->getHeadImage0().'"/>': '<i class="fa fa-user user-image  common-color"></i>'?>
    				
    			</td>
    		</tr>
    		<tr>
    			<td class="td-l">
    			     昵称
    			</td>
    			<td class="td-r">
    			    <a class="a-left">
    			         <?php echo !empty($model->nickname) ? $model->nickname : '暂无昵称'?>
    			    </a>
    			</td>
    		</tr>
    	</table>
    </div>
    
    <div class="user-info user-info2">
        
        
        <input type="button"  class="btn-z-change"
            onclick="javascript:location.href='<?php echo Yii::$app->urlManager->createUrl(['user-profile/change-pass']);?>';" 
            value="修改<?php echo ZController::$site_name;?>密码" />
        
        <input type="button"  class="btn-z-bind"   
            onclick="javascript:location.href='<?php echo Yii::$app->urlManager->createUrl(['user-profile/bind-list']);?>';" 
            value="绑定QQ、微信、微博、账号" />
        
    </div>		
    
	<section class="s_reg s_login">
    	<div class="notice" title="太好了，完成最后一步吧^o^~">&nbsp;</div>
    	<?php $form = ActiveForm::begin(); ?>
    	   <?= $form->field($model, 'head_image')->hiddenInput(['maxlength' => true,'class'=>'','placeholder'=>'头像'])->label(false) ?>
    		 <input id="upload" type="file" name="file" style="display:none;"/>
            
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
    			<?= $form->field($model, 'intro')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'限20个字'])->label('签名') ?>
    		</div>
    		<div class="input-wrap">
    			<?= $form->field($model, 'qq')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'QQ']) ?>
    		</div>
    		
    		<div class="input-wrap">
    			<?= $form->field($model, 'school')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'学校']) ?>
    		</div>
    		<input type="submit" id="submit" value="保存">
    	<?php ActiveForm::end(); ?>
    </section>

</div>



<script type="text/javascript" src="./bag-test/bootstrap/jquery.min.js"></script>    

<script src="./bag-test/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="./bag-test/bootstrap/bootstrap-datetimepicker.min.js"></script>
<script src="common/php-html5-uploadz/ZHtml5Upload.js">
</script>
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

    $("#head_image").click(function(){
    	$("#upload").click();
     });
	 $("#upload").ZHtml5Upload({
			uploadSucess: function(result,uploadz){
				var json = $.parseJSON(result);
				//console.log( json );
				if( json.result.status==1 && json.id){
					$("#userprofile-head_image").val('<?php echo Yii::$app->request->baseUrl,UPLOAD_DIR;?>'+json.id);
			    }
				
				//console.log(this);
				if( uploadz.isReaderFile ){
			
					$("#head_image").attr('src','<?php echo Yii::$app->request->baseUrl,UPLOAD_DIR;?>'+json.id);
				}
				console.log( uploadz.base64Data );
			},
			uploadError: function(result){
				console.log( result);
			}
		});
});
   
</script> 

<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>