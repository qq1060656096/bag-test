<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZController;
$sort=1;
$search= '';
$op_name='最新';
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
	
	<link href="http://www.weceshi.com/favicon.ico" type="image/x-icon"
	rel="shortcut icon">
<link href="./css/index/mui.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css"
	href="./css/index/app.min.css">

<div class="mui-inner-wrap">
<style>
.diy-tab-item{
	width: 33.3%;
}
.mui-bar-nav~.mui-content{
	position: relative;
}
section#all-game {
    padding-bottom: 100px;
}
.refresh-tip{
	position: absolute;
	left : 0;
	bottom: 50px;
}
.footer-nav{
	z-index: 9999;
}
</style>
	<!-- 主页面标题 -->
	<header class="s_header">
    		<nav>

    			<span style="font-size: 1.4rem"><?php echo $this->title;?></span>
    		</nav>
    	</header>

	<div class="mui-content" style="position:relative;">
		<section class="diy-content-space-small"></section>
		<!--search form-->
		<section class="container search diy-content-space-small">
			<form
				action="<?php echo Yii::$app->urlManager->createUrl(['survey/index','sort'=>$sort]);?>"
				class="form" method="post" data-ui="static" id="search-form">
				<div data-role="input">
					<input placeholder="大家都在搜：史上最坑手机测试" type="text" autocomplete="off"
						autocorrect="off" value="<?php echo $search ? $search : ''; ?>" maxlength="64" name="SurverySearch[title]" id="search"> <i
						class="iconfont icon-search"></i> <i class="iconfont icon-close"></i>
				</div>
				<button class="ui-btn" data-ui="danger small" type="button"
					id="search-btn">搜索</button>
			</form>
		</section>
		<!--slider-->
		<!-- end slider -->
		<section class="main-content" id="hash-rcmd">
			<h5 class="diy-content-padded">
				精品测试 <a class="diy-more"  style="display: none;"
					href="">
					更多<i class="iconfont icon-right"></i>
				</a>
			</h5>
			<ul class="mui-table-view mui-grid-view mui-grid-9">
			   
			</ul>
		</section>

		<!-- category start -->
		<!-- category end -->
		
		<!-- all list  -->
		<section id="all-game" class="main-content">
			<h5 class="diy-content-padded">
				<?php echo $op_name;?>测试<a class="diy-more"
					href="javascript: return false;"></a>
			</h5>
			<div class="diy-tab diy-space-big">
				<a class="diy-tab-item mui-active" style="display: none;"
					url="">最新</a>
					<!-- 
				<a class="diy-tab-item"
					url="/index.php?s=/wetest/index/getpagedata/order/view/pageIndex/">最火</a>
				<a class="diy-tab-item "
					url="/index.php?s=/wetest/index/getpagedata/order/top/rcmd/1/pageIndex/">推荐</a> -->
			</div>
			<?php 
			     $new_url = Yii::$app->urlManager->createUrl(['survey/index-ajax','page'=>'#page#','sort'=>'1']);
			?>
			<ul class="list " id="new" page="1" url="<?php echo $new_url;?>">
			    
			</ul>
			<!-- 
			<ul class="list " id="hot" page="0" url="<?php echo Yii::$app->urlManager->createUrl(['survey/index-ajax','page'=>'#page#','sort'=>'0']);?>">
			</ul>
			<ul class="list " id="recommend" page="0" url="<?php echo Yii::$app->urlManager->createUrl(['survey/index-ajax','page'=>'#page#','sort'=>'2']);?>">
			</ul>
			 -->
		</section>
        <div class="refresh-tip main-content">
    		<span><img src="./css/index/loading.gif"></span>正在加载
    	</div>
	
	</div>
	

</div>



<script src="./css/index/app.js" type="text/javascript"
	charset="utf-8"></script>

<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>
<script>
$(document).ready(function(){

	$("#search-btn").click(function(){
		var value = $("#search").val();
		if(value){
			$("form").submit();
	    }
	    
	});  
	//推荐
    $("#all-game").on('click','a.recommend',function(){
    	var now_element = $(this);
    	var is_top = now_element.attr('is_top');
    	var op = is_top=='1' ? 'op1':'op0';
    	var url = now_element.attr(op);
    	var data = {};
    	console.log(url);
    	$.getJSON(url,data,function(json){
    		if(json.status==0){
    			now_element.attr('is_top',is_top==1 ? '0':'1');
    			now_element.html(is_top==1 ? '取消推荐':'推荐');
 			   alert("推荐成功");
    	    }else{
        	    console.log(json);
    	        alert("操作失败");
        	}
    		
    	});
    });  
    
    $("#all-game .diy-tab-item").click(function(){
        
    	var now_element = $(this);
    	$("#all-game .diy-tab-item").removeClass('mui-active');
    	now_element.addClass('mui-active');
    	var index = $("#all-game .diy-tab-item").index(now_element);
    	console.log('index',index);
    	$('#all-game ul.list').hide();
    	$('#all-game ul.list').eq(index).show();
    	var selector = '';
    	switch(index){
 	       case 2:
  	    	  selector="#recommend";
	    	    break;
     	   case 1:
      		  selector="#hot";
      		    break;
      	   default: 
        		 selector="#new";
            	break;
    	}
    	ajaxLoad(selector);
    });

});


pulldownRefreshEvent();
function pulldownRefreshEvent(){
	window.onscroll = function(){
	    var top = document.documentElement.scrollTop || document.body.scrollTop;
	    if(top +document.body.clientHeight>=document.body.scrollHeight - 40){
	    	console.log( window.pulldownrefreshEvent);
		    if(typeof( window.pulldownrefreshEvent)=='undefined'){
		    	window.pulldownrefreshEvent = 1;
			}
			//开始事件
	        if(window.pulldownrefreshEvent == 1){
		        //防止重复执行事件
	        	window.pulldownrefreshEvent = 2;
	        	var index = $("#all-game .diy-tab-item").index($("#all-game .diy-tab-item.mui-active"));
	        	console.log(index);
	        	
	        	var selector = '';
	        	switch(index){
	     	       case 2:
	      	    	  selector="#recommend";
	    	    	    break;
	         	   case 1:
	          		  selector="#hot";
	          		    break;
	          	   default: 
	            		 selector="#new";
	                	break;
	        	}
	        	ajaxLoad(selector);
		    }
	    }

	}	
}

function ajaxLoad(selector){
	is_ajax_style();
	if($(selector).attr('emptydata')=='1'){
		is_ajax_done_no_data();
		return false;
	}
	var url = $(selector).attr('url');
    
	var page = $(selector).attr('page');
	page++;
	$(selector).attr('page',page);
	url = url.replace('%23page%23',page);
	var data = {};
	$.getJSON(url,data,function(json){
		window.pulldownrefreshEvent = 1;
		if(json.status==0){
			if(json.data==""){
				$(selector).attr('emptydata',1);
				is_ajax_done_no_data();
			}else{
				is_ajax_done();
				$(selector).append(json.data);
		    }
			
	    }
		
	});
}
//开始ajax样式
function is_ajax_style(){
	$(".refresh-tip").show().empty().append("<span><img src=\"./css/index/loading.gif\"></span>正在加载");
}
function is_ajax_done(){
	$(".refresh-tip").hide(1000);
}
function is_ajax_done_no_data(){
	$(".refresh-tip").empty().append("已经没有了");
}
</script>
</body>
</html>
