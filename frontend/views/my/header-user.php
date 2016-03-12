<style>
.user-info{
	margin:  15px;
}
.user-info>table{
	width: 100%;
}
.user-info .user-image{
	font-size: 4em;
}
.user-info .td-1{
	text-align: center;
	width: 25%
}
.user-info table td{
	vertical-align: bottom;
	
}
.user-info .td-2,.user-info .td-3{
	line-height:2em;
	font-size: 0.95em;
}
.user-menu a{
	border-top:1px dashed #ddd;
	border-bottom: 1px solid #ddd;
	color: #888;
	width: 33.33%;
	display: block;
	float: left;
	text-align: center;
	line-height: 2em;
}

#main_body a:first-child span,a>span.vertical-line{
	border: ;
	font-size: 0.95em;
	width:1px;
	height: 2.1em;
	border-right: 1px dashed #ddd;
	float: right;
}
#main_body .list_box a:first-child span{
	width: auto;
	margin-left: -0.2em;
}
.space{
	height: 1.2em;
}
.a-left,.a-right{
	padding: 0px 5px;
    float: left;
    border: 1px solid #ddd;
	display: inline-block;
}
.td-3>div>a.a-right{
	margin-left: 20px;
}
</style>
<?php 
use common\z\ZCommonSessionFun;
use common\z\ZCommonFun;
use common\models\UsersFriends;
use yii\base\Model;
use tests\codeception\common\fixtures\UserFixture;
$model_SurveyTotal = new common\models\Survey();
$sessionUser = ZCommonSessionFun::get_user_session();

$url_my_test = Yii::$app->urlManager->createUrl(['survey/my']);
$url_create_test = Yii::$app->urlManager->createUrl(['survey/step1']);
$url_withdraw = '';
$url_user_setting = Yii::$app->urlManager->createUrl(['user-profile/bind']);

$url_logout = Yii::$app->urlManager->createUrl(['login/logout']);
$url_ta_me_test = Yii::$app->urlManager->createUrl(['my/personal-page','uid'=>$uid]);
$url_ta_test = Yii::$app->urlManager->createUrl(['my/my-test','uid'=>$uid]);

$login_uid = ZCommonSessionFun::get_user_id();
$concern_status = 0;
if($login_uid<1){
    $concern_status = 0;
}else{
    $model_UsersFriends = new UsersFriends();
    $concern_status = $model_UsersFriends->get_user_each_concern($login_uid, $uid);
}
?>
<link rel="stylesheet" href="./bag-test/css/common.css">
<script src="./js/concern.js">
</script>
<div class="user-info">
	<table>
		<tr>
			<td class="td-1">
			     <?php echo isset($sessionUser['head_image']) ? '<img width="48" height="48" src="'.$sessionUser['head_image'].'"/>': '<i class="fa fa-user user-image  common-color"></i>'?>
			</td>
			<td class="td-2">
				<h3 class="common-color"><?php echo isset($sessionUser['nickname']) ? '<label style="color: #333;">昵称</label>'.$sessionUser['nickname']: '暂无昵称'?></h3>
				
				<div>
					签名<sapn class="common-color">
					他什么都没留下
					</sapn>
				</div>
				
			</td>
			<td class="td-3">
			     <div>
			        <?php 
			        $url = '';
			        $concer_text = '';
			  
			        switch ($concern_status){
			            case 1:
			                $url = Yii::$app->urlManager->createUrl(['my/concern','fuid'=>$uid]);
			                $concer_text = '已相互关注';
			                break;
			            case 2:
			                $url = '';
			                $concer_text = '已关注';
			                break;
			            default:
			                $url = Yii::$app->urlManager->createUrl(['my/concern','fuid'=>$uid]);
			                $concer_text = '关注';
			                break;
			        }
			        ?>
					<a url="<?php echo $url; ?>" class="concern" onclick="concern(this)"><?php echo $concer_text; ?></a>
				</div>
				
			</td>
		</tr>
		<tr>
			<td class="td-1">
			    
			</td>
			<td class="td-2">
				
				
				<div>
					创建了<sapn class="common-color">
					<?php echo $model_SurveyTotal->getMySurveyCount();?>
					</sapn>个测试
				</div>
				
				<div class="">
					关注<sapn class="common-color"><?php echo UsersFriends::get_concern_count($uid,true);?></sapn>人
				</div>
			</td>
			<td class="td-3">
			  
				<div>
					测过<sapn class="common-color">0</sapn>次
				</div>
				<div>
					粉丝<sapn class="common-color"><?php echo UsersFriends::get_concern_count($uid);?></sapn>次
				</div>
			</td>
		</tr>
	</table>
</div>
<?php 

?>
<nav class="user-menu">
	<a href="<?php echo $url_ta_me_test;?>">TA创建的<span class="vertical-line" style="font-size:100%;border-right:1px dashed #ddd;"></span></a> 
	<a href="<?php echo $url_ta_test;?>">Ta测过的<span class="vertical-line" style="font-size:100%;border-right:1px dashed #ddd;"></span></a> 
	<a href="<?php echo $url_withdraw;?>">给Ta的私信<span class="vertical-line"></span></a>
</nav>



<div class="clear" style="clear: both;"></div>
<div class="space">&nbsp;</div>
