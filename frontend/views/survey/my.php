<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $row common\models\Survey */
$this->title = '个人中心';
$this->params['breadcrumbs'][] = $this->title;

echo $this->renderFile(__DIR__.'/../layouts/head.php');
?>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>
<div id="main_body">
    <header class="s_header">
		<nav>


			 <span style="font-size: 1.4rem"><?php echo $this->title;?></span>
		</nav>
	</header>
	
	<section class="s_moreread">
		<div class="list_box">
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
		<div class="load_more">加载更多</div>
    </section>
      
 </div>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>
