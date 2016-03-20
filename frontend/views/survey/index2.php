<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
use common\z\ZCommonSessionFun;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $row common\models\Survey */

$this->params['breadcrumbs'][] = $this->title;

echo $this->renderFile(__DIR__ . '/../layouts/head.php');
/*
<link rel="stylesheet" type="text/css"
	href="./css/index/swiper.min.css">
<link rel="stylesheet" type="text/css"
	href="./css/index/app.min.css">
<script src="./css/index/zepto.min.js"></script>
<script src="./css/index/swiper.min.js"
	type="text/javascript" charset="utf-8"></script>
	*/
?>

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
	<?php include dirname(__DIR__).'/layouts/head-top.php'; ?>

	<div class="mui-content" style="position:relative;">
		<section class="diy-content-space-small"></section>
		<!--search form-->
		<section class="container search diy-content-space-small">
			<form
				action="<?php echo Yii::$app->urlManager->createUrl(['survey/index','sort'=>$sort]);?>"
				class="form" method="post" data-ui="static" id="search-form">
				<div data-role="input">
					<input placeholder="搜索测试" type="text" autocomplete="off"
						autocorrect="off" value="<?php echo $search ? $search : ''; ?>" maxlength="64" name="SurverySearch[title]" id="search"> <i
						class="iconfont icon-search"></i> <i class="iconfont icon-close"></i>
				</div>
				<button class="ui-btn" data-ui="danger small" type="button"
					id="search-btn">搜索</button>
			</form>
		</section>
		<!--slider-->
		<!-- end slider -->
		<?php if($sort<1): ?>
		<section class="main-content" id="hash-rcmd">
			<h5 class="diy-content-padded">
				精品测试 <a class="diy-more"  style="display: none;"
					href="">
					更多<i class="iconfont icon-right"></i>
				</a>
			</h5>
			<ul class="mui-table-view mui-grid-view mui-grid-9">
			    <?php 
			    
			    
			    foreach ($models_SurveyOperation as $key => $row):
    			    if($row->tax==1){
    			        $url = Yii::$app->urlManager->createUrl(['answer/step1','id'=>$row->id]);
    			    }else{
    			        $url = Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$row->id]);
    			    }
    			    $image = common\models\Survey::getImageUrl($row);
    			    
			    ?>
				<li class="mui-table-view-cell mui-media mui-col-xs-6"><a
					href="<?php echo $url;?>"
					target="_blank">
						<figure class="cover">
							<img src="<?php echo $image;?>"
								class="tuijian-img">
						</figure>
						<div class="mui-media-body tuijian-title"><?php echo $row->title;?></div>
				</a></li>
				<?php endforeach;?>
			</ul>
		</section>
        <?php endif;?>
		<!-- category start -->
		<!-- category end -->
		
		<!-- all list  -->
		<section id="all-game" class="main-content">
		    <h5 class="diy-content-padded">
				
			</h5>
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
			if($search!==false):
			     $new_url = Yii::$app->urlManager->createUrl(['survey/index-ajax','page'=>'#page#','sort'=>'1','SurverySearch[title]'=>$search]);
			else: 
			     $new_url = Yii::$app->urlManager->createUrl(['survey/index-ajax','page'=>'#page#','sort'=>'1']);
			endif;
			?>
			<ul class="list " id="new" page="1" url="<?php echo $new_url;?>">
			    <?php 
			    $role = ZCommonSessionFun::get_role();
			    foreach ($a_models as $key => $row):
    			    if($row->tax==1){
    			        $url = Yii::$app->urlManager->createUrl(['answer/step1','id'=>$row->id]);
    			    }else{
    			        $url = Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$row->id]);
    			    }
    			    $image = common\models\Survey::getImageUrl($row);
    			    $is_top_text = '';
    			    $is_top_url = '';
    			    $op0 = Yii::$app->urlManager->createUrl(['survey/recommend','id'=>$row->id,'op'=>0]);
    			    $op1 = Yii::$app->urlManager->createUrl(['survey/recommend','id'=>$row->id,'op'=>1]);
    			    $is_top = 0;
    			    if( $row->is_top > 0 ):
    			         $is_top_text = '取消推荐';
    			         $is_top = 0;
    			    else:
    			         $is_top_text = '推荐';
    			         $is_top = 1;
    			    endif;
			    ?>
				<li class="diy-item" date-id="2626">
    				<a
    					href="<?php echo $url;?>"
    					target="_blank">
    						<figure class="cover">
    							<img class=""
    								src="<?php echo $image;?>">
    						</figure>
    						<div class="diy-meta">
    							<div class="title mui-ellipsis"><?php echo $row->title;?></div>
    							<span class="iconfont icon-start-filled5"></span> <span
    								class="count"><?php echo $row->answer_count;?>人在测</span>
    							<div class="desc mui-ellipsis"><?php echo $row->intro;?></div>
    						</div>
    				</a> 
    				<?php if( $role == 1 ):?>
    				<a
    					is_top="<?php echo $is_top;?>" op0="<?php echo $op0?>" op1="<?php echo $op1;?>"
    					class="play recommend" data-ui="danger small icon-right" style="right: 75px;"> <?php echo $is_top_text;?><i
    						class="iconfont icon-right"></i>
    				</a>
    				<?php endif;?>
    				<a
    					href="<?php echo $url;?>"
    					class="play" data-ui="danger small icon-right"> 去测<i
    						class="iconfont icon-right"></i>
    				</a>
				</li>
	            <?php endforeach;?>
			</ul>
			<!-- 
			<ul class="list " id="hot" page="0" url="<?php echo Yii::$app->urlManager->createUrl(['survey/index-ajax','page'=>'#page#','sort'=>'0']);?>">
			</ul>
			<ul class="list " id="recommend" page="0" url="<?php echo Yii::$app->urlManager->createUrl(['survey/index-ajax','page'=>'#page#','sort'=>'2']);?>">
			</ul>
			 -->
		</section>
        <div class="refresh-tip main-content" style="display: none;text-align: center;">
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



<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>