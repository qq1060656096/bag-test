<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZCommonFun;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);

/* @var $form yii\widgets\ActiveForm */
?>
 <?php $form = ActiveForm::begin(); ?>
        <?php
        $a_SurveyResulte?null : $a_SurveyResulte=[];
        foreach ($a_SurveyResulte as $key=>$row){
        ?>
        <div class="row">
            
            <textarea class="input-name" class="col" name="name[]" ><?php echo $row->name;?></textarea>
            <label clss="">姓名</label>
            <textarea class="input-value"  name="value[]"><?php echo $row->value;?></textarea>    
        </div>
        <?php }?>
        <div class="row">         
            <textarea class="input-name" class="col" name="name[]"></textarea>
            <label clss="">姓名</label>
            <textarea class="input-value"  name="value[]"></textarea>    
        </div>
        <button type="text" class="add-btn">增加一个测试结果</button>
        
        <button type="submit" class="btn btn-primary">保存</button>
 <?php ActiveForm::end(); ?>
<div class="template hide">
 <div class="row">
    <textarea class="input-name" class="col" name="name[]"></textarea>
    <label clss="">姓名</label>
    <textarea class="input-value"  name="value[]"></textarea>
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
	    $(this).before( template );
	    return false;
	});

	$("form").submit(function(){
	  //是否有结果
	  var hasResulte = 0;
	  $(".row").each(function(){
		    var name = $('textarea:eq(0)',this).val();
		    var value = $('textarea:eq(1)',this).val();
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