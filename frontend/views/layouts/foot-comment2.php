<?php
use common\models\User;
?>



<style>

.ux-popmenu {
   /* display: none;
    position: absolute;*/
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
#ui-id-1{
	z-index: 9999;
}
</style>


<script type="text/javascript" src="<?php echo Yii::$app->urlManager->baseUrl; ?>/js/jquery.autocomplete.js">
</script>
<style>
.autocomplete-suggestions { border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-no-suggestion { padding: 2px 5px;}
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: bold; color: #000; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { font-weight: bold; font-size: 16px; color: #000; display: block; border-bottom: 1px solid #000; }

</style>
<?php
echo $this->renderFile(__DIR__ . '/../comment/static-comment-message2.php',['uid'=>$uid,'ta_user_showNickname'=>$ta_user_showNickname]);
?>
<script type="text/javascript">

$(document).ready(function(){
	var availableTags = ['张三','李四','哈哈'];
	$( "#txt-to_uid" ).bind('change').autocomplete({
		minChars: $( "#txt-to_uid").val() ? $( "#txt-to_uid").val().length : 1,
        noCache:true,
		serviceUrl: function(){
		    var url = '<?php echo Yii::$app->urlManager->createUrl( ['my/users-list','search'=>'#search#'] ); ?>';
		    url = url.replace('%23search%23',$('#txt-to_uid').val());
		    console.log(url);
		    return url;
		},
	    onSelect: function (suggestion) {
	        console.log(suggestion);
	        $( "#txt-to_uid" ).attr('uid',suggestion.uid);
	    }

	});
    //点击显示评论
    $(".card-list ").on('click','.line-bottom',function(){

        var url = $(this).attr('comment-url');
        $("#box-comment").attr('url',url);
    	$(".ux-popmenu2").show();

    	$( "#txt-to_uid").val($(this).find(".item-main").text());
  	    $( "#txt-to_uid").attr('uid',$(this).attr('uid'));
    });
    $(".comment-button").on('click',function(){
        var url = $(this).attr('url');
        $("#box-comment").attr('url',url);
    	$(".ux-popmenu2").show();
 	    $( "#txt-to_uid").val('<?php echo User::getUidShowName($uid);?>');
  	    $( "#txt-to_uid").attr('uid','<?php echo $uid;?>')
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
$("#box-comment a.fr.disable").click(function(){

	$(this).closest(".ux-popmenu").hide();
	return false;
});

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
		$(".ux-popmenu1").show();
		alert('请输入评论内容');

		return false;
	}
	var url = "<?php echo Yii::$app->urlManager->createUrl(['comment/add','tid'=>'#tid#','content'=>'#content#']); ?>";
	url = url.replace('%23tid%23', '<?php echo $uid;?>');
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
            	 location.reload();
             }
        }else{
            alert("出错了");
        }
    });
}
</script>