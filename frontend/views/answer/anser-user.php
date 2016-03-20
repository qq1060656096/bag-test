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
<script src="./js/concern.js"></script>
<?php 
use common\z\ZCommonSessionFun;
use common\z\ZCommonFun;
use common\models\UsersFriends;
$login_uid = ZCommonSessionFun::get_user_id();
$concern_status = 0;
if($login_uid<1){
    $concern_status = 0;
}else{
    $model_UsersFriends = new UsersFriends();
    $concern_status = $model_UsersFriends->get_user_each_concern($login_uid, $model_Users->uid);
}
$concer_url = '';
$concer_text = '';
	

	
switch ($concern_status){
    case 1:
        $concer_url = Yii::$app->urlManager->createUrl(['my/concern','fuid'=>$model_Users->uid]);
        $concer_text = '已相互关注';
        break;
    case 2:
        $concer_url = '';
        $concer_text = '已关注';
        break;
    default:
        $concer_url = Yii::$app->urlManager->createUrl(['my/concern','fuid'=>$model_Users->uid]);
        $concer_text = '关注';
        break;
}
?>
<ul class="list " id="answer-view" >
	<li class="diy-item"><a
		href="<?php echo Yii::$app->urlManager->createUrl(['my/personal-page','uid'=>$model_Users->uid]);?>"
		target="_blank">
			<figure class="cover">
				<img class="" width="50" height="50"
					src="<?php echo $model_UsersProfile->getHeadImage0();?>">
			</figure>
			<div class="diy-meta">
				<div class="title mui-ellipsis">本测试创建者:&nbsp;<?php echo $model_UsersProfile->getNickname0();?></div>
				<span class="iconfont icon-start-filled5"></span>
				<div class="desc mui-ellipsis"><?php echo $model_UsersProfile->getIntro1();?></div>
			</div>
	</a>  <a url="<?php echo $concer_url; ?>"
		class="play concern" onclick="concern(this)" data-ui="danger small icon-right"><?php echo $concer_text; ?><i
			class="iconfont icon-right"></i>
	</a></li>

</ul>