<?php

/* @var $model common\models\Survey */

echo $this->renderFile(__DIR__ . '/../layouts/head-answer.php');
?>
<div data-role="page" id="id_ceshi_page" data-url="id_ceshi_page"
	data-dom-cache="false" tabindex="0"
	class="ui-page ui-body-c ui-page-active" style="min-height: 934px;">

	<header class="s_header">
		<nav>

			<a href="./list.html" class="bg ui-link"> <span>首页</span>
			</a> <span style="font-size: 1.4rem"><?php echo $model->title;?></span>

		</nav>
	</header>


	<div data-role="content" class="ui-content" role="main">
		<h1 class="po_title"><?php echo $model->title;?></h1>
		<div class="po_time">
			<?php echo $model->answer_count;?>人测试过&nbsp;&nbsp;<span
				style="display: inline-block; float: right;"><?php echo $model->created;?></span>
		</div>
		<br>
		<div id="id_ceshi_show">
			<div>
				<img src="./bag-test/test-images/103754b6unkvhquepniein.jpg"
					alt="你有多怕谈恋爱：恋爱恐怖程度自评">
			</div>
			<div>爱情就像一场赌博,你越恐惧就越得不到幸福。你会因为曾经的伤害,而不敢接受新的恋情吗?完成测试,看看你的恐惧指数有多高。</div>
			<a href="http://m.xinli001.com/ceshi/99897421/#" id="id_start_ceshi"
				class="ui-link">开始测试</a> <span class="stip">此测试仅供娱乐，不做专业指导！</span>


		</div>



		
        <?php $form = ActiveForm::begin(); ?>


			<div id="id_question_list" style="display: none" data-type="score">


				<div id="id_question_item_1" class="question-item">
					<div>当前第1/1题</div>

					<fieldset data-role="controlgroup"
						class="ui-corner-all ui-controlgroup ui-controlgroup-vertical">
						<div role="heading" class="ui-controlgroup-label">1.
							<?php echo $model->intro;?></div>
						<div class="ui-controlgroup-controls">

							<label for="name1"> 
							 <span>输入姓名</span>
							     <input type="text" id="name1" name="name" value=""> 
                            </label>
						

						</div>
					</fieldset>
					<div data-role="controlgroup" data-type="horizontal"
						class="ui-corner-all ui-controlgroup ui-controlgroup-horizontal">

						<input type="submit" class="save" value="提交" name="save" />

					</div>
				</div>


				


			</div>



		<?php ActiveForm::end(); ?>

		<!-- template.cache.mobile-ceshi-show-questions.0c968bd61f3b7fa78b9483c21a4c8bea -->
	</div>


</div>
<!-- /page -->


<div>
    <h3><?php echo $model->title; ?></h3>
    <img src="" />
    <div class="intro">
        <?php echo $model->intro; ?>
    </div>
    
</div>
<div class="answer">
    <h3><?php echo $model->title; ?></h3>
    <div class="row">
       <div class="question"><?php echo $data['question']->title; ?>：</div>
       <div class="options">
            <?php 
            foreach ($data['options'] as $key=>$option){
            ?>
            <?php } ?>
       </div>  
    </div>
    <div class="now-answer">还有:<span><?php echo $data['count']-$page-1;?></span>道题</div>
</div>

    
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>