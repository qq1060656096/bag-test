<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
use common\z\ZCommonSessionFun;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Survey */
$this->title = '创建测试完成';
$this->params['breadcrumbs'][] = $this->title;

echo $this->renderFile(__DIR__.'/../layouts/head.php');

?>
<style>
<!--
h1{
	font-size: xx-large;
	text-align: center;
}
#main_body{
	text-align: center;
}
-->


.s_login div,.s_reg div{
	padding:0;
}
.s_reg .btn_bg{
	display: block;
}
.form-group{
	text-align: left;
	font-weight: bold;
}
.s_reg form{
	margin-top: 1em;
}
.po_title{
	text-align: left;
	font-size: 2em;
}
.intro{
	text-align: left;
	color: #999;
	text-indent: 2em;
}

.row{
	border-bottom: 3px dashed #DDD;
	margin-top: 1em;
}    
.label-name{
    display: block;
    text-align: left;
}   
.row textarea ,.row input,.s_reg input[type=text], .s_reg input[type=password], .s_reg textarea{
	width: 99%;
	height: 2em;
	line-height:2em;
	padding: 0;
	margin: 0;
	float: left;
	margin-bottom: 0.5em;
}
.s_reg .btn_bg{
	float: left;
	width: 30%;
	border: none;
	margin-top: 1em;

}
.s_reg .btn_bg:last-child{
}
.s_reg .btn_bg.btn-2{

}
.s_reg .btn_bg.save{

}
.s_reg .btn_bg{
	margin-left: 33%;
}
</style>
<?php 
$test_url = $model->tax==1 ? Yii::$app->urlManager->createUrl(['answer/step1','id'=>$model->id])
: Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$model->id]);
$create_url = Yii::$app->urlManager->createUrl(['survey/step1','id'=>$model->id]);
$update_url = Yii::$app->urlManager->createUrl(['survey/step2','id'=>$model->id]);
?>
<div id="main_body">
	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
	<section class="s_moreread s_reg s_login">
	   <h1><?php echo $model->title;?></h1>
	   <p>&nbsp;</p>
	   <p>已成功的创建了一个奇趣测试，您已是测试大师</p>
	   
	   <button type="submit" class="btn_bg btn btn-primary btn-2" 
	   onclick="javascript:location.href='<?php echo $test_url;?>';"
	   name="save-next">我要试用</button>
	   <button type="submit" class="btn_bg btn btn-primary btn-2" 
	   onclick="javascript:location.href='<?php echo $create_url;?>';"
	   name="save-next">在创建一个</button>
	   <button type="submit" class="btn_bg btn btn-primary btn-2" 
	   onclick="javascript:location.href='<?php echo $update_url;?>';"
	   name="save-next">修改次测试</button>
    </section>    
</div>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>