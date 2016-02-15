<?php 
global $survey_tax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZCommonFun;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);

/* @var $form yii\widgets\ActiveForm */
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
}
.s_reg .btn_bg{
	float: left;
	width: 40%;
	border: none;
	margin: 1em;
}
.s_reg .btn_bg.save{
	float: right;
}
</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js1"></script>
<div id="main_body">
    <?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
	
    <section class="s_moreread s_reg s_login">
    <?php $form = ActiveForm::begin(['id'=>'form1']); ?>
        <h1 class="po_title common-color"><?php echo $model->title;?></h1>
        <p class="intro"><?php echo $model->intro;?></p>
        <?php 
        foreach ($a_SurveyResulte as $key=>$row){
        ?>
        <div class="row">
            
            <textarea class="input-name" class="col" name="name[]" ><?php echo $row->name;?></textarea>
            <label class="label-name">姓名</label>
            <textarea class="input-value"  name="value[]"><?php echo $row->value;?></textarea>   
            <input type="hidden" name="sr-id[]" value="<?php echo $row->sr_id;?>" />
            
        </div>
        <?php }?>
        <div class="row">         
            <textarea class="input-name" class="col" name="name[]"></textarea>
            <label class="label-name">姓名</label>
            <textarea class="input-value"  name="value[]"></textarea>    
        </div>
        <button type="button" class="btn_bg add-btn">增加一个测试结果</button>
        
        <button type="submit" class="btn_bg save">保存</button>

 <?php ActiveForm::end(); ?>
<div class="template hide">
 <div class="row">
    <textarea class="input-name" class="col" name="name[]"></textarea>
    <label class="label-name">姓名</label>
    <textarea class="input-value"  name="value[]"></textarea>
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
  <?php echo $this->renderFile(__DIR__.'/../layouts/group-add.php');?>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>
