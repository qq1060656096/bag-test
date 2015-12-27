

<div class="ux-popmenu ux-popmenu2"
	style="display: none; position: fixed; background-color: rgba(0, 0, 0, 0.498039);">
	<div class="content show" style="bottom: 0px; position: fixed;">
		<section class="card-combine">
			<a href="" node-type="recommend" class="line-bottom"
				reporttype=""><span>回复</span></a><a href="javascript:;"
				node-type="reportPL" reporttype="" style="display: none;"><span>举报</span></a> <a
				class="close line-top" href="javascript:;"><span>取消</span></a>
		</section>
	</div>
</div>
<style>

.ux-popmenu {
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1001;
    transition: background-color .2s ease-in-out;
    overflow: hidden;
}
.ux-popmenu2{
	display: none;
}
.ux-popmenu .content.show {
    bottom: 0;
    transition: bottom .2s ease-in-out;
}
.ux-popmenu .content {
    position: absolute;
    left: 0;
    bottom: -300px;
    width: 100%;
    background: #e7e7e7;
    border-top: 3px solid orange;
    box-shadow: 0 -1px 40px rgba(0,0,0,.3);
}

.ux-popmenu section a {
    display: block;
    height: 48px;
    line-height: 48px;
    text-align: center;
    font-size: 16px;
    background: #f8f8f8;
    color: #333;
    margin-bottom: 1px;
}

.ux-popmenu section span {
    display: block;
    background: #f8f8f8;
}
</style>

<?php 
echo $this->renderFile(__DIR__ . '/../comment/static-comment-message.php');
?>
<script type="text/javascript">
$(document).ready(function(){
    //点击显示评论
    $(".card-list .line-bottom").live('click',function(){
        
        var url = $(this).attr('comment-url');
        $("#box-comment").attr('url',url);
    	$(".ux-popmenu2").show();
    });
    $(".comment-button").live('click',function(){
        var url = $(this).attr('url');
        $("#box-comment").attr('url',url);
    	$(".ux-popmenu2").show();
    	return false;
    });
});
//取消评论
$(".ux-popmenu2 .close").click(function(){
	$(this).closest(".ux-popmenu2").hide();
});
//评论
$(".ux-popmenu2 .line-bottom").click(function(){
	$(".ux-popmenu1").show();
	$(".ux-popmenu2").hide();
	return false;
});

//隐藏评论框
// $("#box-comment a.fr.disable").click(function(){
// 	alert(1);
// 	$(this).closest(".ux-popmenu").hide();
// 	return false;
// });

//隐藏评论框
$(".ux-popmenu1 .module-topbar a.cancel1").click(function(){
	$(".ux-popmenu1").hide();   
	return false;
});
//提交评论
$(".ux-popmenu1 .module-topbar a.disable1").click(function(){
    var content = $('#txt-publisher').val();
	$(".ux-popmenu1").hide();
	if(content==''){
		alert('请输入评论内容');
	}
	var url = $(this).closest('#box-comment').attr('url');
	url = url.replace('%23content%23',content);

	comment(url);
	
	return false;
});
//评论
function comment(url){
	$.get(url,function(json){
    	if(json.message){
        	//没登录就跳到登录页
        	if(json.status==-1){
            	location.href="<?php echo Yii::$app->urlManager->createUrl(['login/login']) ;?>";
             }else{
          	   alert(json.message);
             }
        }else{
            alert("出错了");
        }
    });
}
</script>