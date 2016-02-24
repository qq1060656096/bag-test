<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $row common\models\Survey */
$this->title = 'Surveys';
$this->params['breadcrumbs'][] = $this->title;

echo $this->renderFile(__DIR__.'/../layouts/head.php');
?>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>
<div id="main_body">
    <header class="s_header">
		<nav>


			<a href="http://m.xinli001.com/" class="bg"> <span>首页</span>
			</a> <span id="more">心理导航</span> <span style="font-size: 1.4rem">心理测试</span>
		</nav>
	</header>
	
	<section class="s_moreread">
		<div class="list_box">
            <?php 
            foreach ($a_models as $key=>$row){        
            ?>
			<dl>
				<a href="./start.html">
					<dt>
						<img src="./bag-test/test-images/103754b6unkvhquepniein.jpg!50"
							alt="你有多怕谈恋爱：恋爱恐怖程度自评">
					</dt>
					<dd>
						<h3><?php echo $row->id,$row->title;?></h3>
					</dd>
					<dd><?php echo $row->intro;?></dd>
					<dd>
						<span>测试过：<?php echo $row->answer_count;?></span>
					</dd>
				</a>
			</dl>
            <?php }?>
			

		</div>
		<div class="load_more">加载更多</div>
	</section>
	
	
	
    <?php 
    //屏蔽分页
	/*  echo \yii\widgets\LinkPager::widget([
    'pagination' => $pagination,
	]); */ 
	?>	

</div>
<script type="text/javascript">
ajaxLoad();
/**
 * ajax加载分页
 */
function ajaxLoad(){
	page = 1;
	isAjaxLoad = false; 
    $(".load_more").click(function(){
        var now =$(this);
        page++;
        var url = "<?php echo Yii::$app->urlManager->createUrl(['survey/index-ajax','page'=>'#page#']);?>";
        url = url.replace('%23page%23',page);
        
        //有没有执行ajax就执行ajax,在执行，等执行后在加载
        if(!isAjaxLoad){
        	isAjaxLoad = true;
        	now.text('加载中');
            $.get(url,function(html){
            	now.text('加载更多');
            	isAjaxLoad = false;
                console.log(html);
                //没有找到
                if(html==''){
                	isAjaxLoad = true;
                	now.text('已经没有了');
                	console.log('已经没有了');
                }
                $(".list_box").append( html );
            });
        }
    });
}
</script>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>