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
$this->title = $login_user_showNickname.'的私信';
$this->params['breadcrumbs'][] = $this->title;

echo $this->renderFile(__DIR__ . '/../layouts/head.php');

?>

<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>
<div id="main_body">


	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php',['go_back'=>1]);?>

	<section class="s_moreread">

			<?php //echo $this->renderFile(__DIR__.'/../layouts/header-user.php',['uid'=>$uid]);?>

		<div class="list_box">
            <?php  include(__DIR__.'/my-message-static-list3.php');?>
		</div>

        <?php echo $this->renderFile(__DIR__.'/../layouts/my-message2-foot-comment3.php',['uid'=>$uid]);?>
	</section>


</div>
<script type="text/javascript">
 ajaxLoad();
 $(".load_more2").click();

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
                $(".card-list").append( html );
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
$(".ux-popmenu1").hide().css('background-color','transparent');
$(".ux-popmenu1").css('max-height','215px');
$(".disable1").click(function(){
	$(".ux-popmenu1").show();
});
</script>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>
