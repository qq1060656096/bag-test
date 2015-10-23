<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZCommonFun;
/* @var $model common\models\Survey */
// ZCommonFun::print_r_debug($data['options']);
?>
<div>
    <h3><?php echo $model->title; ?></h3>
    <img src="" />
    <div class="intro">
        <?php echo $model->intro; ?>
    </div>
    
</div>
<?php $form = ActiveForm::begin(); ?>
<div class="answer">
    <h3><?php echo $model->title; ?></h3>
    <?php 
    foreach ($data['questions'] as $key=>$question){
    ?>
    <div class="row" <?php echo $key==0?  null : 'style="display: none;';?>">
       <div class="question"><?php echo $question->label; ?>：</div>
       <div class="options">
            <?php 
            isset($data['options'][$key]) ? null : $data['options'][$key]=[];
            foreach ($data['options'][$key] as $key2=>$option){
            ?>
                <div><input type="radio" name="options[<?php echo $question->question_id; ?>][]" value="<?php echo $option->qo_id;?>"/> <?php echo $option->option_label;?></div>   
            <?php } ?>
       </div>  
    </div>
    <?php }?>
    <div class="now-answer" count="<?php echo $data['question_total_count'];?>" nowCount="1">还有:<span class="question-count"><?php echo $data['question_total_count'];?></span>道题</div>
    <button type="submit" name="save" id="save">提交</button>
</div>
<?php ActiveForm::end(); ?>
<script type="text/javascript">

</script>
<script type="text/javascript" src="./common/js/birthdaypicker-master/bday-picker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".row").click(function(){
        $(this).attr('style','display: none;');
        $(this).next().removeAttr('style');
        var count = $(".question-count").text();
        count--;
        if(count==0){
        	$("#save").show();
        	$(".now-answer").hide();
        }
        	$(".question-count").text(count);
        
        
    });

});
</script>
<style type="text/css">
  html, body { height: 100%; margin: 0; padding: 0; }
  h1 { margin: 0; padding-top: 20px; }
  fieldset { padding: none; border: none; }
  #container { height: 100%; width: 600px; margin: 0 auto; padding: 0 50px; background: #eee; }
  .row{
       padding: 10px;
  }
  #save{display: none;}
</style>