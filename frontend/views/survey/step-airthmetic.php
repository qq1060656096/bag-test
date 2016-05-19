<?php
global $survey_tax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Survey;
use frontend\controllers\SurveyController;
/* @var $this yii\web\View */
/* @var $model common\models\Survey */
/* @var $form yii\widgets\ActiveForm */
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');


$this->title .= '无题测试-步骤4.选择算法';
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
.arithmetic-button.active{
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
        <h3 class="po_title common-color" style="text-align: left;font-weight: bold;text-align: center;"><?php echo $model->title;?></h3>
        <?php
//         echo $model->arithmetic;
        ?>
        <p>
            请选择测试算法，可以同时选择多个算法。
        </p>
        <p>
            大家做测试时，大神蒜将采用你选择的算法，为大家算出最佳结果
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
			<input type="submit" id="submit" value="完成/最后一步 ">
		</div>
		<br />

	    <a style="display:none;" class="btn_bg" href="<?php echo Yii::$app->urlManager->createUrl(['survey/done','id'=>$model->id]);?>">
	       <input type="button" value="预览">
	    </a>


        <?php ActiveForm::end(); ?>
        <p class="text-hint">
        （1）选择算法后保存，在下一步，你需要预览一下已经添加的全部内容。如果没有问题，发布出去之后，成千上万的人都可以做这个测试啦。<br/>
（2）后面还有最后1个步骤，这个测试就能创建完毕，加油。
        </p>

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

	    if( $(this).hasClass('active') ){
	    	$(this).removeClass('active')
		 }else{
			 $(this).addClass('active');
		 }
	    console.log( $(this).hasClass('active') );
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
 <?php echo $this->renderFile(__DIR__.'/../layouts/group-add.php');?>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>
