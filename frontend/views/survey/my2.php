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
    
	
	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
	
	<section class="s_moreread">
			
			<?php echo $this->renderFile(__DIR__.'/../layouts/header-user.php');?>
			
			<div class="list_box">
    			<?php 
                foreach ($a_models as $key=>$row){              
                    $row_url = Yii::$app->urlManager->createUrl(['answer/step1','id'=>$row->id]);           
                ?>
				<dl>
					<a href="<?php echo $row_url;?>">
						<dt>
							<img src="./bag-test/test-images/103754b6unkvhquepniein.jpg!50"
								alt="<?php echo $row->title;?>">
						</dt>
						<dd>
							<h3><?php echo $row->title;?></h3>
						</dd>
						<dd><?php echo $row->intro;?></dd>
						<dd>
							<span>测试过：<?php echo $row->answer_count;?></span>
						</dd>
					</a>
				</dl>
                <?php } ?>
			</div>
			<div class="load_more">加载更多</div>
			
		</section>
		
      
 </div>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>
