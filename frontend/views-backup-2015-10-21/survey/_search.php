<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SurverySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="survey-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'tax')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'title') ?>

    <?php  echo $form->field($model, 'intro') ?>

    <?php // echo $form->field($model, 'theme') ?>

    <?php // echo $form->field($model, 'theme_mobile') ?>

    <?php // echo $form->field($model, 'is_publish') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'answer_count') ?>

    <?php // echo $form->field($model, 'visit_count') ?>

    <?php // echo $form->field($model, 'pass') ?>

    <?php // echo $form->field($model, 'is_public') ?>

    <?php // echo $form->field($model, 'is_statistics_public') ?>

    <?php // echo $form->field($model, 'max_answer_count') ?>

    <?php // echo $form->field($model, 'is_share_template') ?>

    <?php // echo $form->field($model, 'answer_total_time') ?>

    <?php // echo $form->field($model, 'answer_average_time') ?>

    <?php // echo $form->field($model, 'answer_limit_time') ?>

    <?php // echo $form->field($model, 'reward_total') ?>

    <?php // echo $form->field($model, 'reward_average') ?>

    <?php // echo $form->field($model, 'reward_count') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
