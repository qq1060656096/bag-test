<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZController;
/* @var $model common\models\Survey */
/* @var $model_AnswerUser common\models\AnswerUser */
/* @var $model_SurveyResulte common\models\SurveyResulte; */
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="description" itemprop="description"
	content="<?php echo ZController::$site_name;?>" id="qDesc">
<meta name="keywords" content="<?php echo $model->title;?>">
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
				
				<div  class="maindesc">
				    <p>
				        <?php 
				        echo $model_SurveyResulte->name;
				        echo $model_AnswerUser->answer_name ? '<span class="answer-name">'.$model_AnswerUser->answer_name.'</span>' : '';
				        echo $model_SurveyResulte->value;
				        ?>
				    </p>
				    <hr />
				    <div id="home-title" class="maintitle"><?php echo $model->title;?></div>
				    <?php 
				    if($image)
				        echo '<img class="image" src= "',$image,'" title="',$model->title,'"/>';
				    ?>
				    
				    <?php echo $model->intro;?>
				</div>
			</div>
			
			
			<div id="maintext-result" class="maintext maintext-result">
				<div id="result-title" class="resuletitle"></div>
				<div id="result-desc" class="resuledesc"></div>
			</div>

			<!-- btn -->
			<div id="gameready" class="btnbox btn-ready btnactive">
				<p>我要测一测</p>
			</div>

			

			<div id="gameend" class="btnbox btn-more">
				<p >更多测试</p>
			</div>
		</div>
	</div>
	
    <script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
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
