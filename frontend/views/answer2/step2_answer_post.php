<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $model common\models\Survey */
$this->title = $model->title.'--测试结果';
echo $this->renderFile(__DIR__ . '/../layouts/head-answer.php',['model'=>$model,'model_Answer'=>$model_Answer]);
global $share_url,$image;
?>
<div data-role="page" id="id_ceshi_page" data-url="id_ceshi_page"
	data-dom-cache="false" tabindex="0"
	class="ui-page ui-body-c ui-page-active" style="min-height: 934px;">
	
	<header class="s_header">
		<nav>
            <span style="font-size: 1.4rem"><?php echo '测试结果';?></span>
		</nav>
	</header>
	
	<div data-role="content" class="ui-content" role="main">
        <h1 class="po_title"><?php echo $model->title;?></h1>
		<div class="po_time">
			<span class="common-color"><?php echo $model->answer_count;?></span>人测试过&nbsp;&nbsp;
			准确率<span class="common-color">98.1%</span>
			<span
				style="display: inline-block; float: right;"><?php echo $model->created;?></span>
		</div>
		<div class="line"></div>
		<br>
		
    	
	   <?php if( isset($result) ){?>
        <div class="result">
            <span class="sys">经过对你的名字进行分析，系统认为：</span>
            <span>
            <?php echo $result->name;?>
            <span class="text-red text-bold"><?php echo $result->value;?></span>
            <?php echo $result->value;?>
            <span class="text-red"><?php echo $result->intro;?></span>
            </span>
        </div>
        <?php } ?>
    	
		
		<div id="id_ceshi_show">
			<div>
				<img src="<?php echo $image = isset( $model->images->image ) ? UPLOAD_DIR.$model->images->image : DEFAULT_IMAGE;?>" id="front-img"
					alt="<?php echo $model->title;?>">
			</div>
			<div><?php echo $model->intro;?></div>
			<span class="stip">此测试仅供娱乐，不做专业指导！</span>

            
            <?php echo $this->renderFile(__DIR__.'/../layouts/share.php');?>
		
		</div>
	</div>

<style>
.result{
	color: #888;
}
.result .sys{
	color: #333;
	font-weight: bold;
	display: block;
}	
</style>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>    