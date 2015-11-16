<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfileSeach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-profile-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'nickname') ?>

    <?= $form->field($model, 'head_image') ?>

    <?= $form->field($model, 'money') ?>

    <?php // echo $form->field($model, 'friend_money') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'intro') ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'qq') ?>

    <?php // echo $form->field($model, 'school') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
