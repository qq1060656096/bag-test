<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $model common\models\Survey */
global $share_url,$image;
echo $this->renderFile(__DIR__ . '/../layouts/head-answer.php',['model'=>$model]);


?>
<script type="text/javascript">
$(document).ready(function(){
	answerStart();
	answerPrevQuestion();
	answer();
});
//开始答题
function answerStart(){
	$("#id_start_ceshi").click(function(){
		//测试简介隐藏
// 		$("#id_ceshi_show").hide();
		$(this).hide().next().hide();
		$('#front-img').hide();
		//显示测试答题
		$("#id_question_list").show();
		return false;
	});
}
//回到上一题
function answerPrevQuestion(){
	$(".prev").click(function(){
		var now_question = $(this).closest('.question-item');
		if(now_question){
			console.log( now_question );
			now_question.hide();//隐藏当前问题
			now_question.prev().show();//显示上一个问题
		}
	});
}
//问题点击，显示下一题
function answer(){
	$("label>input").click(function(){
		var now_question = $(this).closest('.question-item');
		if(now_question){
			console.log( now_question );
			var next = now_question.next();
			//如果不是最后一个问题
			if(next.length>0){
				now_question.hide();//隐藏当前问题
				console.log(next);
				next.show();//显示下个问题
			}
			
		}
		
	});
}
</script>
<div data-role="page" id="id_ceshi_page" data-url="id_ceshi_page"
	data-dom-cache="false" tabindex="0"
	class="ui-page ui-body-c ui-page-active" style="min-height: 934px;">

	<header class="s_header">
		<nav>
            <span style="font-size: 1.4rem"><?php echo $model->title;?></span>
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
				<img src="<?php echo $image;?>" id="front-img"
					alt="<?php echo $model->title;?>">
			</div>
			<div><?php echo $model->intro;?></div>
			<a href="http://m.xinli001.com/ceshi/99897421/#" id="id_start_ceshi"
				class="ui-link">开始测试</a> 
				<span class="stip">此测试仅供娱乐，不做专业指导！</span>

            
            <?php echo $this->renderFile(__DIR__.'/../layouts/share.php');?>
		
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
        
		
	</div>
    <?php 
        echo $this->renderFile(__DIR__ . '/../comment/static-list.php',['model'=>$model]);
    ?>

</div>
<!-- /page -->
<?php 
echo $this->renderFile(__DIR__ . '/../layouts/foot-comment.php');
?>

<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>