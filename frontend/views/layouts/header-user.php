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
	width: 25%;
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
</style>
<?php 
use common\z\ZCommonSessionFun;
$model_SurveyTotal = new common\models\Survey();
$sessionUser = ZCommonSessionFun::get_user_session();
?>
<div class="user-info">
	<table>
		<tr>
			<td class="td-1">
			     <?php echo isset($sessionUser['head_image']) ? '<img width="48" height="48" src="'.$sessionUser['head_image'].'"/>': '<i class="fa fa-user user-image  common-color"></i>'?>
			</td>
			<td class="td-2">
				<h3 class="common-color"><?php echo isset($sessionUser['nickname']) ? $sessionUser['nickname']: '暂无昵称'?></h3>
				<div>
					创建了<sapn class="common-color">
					<?php echo $model_SurveyTotal->getMySurveyCount();?>
					</sapn>个测试
				</div>
				<div>
					收到打赏<sapn class="common-color">0.00</sapn>元
				</div>
			</td>
			<td class="td-3">
				<div>
					测过<sapn class="common-color">0</sapn>次
				</div>
				<div>
					给朋友打赏<sapn class="common-color">0.00</sapn>元
				</div>
			</td>
		</tr>
	</table>
</div>
<?php 
$url_my_test = Yii::$app->urlManager->createUrl(['survey/my']);
$url_create_test = Yii::$app->urlManager->createUrl(['survey/step1']);
$url_withdraw = '';
$url_user_setting = '';
?>
<nav class="user-menu">
	<a href="<?php echo $url_my_test;?>">我创建的测试<span class="vertical-line"></span></a> 
	<a href="<?php echo $url_create_test;?>">创建测试<span class="vertical-line"></span></a> 
	<a href="<?php echo $url_withdraw;?>">余额提现<span class="vertical-line"></span></a>
	<a href="<?php echo $url_user_setting;?>">修改设置 </a>
</nav>



<div class="clear" style="clear: both;"></div>
<div class="space">&nbsp;</div>
