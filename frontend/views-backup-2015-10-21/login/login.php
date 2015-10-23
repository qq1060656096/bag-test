<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
/* @var $model common\models\User */
?>
<div class="survey-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pass')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <button type="submit" class="btn btn-success">登录</button>
    </div>
    <div class="form-group">
        <?php 
        if($model->operationError!==null){
            echo $model->operationMessage;
        }
        ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>    