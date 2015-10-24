<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZCommonFun;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);

/* @var $form yii\widgets\ActiveForm */
$a_SurveyResulte = [];
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');
$this->title=isset($survey_tax[$tax])? $survey_tax[$tax] : $survey_tax['0'];
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
	width: 38%;
	border: none;
	margin: 1em;
}
.s_reg .btn_bg.save{
	float: right;
}

.row>label,.options>select,.options>label{
	margin: 0.5em 0;
	float: left;
}
</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js1"></script>
<div id="main_body">
    <?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
	
    <section class="s_moreread s_reg s_login">
    <?php $form = ActiveForm::begin(['id'=>'form1']); ?>
 <?php $form = ActiveForm::begin(); ?>
        <?php 
        foreach ($a_SurveyResulte as $key=>$row){
        ?>
        <div class="row">
            
            <textarea class="input-name" class="col" name="name[]" ><?php echo $row->name;?></textarea>
            <label clss="">姓名</label>
            <textarea class="input-value"  name="value[]"><?php echo $row->value;?></textarea>    
        </div>
        <?php }?>
        <div class="row">
            <textarea class="input-name" class="col" name="name[]" ></textarea>
            <label clss="">姓名</label>
            <textarea class="input-value"  name="value[]"></textarea>
            <label>结果详情</label>
             
            <textarea class="input-value"  name="intro[]"></textarea>
            <div class="options">
                <label>分数范围</label>
                <select class="option-score"  name="score-min[]"/>
                    <option value="1">1分</option>
                    <option value="2">2分</option>
                    <option value="3">3分</option>
                    <option value="4">4分</option>
                    <option value="5">5分</option>
                </select>
                <select class="option-score"  name="score-max[]"/>
                    <option value="1">1分</option>
                    <option value="2">2分</option>
                    <option value="3">3分</option>
                    <option value="4">4分</option>
                    <option value="5">5分</option>
                </select>
            </div>
         </div>
        <button type="button" class="btn_bg add-btn">增加一个测试结果</button>
        
        <button type="submit" class="btn_bg btn btn-primary save">保存</button>
 <?php ActiveForm::end(); ?>
<div class="template hide">
    <div class="row">
        <textarea class="input-name" class="col" name="name[]" ></textarea>
        <label clss="">姓名</label>
        <textarea class="input-value"  name="value[]"></textarea>
        <label>结果详情</label><textarea class="input-value"  name="intro[]"></textarea>
        <div class="options">
            <label>分数范围</label>
                <select class="option-score"  name="score-min[]"/>
                    <option value="1">1分</option>
                    <option value="2">2分</option>
                    <option value="3">3分</option>
                    <option value="4">4分</option>
                    <option value="5">5分</option>
                </select>
                <select class="option-score"  name="score-max[]"/>
                    <option value="1">1分</option>
                    <option value="2">2分</option>
                    <option value="3">3分</option>
                    <option value="4">4分</option>
                    <option value="5">5分</option>
                </select>
        </div>
    </div>
</div> 

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


    </section>
 </div>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>  