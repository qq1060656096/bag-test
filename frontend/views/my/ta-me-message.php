<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
use common\z\ZCommonSessionFun;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $row common\models\Survey */
$login_user_showNickname = User::getUidShowName(ZCommonSessionFun::get_user_id());
$ta_user_showNickname    = User::getTaUidShowName($uid);
$User               = User::findOne(ZCommonSessionFun::get_user_id());
$login_head_image   = $User ? $User->getTaShowHead_image() : User::getDefaultHead_image();
$ta_User            = User::findOne($uid);
$ta_head_image      = $ta_User ? $ta_User->getTaShowHead_image() : User::getDefaultHead_image();

$this->title = $ta_user_showNickname.'与'.$login_user_showNickname;
$this->params['breadcrumbs'][] = $this->title;

echo $this->renderFile(__DIR__ . '/../layouts/head.php');

?>
<style>
.s_moreread{
	margin-bottom: 220px;
	position: relative;
}
</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>
<div id="main_body">


	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php',['go_back'=>1]);?>

	<section class="s_moreread">


		  <?php  include(__DIR__.'/ta-static-list3.php');?>



        <?php //echo $this->renderFile(__DIR__.'/../layouts/foot-comment2.php',['uid'=>$uid,'ta_user_showNickname'=>$ta_user_showNickname,'ta_me'=>$ta_me]);?>
	</section>


</div>
<style>
<!--
.wei-chat-footer{
	bottom: 51px;
}
.load_more2{
	text-align: center;
	display:block;
}
-->
</style>
<script type="text/javascript">
 ajaxLoad();
 $(".load_more2").click();
//  $(".ux-popmenu2").show();

/**
 * ajax加载分页
 */
function ajaxLoad(){
	page = 0;
	isAjaxLoad = false;
    $(".load_more2").click(function(){
        var now =$(this);
        page++;
       var url = "<?php echo $ajax_url;?>";
        url = url.replace('%23page%23',page);

        //有没有执行ajax就执行ajax,在执行，等执行后在加载
        if(!isAjaxLoad){
        	isAjaxLoad = true;
        	now.text('加载中');
            $.get(url,function(html){
            	now.text('加载更多');
            	isAjaxLoad = false;
                console.log(html);
                //没有找到
                if(html==''){
                	isAjaxLoad = true;
                	now.text('已经没有了');
                	console.log('已经没有了');
                }
                $(".wei-chat").prepend( html );
            });
        }
    });
}


</script>

<style>
<!--
.cancel1{
	display:none;
}
-->
</style>
<script type="text/javascript">
//提交评论
$(".wei-chat-footer .btn").click(function(){
    var content = $('.wei-chat-footer .text').val();

	if(content==''){

		alert('请输入评论内容');

		return false;
	}
	var url = "<?php echo Yii::$app->urlManager->createUrl(['comment/add','tid'=>'#tid#','content'=>'#content#']); ?>";
	url = url.replace('%23tid%23', '<?php echo $uid;?>');
	url = url.replace('%23content%23',content);
    var pageCount = $("li.eq(0)").attr('pageCount');
    if(pageCount>0){
    	page = page==null ? pageCount: page;
    	url = url.replace('%23page%23',page);
    }
    console.log(url);
	comment(url,content);

	return false;
});
//评论
function comment(url,content){
	$.get(url,function(json){
    	if(json.message){
        	//没登录就跳到登录页
        	if(json.status==-1){
            	location.href="<?php echo Yii::$app->urlManager->createUrl(['login/login']) ;?>";
             }else{
//           	   alert(json.message);
          	   var html = '<li><img src="<?php echo $login_head_image;?>" class="imgright"><span class="spanright">'+content+'</span></li>';
          	   $(".wei-chat").append( html );
//             	 location.reload();
             }
        }else{
            alert("出错了");
        }
    });
}
</script>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>
