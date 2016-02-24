<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Survey */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="survey-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model_Images, 'image') ?>

    <div class="image-editor">
      <input type="file" class="cropit-image-input">
      <div class="cropit-image-preview"></div>
      <div class="image-size-label">
        Resize image
      </div>
      <input type="range" class="cropit-image-zoom-input">
      <button class="export">Export</button>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model_Images->isNewRecord ? '保存' : '保存', ['class' => $model_Images->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
style>
      .cropit-image-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 400px;
        height: 400px;
        cursor: move;
      }

      .cropit-image-background {
        opacity: .2;
        cursor: auto;
      }

      .image-size-label {
        margin-top: 10px;
      }

      input {
        display: block;
      }

      .export {
        margin-top: 10px;
      }
    </style>