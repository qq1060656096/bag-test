<?php
global $survey_tax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\controllers\SurveyController;
/* @var $this yii\web\View */
/* @var $model common\models\Survey */
/* @var $form yii\widgets\ActiveForm */
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');
$this->title=isset($survey_tax[$tax])? $survey_tax[$tax] : $survey_tax['1'];

$this->title .= '-步骤1/'.SurveyController::stepCount($tax);
// if($model->title):
//     $this->title .='.'.$model->title;
// endif;
$this->title .='.标题介绍';
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
	font-weight: 100;
}
.s_reg form{
	margin-top: 1em;
}

</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js1"></script>
<div id="main_body">
    
	
	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
	
	<section class="s_moreread s_reg s_login">
		<?php //echo $this->renderFile(__DIR__.'/../layouts/header-user.php');?>


        <?php $form = ActiveForm::begin(['id'=>'form1']); ?>
    
        <?= $form->field($model, 'tax')->hiddenInput()->label(false); ?>

        <?= $form->field($model, 'title')->textInput(['placeholder'=>'请输入测试名称，限15个字','maxlength'=>15]); ?>
    
        <?php  echo $form->field($model, 'intro')->textarea(['placeholder'=>'请输入测试简介，限70个字','maxlength'=>70]) ?>
    
        
        <div class="btn_bg" >
			<input type="submit" id="submit" value="保存/下一步"> 
		</div>
		<br />
    	<?php 
    	/*
	    <a class="btn_bg" href="<?php echo Yii::$app->urlManager->createUrl(['survey/done','id'=>$model->id]);?>">
	       <input type="button" value="预览"> 
	    </a> 
	    */
		?>
        <?php ActiveForm::end(); ?>

            <p class="text-hint">保存标题介绍后，在下一步，你需要为这个测试题上传一张封面图片。后面还有<?php echo SurveyController::stepCount($tax)-1;?>个步骤，这个测试就能创建完毕。</p>
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
</style> 
 <?php echo $this->renderFile(__DIR__.'/../layouts/group-add.php');?>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>    
