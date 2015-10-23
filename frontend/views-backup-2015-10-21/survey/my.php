<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $row common\models\Survey */
$this->title = '我发布的小测试';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('我要创建测试', ['step1'], ['class' => 'btn btn-success']) ?>
    </p>
   
    <div>
    <?php 
    foreach ($a_models as $key=>$row){
       
        $row_url = Yii::$app->urlManager->createUrl(['survey/step2','id'=>$row->id]);           
    ?>
        <div class="row">
            <img src="" class="l"/>
            <label class="c"><?php echo $row->title;?></label>
            <div class="r">
                <div class="user"><?php echo $row->uid;?></div>
                <div class="answer-count"><?php echo $row->answer_count;?></div>
            </div>
            <a href="<?php echo $row_url?>" > 修改 </a>
        </div>
    <?php }?>
    </div>
    <?php 
	echo \yii\widgets\LinkPager::widget([
    'pagination' => $pagination,
	]);
	?>	

</div>
