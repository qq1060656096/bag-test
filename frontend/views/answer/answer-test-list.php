
<style>
.mui-inner-wrap section {
    background: #fff;
    overflow: hidden;
}
#answer .diy-content-padded,#all-game .diy-content-padded{
    margin: 12px;
    margin-bottom: 0;
    padding-bottom: 6px;
    border-bottom: 1px solid #e6e6e6;
    font-size: 14px;
    font-weight: 400;
    color: #8f8f94;
    line-height: 1;
    text-align: left;
}     
#answer  .mui-grid-view.mui-grid-9 .mui-table-view-cell{
	    display: inline-block;
    padding: 10px 0 0 14px;
    margin-right: -4px;
    font-size: 17px;
    text-align: center;
    vertical-align: middle;
    background: 0 0;
}   	
#answer .cover,#all-game  .cover {
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
#answer  .mui-col-xs-3 {
    width: 25%;
}	
#answer  .mui-col-xs-6 {
    width: 50%;
}	  

#answer .mui-table-view.mui-grid-view .mui-table-view-cell .mui-media-body {
    display: block;
    width: 100%;
    height: 15px;
    margin-top: 8px;
    font-size: 15px;
    line-height: 15px;
    color: #333;
    text-overflow: ellipsis;
}
#answer .mui-table-view .mui-media, .mui-table-view .mui-media-body {
    overflow: hidden;
}
#answer .cover,#answer  .cover img{
	width: 97% !important;
	height: 97%  !important;
}
#all-game .diy-item {
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

#all-game .diy-item>a {
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    display: -webkit-box;
    text-decoration: none;
    width: 100%;
    position: relative;
}

#all-game .diy-meta {
    -webkit-box-flex: 1;
    flex: 1;
    color: #9b9b9b;
    overflow: hidden;
    height: 60px;
}

#all-game .diy-meta .title {
    color: #333;
    font-weight: 400;
    font-size: 14px;
    margin-bottom: 2px;
    margin-top: -2px;
}
.mui-ellipsis {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.diy-meta .count {
    font-size: 12px;
    margin-right: 4px;
    margin-left: 4px;
}
.diy-meta .desc {
    line-height: 1;
    font-size: 12px;
    margin-top: 5px;
    padding-right: 50px;
}
 #all-game .cover img {
    border-radius: 12px;
    width: 60px;
    height: 60px;
}

 #all-game .diy-item .play {
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
	
	
	
	
	<section class="container" id="answer">
	       <h5 class="diy-content-padded">
				&nbsp;
			</h5>
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
		<!-- all list  -->
		<section id="all-game" class="container">
		<h5 class="diy-content-padded">
				&nbsp;
			</h5>
			<h5 class="diy-content-padded">
				最新测试<a class="diy-more"
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
			
		</section>
        <div class="container refresh-tip" style="display: none;text-align: center;">
    		<span><img src="./css/index/loading.gif"></span>正在加载
    	</div>
    	
    	
<script type="text/javascript">
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
	
	url = url.replace('%23page%23',page);
	page++;
	$(selector).attr('page',page);
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