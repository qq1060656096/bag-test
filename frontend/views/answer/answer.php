<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZController;
/* @var $model common\models\Survey */
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="description" itemprop="description"
	content="<?php echo ZController::$site_name; ?>" id="qDesc">
<meta name="keywords" content="<?php echo $model->title; ?>">
<title>
<?php 
echo empty(ZController::$site_name) ? '':ZController::$site_name.' - ';
echo $this->title,' ',$model->title;
?>
</title>
<link rel="stylesheet" href="./css/v1.css">

</head>
<body>
	<div id="mainbox" class="main">
		<div id="bg1" class="bg1">
			<img id="topimg1" class="topimg imgshow" src="./images/clips1.png">
			<div class="bg2"></div>
			<div id="maintext-title" class="maintext maintext-ready mainactive maintext-play">
				<div id="home-title" class="maintitle"><?php echo $model->title;?></div>
				<div id="home-desc" class="maindesc">
				    <?php 
				    if($image)
				        echo '<img class="image" src= "',$image,'" title="',$model->title,'"/>';
				    echo $model->intro;
				    ?>
				</div>
			</div>
			
			<?php $form = ActiveForm::begin(); ?>
			<!-- question start  -->
			<div  class="maintext maintext-play">
				<div class="maintitle">
				    <?php echo $model->title;?>
				</div>
				<div id="question" class="question">
				    
				    
					<p id="question-text">
					   <?php 
    				    if($image)
    				        echo '<img class="image" src= "',$image,'" title="',$model->title,'"/>';
    				    echo $model->intro;
    				    ?>
					</p>
					<img id="question-pic"
						style="max-width: 100%; max-height: 200px; margin: 0 auto; display: block;"
						src="">
				</div>
				<div  class="btnbox btn-play">
    				<span id="tia" vel="a" num="你的姓名" class="span" >
    				    <input type="text" id="name" name="name" value="" size="15">   
    				</span>
    				
    				<span id="tia" vel="a" num="你的年龄" class="span" >
    				    <input type="text" id="age" name="age" value="" size="15">   
    				</span>
    			</div>
    			<div  class="btnbox btn-ready btnactive btnbox-submit">
    				<p >提交测试</p>
    			</div>
			</div>
			<!-- question end  -->
			
			
			<?php ActiveForm::end(); ?>
			
			
			<div id="maintext-result" class="maintext maintext-result">
				<div id="result-title" class="resuletitle"></div>
				<div id="result-desc" class="resuledesc"></div>
			</div>

			<!-- btn -->
			<div id="gameready" class="btnbox btn-ready btnactive">
				<p >开始测试</p>
			</div>

			

			<div id="gameend" class="btnbox btn-more">
				<p >更多测试</p>
			</div>
		</div>
	</div>
	
    <script type="text/javascript" src="./js/jquery.js"></script>
    <link href="./js/jquery-ui.css" rel="stylesheet" type="text/css"/>  
    <script src="./js/jquery-ui.min.js"></script> 
	<script type="text/javascript">
	$(document).ready(function(){
		$.datepicker.regional["zh-CN"] = { closeText: "关闭", prevText: "&#x3c;上月", nextText: "下月&#x3e;", currentText: "今天", monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"], dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"], dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"], weekHeader: "周", dateFormat: "yy-mm-dd", firstDay: 1, isRTL: !1, showMonthAfterYear: !0, yearSuffix: "年" };
	    //设置默认语言
	    $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);
	    //日期插件
	    $( "#age" ).datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '-60'
		});
	    
		var index = 0; 
		$("#gameready,.btn-play .span").click(function(){
			//zhao start 屏蔽 name和age元素动画	
			var name = $(this).find('#name');
			if( name && name.val()=="" ){
				
			    return true;
		    }
			var age = $(this).find('#age');
			if( age && age.val()=="" ){
			
			    return true;
		    }
			//zhao end 屏蔽 name和age元素动画	
			$(".maintext-play").eq(index).animate({marginLeft:"-"+$(".maintext-play").eq(index).width()},'slow',function(){
				$(".maintext-play").eq(index).hide();
				$(".maintext-play").eq(index+1).fadeIn('slow');
				$("#gameready").hide();
				index++;
		    });	    
		});	

		$(".btnbox-submit").click(function(){

			var name = $('#name');
			if( name && name.val()=="" ){
				alert("请输入姓名");
			    return true;
		    }
			var age = $('#age');
			if( age && age.val()=="" ){
				alert("请输入年龄");
			    return true;
		    }
		    $("form").submit();
	   });
		   
    });
		
	</script>
</body>
</html>
