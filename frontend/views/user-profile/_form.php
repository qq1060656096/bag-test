<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserProfile;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

echo $this->renderFile(__DIR__.'/../layouts/head.php');
?>
<div id="main_body">
    <header class="s_header">
		<nav>


			 <span style="font-size: 1.4rem"><?php echo $this->title;?></span>
		</nav>
	</header>
	<section class="s_reg s_login">
    	<div class="notice" title="太好了，完成最后一步吧^o^~">&nbsp;</div>
    	<?php $form = ActiveForm::begin(); ?>
    	
    		
    		<div class="input-wrap">
    			<?= $form->field($model, 'nickname')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'昵称']) ?>
    		</div>
    	
    		<div class="input-wrap">
    			<?= $form->field($model, 'sex')->dropDownList(UserProfile::$sexData,['maxlength' => true,'class'=>'','placeholder'=>'性别']) ?>
    		</div>
    		<div class="input-wrap">
    			<?= $form->field($model, 'birthday')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'生日']) ?>
    		</div>
    		<div class="input-wrap">
    			<?= $form->field($model, 'address')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'地址']) ?>
    		</div>
    		<div class="input-wrap">
    			<?= $form->field($model, 'intro')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'简介']) ?>
    		</div>
    		<div class="input-wrap">
    			<?= $form->field($model, 'qq')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'QQ']) ?>
    		</div>
    		
    		<div class="input-wrap">
    			<?= $form->field($model, 'school')->textInput(['maxlength' => true,'class'=>'','placeholder'=>'学校']) ?>
    		</div>
    		<input type="submit" id="submit" value="完 成">
    	<?php ActiveForm::end(); ?>
    </section>

</div>
<style>
div.notice{
margin: 0;
}
.s_login div{
padding: 3px;
}
label, label input {
    vertical-align: middle;
    width: 60px;
    display: inline-block;
    text-align: right;
    padding-right: 5px;
}
</style>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>