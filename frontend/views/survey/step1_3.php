<?php
global $survey_tax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Survey */
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
</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js1"></script>
<div id="main_body">
    
	
	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
	
	<section class="s_moreread s_reg s_login">

    <?php $form = ActiveForm::begin(['id'=>'form1']); ?>
        <h1 class="po_title common-color"><?php echo $model->title;?></h1>
        <p class="intro"><?php echo $model->intro;?></p>
        <?= $form->field($model_Images, 'image') ?>
        <div class="btn_bg" >
			<input type="submit" id="submit" value="保存"> 
		</div>
		<br />

        <?php ActiveForm::end(); ?>

	</section>
		
      
 </div>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>  
