<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZCommonFun;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);

/* @var $form yii\widgets\ActiveForm */
$a_SurveyResulte = [];
?>
<h1>分数型问题添加</h1>
 <?php $form = ActiveForm::begin(); ?>
        
        <div class="row">
            <textarea class="textarea-label" class="col" name="label-name"></textarea>
            <div class="option">
                <input type="text" class="option-label" name="label[option-label][]" />
                <select class="option-score" name="label[option-score][]"/>
                    <option value="1">1分</option>
                    <option value="2">2分</option>
                    <option value="3">3分</option>
                    <option value="4">4分</option>
                    <option value="5">5分</option>
                </select>
            </div>
         </div>
        <button type="text" class="add-btn">增加一个测试结果</button>
        
        <button type="submit" class="btn btn-primary" name="save-next">保存/编辑下一题</button>
        <button type="submit" class="btn btn-primary" name="save">保存</button>
 <?php ActiveForm::end(); ?>
<div class="template hide">

    <div class="option">
        <input type="text" class="option-label" name="label[option-label][]"/>
        <select class="option-score" name="label[option-score][]"/>
            <option value="1">1分</option>
            <option value="2">2分</option>
            <option value="3">3分</option>
            <option value="4">4分</option>
            <option value="5">5分</option>
        </select>
    </div>

</div> 
<style>
.row{
	border: 1px solid #999;
	padding: 10px;
}        
</style>
<script>
$(document).ready(function(){
	var template = $(".template").html();
	console.log(template);
	$(".add-btn").click(function(){
	    $(".row").append( template );
	    return false;
	});

	$("form").submit(function(){
	  //是否有结果
	  var hasResulte = 0;
	  $(".option").each(function(){
		    var name = $('input:eq(0)',this).val();
		    var value = $('.option-score',this).val();
		    if(name&&value){
		    	hasResulte ++;
		    }
		    console.log(this);
		    console.log(name+'==='+value);
	  });
	  //如果没有结果
	  if( hasResulte<1){
		  alert("至少正确填写一条结果");
		  return false;
	  }
	  return true;
	});
});
</script>