<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Survey */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="survey-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tax')->textInput() ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'theme')->textInput() ?>

    <?= $form->field($model, 'theme_mobile')->textInput() ?>

    <?= $form->field($model, 'is_publish')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'answer_count')->textInput() ?>

    <?= $form->field($model, 'visit_count')->textInput() ?>

    <?= $form->field($model, 'pass')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_public')->textInput() ?>

    <?= $form->field($model, 'is_statistics_public')->textInput() ?>

    <?= $form->field($model, 'max_answer_count')->textInput() ?>

    <?= $form->field($model, 'is_share_template')->textInput() ?>

    <?= $form->field($model, 'answer_total_time')->textInput() ?>

    <?= $form->field($model, 'answer_average_time')->textInput() ?>

    <?= $form->field($model, 'answer_limit_time')->textInput() ?>

    <?= $form->field($model, 'reward_total')->textInput() ?>

    <?= $form->field($model, 'reward_average')->textInput() ?>

    <?= $form->field($model, 'reward_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
