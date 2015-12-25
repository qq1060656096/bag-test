<?php
global $survey_tax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Survey;

/* @var $this yii\web\View */
/* @var $model common\models\Survey */
/* @var $form yii\widgets\ActiveForm */
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');



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
.arithmetic-button{
	padding: 0;
	margin: 0;
	width: 40%;
	height: 50px;
	line-height: 50px;
	border: 3px solid #E46C0A;
	    border-radius: 15px;
	color: #E46C0A;
	font-weight:bold;
	font-size: 25px;
	margin-bottom: 10px;
	background: #fff;
	
}
.arithmetic-button:hover,.arithmetic-button.active{
	color: #fff;
	background: #E46C0A;
}
</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js1"></script>
<div id="main_body">
    
	
	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
	
	<section class="s_moreread s_reg s_login">
		<?php //echo $this->renderFile(__DIR__.'/../layouts/header-user.php');?>


        <?php $form = ActiveForm::begin(['id'=>'form1']); ?>
    
        <?php 
//         echo $model->arithmetic;
        ?>
        <p>
            请选择测试算法。大家使用您的测试时，系统将采用您选择的算法，为大家测出最佳结果 
        </p>
        <br />
        <?= $form->field($model, 'arithmetic')->hiddenInput(['placeholder'=>'选择算法'])->label(false); ?>
        <div class="form-group">
        <?php 
        $arr = $model->arithmetic!='' ? explode(',', $model->arithmetic):null;
        $arr?null:$arr=[];
        foreach (Survey::$arithmeticList as $key=>$value){
            $active = '';
            if(in_array($key, $arr)){
                $active = 'active';
            }
        ?>
        <button type="button" stepid="<?php echo $key;?>" class="arithmetic-button arithmetic-button-<?php echo ($key+1)%2 ,' ',$active?>"><?php echo $value ?></button>
       <?php }?>
     
       </div>
       <br/>
       <?php 
       $test_url = $model->tax==1 ? Yii::$app->urlManager->createUrl(['answer/step1','id'=>$model->id])
       : Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$model->id]);
       $pre_url    = Yii::$app->urlManager->createUrl(['survey/step4_2','id'=>$model->id]);
       ?>
       <a class="btn_bg" href="<?php echo $pre_url;?>">
	       <input type="button" value="上一步"> 
	    </a> 
       <br />
        <div class="btn_bg" >
			<input type="submit" id="submit" value="保存/完成"> 
		</div>
		<br />
    	
	    <a class="btn_bg" href="<?php echo Yii::$app->urlManager->createUrl(['survey/done','id'=>$model->id]);?>">
	       <input type="button" value="预览"> 
	    </a> 
		
		
        <?php ActiveForm::end(); ?>


	</section>
		
      
 </div>
<style>
.s_header nav,.s_reg .btn_bg,.s_reg input[type=submit]{
	
}

label, label input {
    vertical-align: middle;
    font-size: 2em;
	line-height: 2em;
	vertical-align:top;
}
.arithmetic-button-1{
	float: left;
	margin-left: 5%;
}
.arithmetic-button-0{
	float: right;
	margin-right: 5%;
}
</style> 
<script type="text/javascript">
$(document).ready(function(){
	$(".arithmetic-button").click(function(){
	    $(this).hasClass('active')? $(this).removeClass('active'): $(this).addClass('active');
	});

	$("#submit").click(function(){
		var len = $(".arithmetic-button.active").length;
		if( len <1 ){
			alert("请选择算法");
		    return false;
		}
		var arr = new Array();
		$(".arithmetic-button.active").each(function(){
			arr.push($(this).attr('stepid'));
	    });
	    var text = arr.join(',');
	    $("#survey-arithmetic").val( text );
		return true;
	});
});
</script>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>    
