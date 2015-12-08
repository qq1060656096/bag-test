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
<meta itemprop="name" content="6种玫瑰颜色找出你的恋爱基因--【超准】" id="qTitle">
<meta name="description" itemprop="description"
	content="最全最准测试平台--【微测试】" id="qDesc">
<meta itemprop="image"
	content="http://7xlmq3.com1.z0.glb.clouddn.com/quce/1449319193hta9C.png"
	id="qImg">
<meta name="keywords" content="6种玫瑰颜色找出你的恋爱基因">
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
				<div id="home-desc" class="maindesc"><?php echo $model->intro;?></div>
			</div>
			<div  class="maintext maintext-play">
				<div class="maintitle">6种玫瑰颜色找出你的恋爱基因</div>
				<div id="question" class="question">
					<p id="question-text">现在，请想象自己是一朵美丽绽放的玫瑰花，你觉得那些开在你身上的是什么颜色的玫瑰呢？</p>
					<img id="question-pic"
						style="max-width: 100%; max-height: 200px; margin: 0 auto; display: block;"
						src="">
				</div>
				<div  class="btnbox btn-play">
    				<span id="tia" vel="a" num="a" class="span" >紅色</span><span
    					id="tib" vel="b" num="b" class="span" >蓝色</span><span
    					id="tic" vel="c" num="c" class="span" >黃色</span><span
    					id="tid" vel="d" num="d" class="span">紫色</span><span
    					id="tie" vel="e" num="e" class="span" >白色</span><span
    					id="tif" vel="f" num="f" class="span" >粉紅色</span>
    			</div>
			</div>
			<div  class="maintext maintext-play">
				<div class="maintitle">6种玫瑰颜色找出你的恋爱基因</div>
				<div id="question" class="question">
					<p id="question-text">现在，请想象自己是一朵美丽绽放的玫瑰花，你觉得那些开在你身上的是什么颜色的玫瑰呢？</p>
					<img id="question-pic"
						style="max-width: 100%; max-height: 200px; margin: 0 auto; display: block;"
						src="">
				</div>
				<div  class="btnbox btn-play">
    				<span id="tia" vel="a" num="a" class="span" >紅色1</span><span
    					id="tib" vel="b" num="b" class="span" >蓝色1</span><span
    					id="tic" vel="c" num="c" class="span" >黃色3</span>
    			</div>
			</div>
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
	<script type="text/javascript">
	$(document).ready(function(){
		var index = 0; 
		$("#gameready,.btn-play .span").click(function(){	
			$(".maintext-play").eq(index).animate({marginLeft:"-"+$(".maintext-play").eq(index).width()},'slow',function(){
				$(".maintext-play").eq(index).hide();
				$(".maintext-play").eq(index+1).fadeIn('slow');
				$("#gameready").hide();
				index++;
		    });	    
		});	
    });
		
	</script>
</body>
</html>
