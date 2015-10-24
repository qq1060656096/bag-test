<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $model common\models\Survey */
$this->title = $model->title.'--测试结果';
echo $this->renderFile(__DIR__ . '/../layouts/head-answer.php');
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
            <span class="text-red text-bold"><?php echo $posts['name'];?></span>
            <?php echo $result->value;?>
            <span class="text-red"><?php echo $result->intro;?></span>
            </span>
        </div>
        <?php } ?>
    	
		
		<div id="id_ceshi_show">
			<div>
				<img src="./bag-test/test-images/103754b6unkvhquepniein.jpg" id="front-img"
					alt="你有多怕谈恋爱：恋爱恐怖程度自评">
			</div>
			<div>爱情就像一场赌博,你越恐惧就越得不到幸福。你会因为曾经的伤害,而不敢接受新的恋情吗?完成测试,看看你的恐惧指数有多高。</div>
			<span class="stip">此测试仅供娱乐，不做专业指导！</span>


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