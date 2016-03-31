<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserProfile;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

echo $this->renderFile(__DIR__.'/../layouts/head.php');
?>
<style>
#answer-view .diy-item {
    position: relative;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    display: -webkit-box;
    box-sizing: border-box;
    padding: 11px 12px;
    width: 100%;
    height: 80px;
    text-decoration: none;
    border-bottom: 1px solid #f7f7f7;
    color: #000;
}
#answer-view .diy-item img{
	height: 60px;
	width: 60px;
}
#answer-view .cover {
    position: relative;
    z-index: 1;
    display: inline-block;
    margin: 0 auto;
    text-align: center;
    box-shadow: 0 1px 1px 1px rgba(0,0,0,0.25);
    overflow: hidden;
    background: url("../img/game-icon.png") no-repeat;
    margin-right: 10px;
    margin-left: 2px;
    background-size: 60px 60px;
    background-position: center;
    background-color: rgba(241,241,241,0.5);
    -webkit-box-flex: 1;
}
#answer-view .diy-item>a {
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    display: -webkit-box;
    text-decoration: none;
    width: 100%;
    position: relative;
}
#answer-view .diy-meta {
    -webkit-box-flex: 1;
    flex: 1;
    color: #9b9b9b;
    overflow: hidden;
    height: 60px;
}
#answer-view .diy-meta .title {
    color: #333;
    font-weight: 400;
    font-size: 14px;
    margin-bottom: 2px;
    margin-top: -2px;
}
#answer-view .diy-item .play {
    position: absolute;
    display: block;
    width: auto;
    color: #ff7585;
    min-width: 30px;
    right: 10px;
    top: 30px;
    padding: 0 6px;
    border: 1px solid;
    border-radius: 3px;
}
</style>
<div id="main_body">
    <header class="s_header">
		<nav>
            <a href="javascript:history.back();" class="bg"> <span class="fa ">返回</span></a>

			 <span style="font-size: 1.4rem"><?php echo $this->title;?></span>
		</nav>
	</header>
	<section  class="container" id="answer">
			
			
    		
		
		</section>
        <div class="refresh-tip main-content" style="display: none;text-align: center;">
    		<span><img src="./css/index/loading.gif"></span>正在加载
    	</div>
</div>


<link href="./bag-test/bootstrap/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="./bag-test/bootstrap/datetimepicker.css" rel="stylesheet" media="screen">

<script type="text/javascript" src="./bag-test/bootstrap/jquery.min.js"></script>    
<script src="./js/concern.js"></script>
<script type="text/javascript">
page = 0;
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
	        	ajaxLoad();
		    }
	    }

	}	
}
ajaxLoad();
/**
 * ajax加载分页
 */
function ajaxLoad(){
	is_ajax_style();
	page++;
	var url = '<?php echo $ajax_url;?>';
	url = url.replace('%23page%23',page);
	var data = {};
	$.get(url,data,function(html){
		window.pulldownrefreshEvent = 1;

		$("#answer").append(html);
		if(html==""){
		
			is_ajax_done_no_data();
		}else{
			is_ajax_done();
			
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