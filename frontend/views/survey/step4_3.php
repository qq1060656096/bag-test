<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZCommonFun;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);

/* @var $form yii\widgets\ActiveForm */

// echo $this->renderFile(__DIR__.'/../layouts/head.php');
// echo $this->renderFile(__DIR__.'/../layouts/head-answer.php',['model'=>$model]);
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');
function selectShow($name,$start,$end,$select=''){
    if($start-1==$end){
        return '';
    }
    echo '<select name="',$name,'"><option value="" >请选择</option>';
    
    for($start;$start<=$end;$start++){
        $selected = $select==$start ? 'selected="selected"':'';
        echo '<option ',$selected,' value="',$start,'">跳转到',$start,'题</option>';
    }
    echo '</select>';
}
$this->title="跳转设置--跳转型测试";
?>
<style>
.s_login div,.s_reg div{
	padding:0;
	text-align: left;
}
.s_reg .btn_bg{
	display: block;
}
fieldset {
	border:none;
}
.question-item{
	display:block;
}
</style>
<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
<section class="s_moreread s_reg s_login">
        <?php $form = ActiveForm::begin(['id'=>'id-form']); ?>
            <div id="id_question_list" style="display: none1" data-type="score">

                <?php 
                $question_count = count($data['questions']);
                foreach ($data['questions'] as $key=>$question){
                ?>
				<div id="id_question_list" class="question-item">
					<div class="hide">第<?php echo $key+1;?>题</div>

					<fieldset data-role="controlgroup"
						class="ui-corner-all ui-controlgroup ui-controlgroup-vertical">
						<div role="heading" class="ui-controlgroup-label"><?php echo $key+1,'.',$question->label; ?></div>
						<div class="ui-controlgroup-controls">
							<?php 
                            isset($data['options'][$key]) ? null : $data['options'][$key]=[];
                            foreach ($data['options'][$key] as $key2=>$option){
                            ?>	
							<label for="option-id-<?php echo $option->qo_id;?>" >
						
									<input type="radio" id="option-id-<?php echo $option->qo_id;?>" name="options[<?php echo $question->question_id; ?>][]" value="<?php echo $option->qo_id;?>">
									<span ><?php echo $option->option_label;?></span>
								    <?php echo selectShow("option[{$option->qo_id}]", $key+2, $question_count,$option->skip_question);?>
							</label><br/>
                            <?php } ?>

						</div>
					</fieldset>
					
				</div>
                <?php } ?>

			</div>
			<div class="s_reg">
			    <div class="btn_bg btn-2" >
        			<a 
        			href="<?php echo Yii::$app->urlManager->createUrl(['survey/step4_2_question','id'=>$model->id]);?>" 
        			id="prev-step">上一步</a> 
        		</div>
    			<a class="btn_bg" href="javascript:void(0);" style="margin: 15px auto;">
        			<input type="submit" id="submit" name="save" value="保存"> 
        		</a>
        		
        		<a class="btn_bg" style="margin: 0 auto; "
		href="<?php echo Yii::$app->urlManager->createUrl(['survey/done','id'=>$model->id]);?>">
	       <input type="button"  value="预览"> 
	    </a> 
    		</div>
    		<br />
    		<br />
    		<br />
    		<br />
    		<br />
        <?php ActiveForm::end(); ?>
</section>    
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>