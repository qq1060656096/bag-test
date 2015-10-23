<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Survey */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'tax',
            'uid',
            'title',
            'intro',
            'theme',
            'theme_mobile',
            'is_publish',
            'created',
            'start_date',
            'end_date',
            'answer_count',
            'visit_count',
            'pass',
            'is_public',
            'is_statistics_public',
            'max_answer_count',
            'is_share_template',
            'answer_total_time:datetime',
            'answer_average_time:datetime',
            'answer_limit_time:datetime',
            'reward_total',
            'reward_average',
            'reward_count',
        ],
    ]) ?>

</div>
