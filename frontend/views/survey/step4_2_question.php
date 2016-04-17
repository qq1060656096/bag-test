<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZCommonFun;
use frontend\controllers\SurveyController;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);

/* @var $form yii\widgets\ActiveForm */
$a_SurveyResulte = [];
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');
$this->title=isset($survey_tax[$model->tax])? $survey_tax[$model->tax] : $survey_tax['0'];
$submitAddText = '';
$submitNexText = '';
$text_hint= '';
switch ($model->tax):
    case 1:

    break;
    case 2:
        $this->title .= '-步骤4/'.SurveyController::stepCount($model->tax).'.预览题目分数区间';
        $submitAddText = '保存/增加';
        $submitNexText = '保存/下一步预览分数区间';
        $text_hint = "（1）点击“增加一题”后，你可以再添加一道选择题。<br />
（2）添加完所有选择题后保存。在下一步，你需要创建至少一个测试结果。<br />（3）后面还有".( SurveyController::stepCount($model->tax)-3 )."个步骤，这个测试就能创建完毕。";
        break;
    case 3:
        $this->title .= '-步骤3/'.SurveyController::stepCount($model->tax).'.添加题目';
        $submitAddText = '保存/增加';
        $submitNexText = '保存/下一步添加结果';
        $text_hint = "（1）点击“增加一题”后，你可以再添加一道选择题。<br />
（2）添加完所有选择题后保存。在下一步，你需要创建至少一个测试结果。<br />（3）后面还有".( SurveyController::stepCount($model->tax)-3 )."个步骤，这个测试就能创建完毕。";
        break;
endswitch;
// ZCommonFun::print_r_debug($questionData);
?>
<link rel="stylesheet" href="./css/edit.css">
<style>
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
	margin-top: 0.5em;
}
.s_reg .btn_bg:last-child{

	float: right;
}
.s_reg .btn_bg.btn-3{
	margin-left: 3.8%;
}
.s_reg .btn_bg.btn-100{
	width: 98.5%;
	float: left;
	margin-top: 10px;
}
.s_reg .btn_bg.btn-r{
	float: right;
}
.s_reg .btn_bg.save{
	float: right;
}
.option{

	text-align: left;
}
.option>label,.option>select{
	margin: 0.5em 0;
	float: left;
}

.option-score{
	display:inline-block;
	width: 5em;
}
.s_reg form{
	text-align: left;
}
.row textarea, .row input, .s_reg input[type=text], .s_reg input[type=password], .s_reg textarea{
	margin:0;
	line-height: 40px;height: 40px;
}
.Q_Style_con .Q_Sytle_input{ padding:0; line-height: 40px;height: 40px;}
.add_question{
	    cursor: pointer;
}
.Q_Style_con{
	margin-top: 15px;
}
.option-warp{
	position: relative;
}
.option-score {
	line-height: 40px;
	height: 43px;
    float: right;
    position: absolute;
    right: 0;
}
.add_question i {
    display: block;
    position: absolute;
    top: 9px;
    left: -20px;
    color: #2E8EC1;
}
<?php
if( $model->tax==3 ) echo 'select.option-score{display: none;}';
?>
</style>
<script>
function loadSelect(element,selected,start,end){
	start = start ? start : 1;
	end = end ? end : 5;
	selected = selected ? selected : $(element).attr('selectedvalue');
	var html = loadOptions(start,end,selected);
	$(element).append(html);
}
function loadOptions(start,end,selected){
	var html = '';
	for(var i=0;start<=end;start++){
		if(selected==start){
			html += '<option selected="selected" value="'+start+'">'+start+'分</option>';
	    }else{
	    	html += '<option value="'+start+'">'+start+'分</option>';
		}
	}
	console.log(html);
	return html;
}
var question_count=<?php echo $questionData['count'];?>;
$(document).ready(function(){
	$(".option-score").each(function(){
		loadSelect(this);
	});
	//添加元素
	$(".add_question").click(function(){
		var html = '<li>'
			      +'    <div class="option-warp">'
			      +'          <input class="option-label Q_Sytle_input " placeholder="请输入选项名称" oid="" value=""  name="label[option-label][]">'
			      +'          <select class="option-score" name="label[option-score][]">'+loadOptions(1,5,1)+'</select>'
			      +'     </div>'
		          +'   </li>';
	    $(this).closest('.Q_Style_con').find('.unstyled').append(html);

    });
	$(".add_question").click();

	$("form").submit(function(){
	  //是否有结果
	  var hasResulte = 0;
	  $(".unstyled").each(function(){
		    var name = $('input:eq(0)',this).val();
		    var value = $('.option-score',this).val();
		    if(name&&value){
		    	hasResulte ++;
		    }
		    console.log(this);
		    console.log(name+'==='+value);
	  });
	  //如果没有结果
	  /* if( hasResulte<1&&question_count<1){
		  alert("至少正确填写一条问题");
		  return false;
	  } */
	  return true;
	});


});
</script>
<?php

?>
<div id="main_body">

    <?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
    <section class="s_moreread s_reg s_login">
    <?php $form = ActiveForm::begin(['id'=>'form1','action'=>['survey/step4_2_question','id'=>$model->id,'page'=>$page+1]]); ?>



        <?php if( isset($questionData['question']) ){?>

        <div class="row">
            <div class="BlankBlock">
                <div class="BlockTitle">
                    <h2 class="text-red">第<?php echo $page;?>题&nbsp;题目与选项</h2>
                </div>
                <div class="BlockCon InputBor">
                    <input type="hidden" name="qid" value="<?php echo $questionData['question']->question_id;?>"/>
                    <input class="topic_input" type="text" placeholder="请输入题目名称" name="label-name" id="question_title" value="<?php echo $questionData['question']->label;?>">
                </div>
            </div>
            <div class="Q_Style_con">
                <ul class="unstyled">
                    <?php
                    isset($questionData['options'][0]) ? null : $questionData['options']=[];
                    foreach ($questionData['options'] as $key=>$row2){
                    ?>
                    <li>
                        <div class="option-warp">
                        	<input type="hidden" name="label[qo-id][]" value="<?php echo $row2->qo_id;?>"/>
                            <input class="option-label Q_Sytle_input " placeholder="请输入选项名称"
                            value="<?php echo $row2->option_label;?>"
                            oid=""  name="label[option-label][]">
                            <select class="option-score" name="label[option-score][]"
                            onload="loadSelect(this)"
                            selectedvalue="<?php echo $row2->option_score; ?>">
                            </select>
                        </div>
                    </li>
                    <?php } ?>
                 </ul>
                <div class="add_question">
                    <i class="fa fa-plus"></i>
                                            添加选项
                </div>
            </div>
        </div>

         <?php }else{ ?>
         <div class="row">
            <div class="BlankBlock">
                <div class="BlockTitle">
                    <h2>第<?php echo $page;?>题&nbsp;题目标题</h2>
                </div>
                <div class="BlockCon InputBor">
                    <input class="topic_input" type="text" placeholder="请输入题目名称" name="label-name" id="question_title">
                </div>
            </div>
            <div class="Q_Style_con">
                <ul class="unstyled">

                 </ul>
                <div class="add_question">
                    <i class="fa fa-plus"></i>
                                            添加选项
                </div>
            </div>
        </div>
         <?php }?>

         <div class="btn_bg btn-2" >
			<a
			href="<?php echo Yii::$app->urlManager->createUrl(['survey/step1_3','id'=>$model->id]);?>"
			id="prev-step">上一步</a>
		</div>

        <button type="submit" class="btn_bg btn btn-primary btn-3" name="save-next"><?php echo $submitAddText;?></button>

        <button type="submit" class="btn_bg btn btn-primary btn-r" name="save"><?php echo $submitNexText;?></button>

        <a class="btn_bg" style="display:none;width: 98.5%;margin-top: 15px;"
		href="<?php echo Yii::$app->urlManager->createUrl(['survey/done','id'=>$model->id]);?>">
	       <input type="button"  value="预览">
	    </a>
        <div class="btn_bg btn-2 btn-100" >
			<a
			href="<?php echo Yii::$app->urlManager->createUrl(['survey/question-delete','id'=>$model->id,'page'=>$page]);?>"
			id="prev-step">删除</a>
		</div>


 <?php ActiveForm::end(); ?>
<p class="text-hint">&nbsp;</p>
<p class="text-hint"><?php echo $text_hint; ?></p>


    </section>
 </div>
  <?php echo $this->renderFile(__DIR__.'/../layouts/group-add.php');?>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>