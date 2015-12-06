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
/**
 * 显示跳转到多少题
 * @param unknown $name
 * @param unknown $start
 * @param unknown $end
 * @param string $select
 * @return string
 */
function selectShow($name,$start,$end,$select=''){
    if($start-1==$end){
        return '';
    }
    echo '<select class="select-question" name="',$name,'"><option value="" >请选择跳转问题</option>';
    
    for($start;$start<=$end;$start++){
        $selected = $select==$start ? 'selected="selected"':'';
        echo '<option ',$selected,' value="',$start,'">跳转到',$start,'题</option>';
    }
    echo '</select>';
}

// ZCommonFun::print_r_debug($models_SurveyResulte);
// exit;
function selectShowResulte($models_SurveyResulte,$selected_id,$name=''){
    $i = 0;
    echo '<select class="select-resulte" name="',$name,'"><option value="" >请选择结果</option>';
    foreach ($models_SurveyResulte as $key=>$row){
        $selected = $selected_id==$row->sr_id ? 'selected="selected"':'';
        $i++;
        echo  '<option value="',$row->sr_id,'" ',$selected,'>结果',$i,'</option>';
        
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
								    <?php echo selectShowResulte($models_SurveyResulte, $option->skip_resulte,"resulte[{$option->qo_id}]");?>
							</label><br/>
                            <?php } ?>

						</div>
					</fieldset>
					
				</div>
                <?php } ?>

			</div>
			<div class="s_reg">
			<a class="btn_bg" href="javascript:void(0);">
    			<input type="submit" id="submit" value="保存"> 
    		</a>
    		</div>
    		<br />
    		<br />
    		<br />
    		<br />
    		<br />
        <?php ActiveForm::end(); ?>
</section>    
<script type="text/javascript">
$(document).ready(function(){
	//点击问题
	$("label").on('click','.select-question',function(){
		var value = $(this).val();
		var resulte = $(this).closest('label').find('.select-resulte');
		if(value>0){
			
			resulte.find('option:selected').attr('selected',false);
			resulte.hide();
		    console.log(value+'--'+resulte.val() );
	    }else{
	    	resulte.show();
		}
	});

	//点击结果
	$("label").on('click','.select-resulte',function(){
		var value = $(this).val();
		var resulte = $(this).closest('label').find('.select-question');
		if(value>0){
			resulte.find('option:selected').attr('selected',false);
			resulte.hide();
		    console.log(value+'--'+resulte.val() );
	    }else{
	    	resulte.show();
		}
	});
	$(".select-question,.select-resulte").click();
});
</script>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>