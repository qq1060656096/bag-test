<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\z\ZCommonFun;
/* @var $model common\models\User */
?>
<div class="survey-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pass')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <button type="submit" class="btn btn-success">注册</button>
    </div>
    <div class="form-group">
        <?php 
        ZCommonFun::print_r_debug($model->errors);
        
        ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>    