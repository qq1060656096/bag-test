<?php

use yii\helpers\Html;
use common\models\Survey;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\Survey */

$this->title = 'Create Survey';
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
