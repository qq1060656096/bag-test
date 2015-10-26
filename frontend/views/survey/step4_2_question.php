<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZCommonFun;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);

/* @var $form yii\widgets\ActiveForm */
$a_SurveyResulte = [];
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');
$this->title=isset($survey_tax[$model->tax])? $survey_tax[$model->tax] : $survey_tax['0'];

// ZCommonFun::print_r_debug($questionData);
?>
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
.s_reg .btn_bg.btn-2{
	margin-left: 5%;
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

</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js1"></script>
<div id="main_body">

    <?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
    <section class="s_moreread s_reg s_login">
    <?php $form = ActiveForm::begin(['id'=>'form1','action'=>['survey/step4_2_question','id'=>$model->id,'page'=>$page+1]]); ?>
        <?php if( isset($questionData['question']) ){?>
        <div class="row">
            <textarea class="textarea-label" class="col" name="label-name" placeholder="问题"><?php echo $questionData['question']->label;?></textarea>
            <input type="hidden" name="qid" value="<?php echo $questionData['question']->question_id;?>"/>
            <?php 
            isset($questionData['options'][0]) ? null : $questionData['options']=[];
            foreach ($questionData['options'] as $key=>$row2){
        
                switch ($row2->option_score){
                    case 5:
                        $select5 = 'selected="selected"';
                        break;
                    case 4:
                        $select4 = 'selected="selected"';
                        break;
                    case 3:
                        $select3 = 'selected="selected"';
                        break;
                    case 2:
                        $select2 = 'selected="selected"';
                        break;
                    default:
                        $select1 = 'selected="selected"';
                        break;
                }
            ?>
            <div class="option">
                <input type="hidden" name="label[qo-id][]" value="<?php echo $row2->qo_id;?>"/>
                <input type="text" value="<?php echo $row2->option_label;?>" class="option-label" name="label[option-label][]" placeholder="选项"/>
                <label>选项得分</label><select class="option-score" name="label[option-score][]"/>
                    
                    <option value="1" <?php echo isset($select1)  ? $select1 : '';?>>1分</option>
                   
                    <option value="2" <?php echo isset($select2)  ? $select2 : '';?>>2分</option>
                    <option value="3" <?php echo isset($select3)  ? $select3 : '';?>>3分</option>
                    <option value="4" <?php echo isset($select4)  ? $select4 : '';?>>4分</option>
                    <option value="5" <?php echo isset($select5)  ? $select5 : '';?>>5分</option>
                </select>
            </div>
            <?php } ?>
         </div>
         <?php }else{ ?>
         <div class="row">
            <textarea class="textarea-label" class="col" name="label-name" placeholder="问题"></textarea>
            <div class="option">
                <input type="text" class="option-label" name="label[option-label][]" placeholder="选项"/>
                <label>选项得分</label><select class="option-score" name="label[option-score][]"/>
                    <option value="1">1分</option>
                    <option value="2">2分</option>
                    <option value="3">3分</option>
                    <option value="4">4分</option>
                    <option value="5">5分</option>
                </select>
            </div>
         </div>
         <?php }?>
         
        <button type="text" class="btn_bg add-btn">增加一个选项</button>
        <button type="submit" class="btn_bg btn btn-primary btn-2" name="save-next">保存/编辑下一题</button>
        <button type="submit" class="btn_bg btn btn-primary" name="save">保存</button>
 <?php ActiveForm::end(); ?>
<div class="template hide">

    <div class="option">
        <input type="text" class="option-label" name="label[option-label][]" placeholder="选项"/>
        <label>选项得分</label><select class="option-score" name="label[option-score][]" />
            <option value="1">1分</option>
            <option value="2">2分</option>
            <option value="3">3分</option>
            <option value="4">4分</option>
            <option value="5">5分</option>
        </select>
    </div>

</div> 

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

    </section>
 </div>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>  