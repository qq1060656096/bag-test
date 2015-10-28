<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
use common\z\ZCommonSessionFun;
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
//                     ZCommonFun::print_r_debug($row->images);  
                    switch( $row->tax){
                        case 1: 
                            $row_url = Yii::$app->urlManager->createUrl(['answer/step1','id'=>$row->id]);
                            break;
                        case 2: 
                            $row_url = Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$row->id]);
                            break;
                        default: $row_url='';break;
                    }
                    
                    $row_ur_change = Yii::$app->urlManager->createUrl(['survey/step2','id'=>$row->id]); 
                    $image = isset( $row->images->image ) ? UPLOAD_DIR.$row->images->image : DEFAULT_IMAGE;         
                ?>
				<dl>
					<a href="<?php echo $row_url;?>">
						<dt>
							<img src="<?php echo $image;?>"
								alt="<?php echo $row->title;?>">
						</dt>
						<dd>
							<h3><?php echo $row->title;?></h3>
						</dd>
						<dd><?php echo $row->intro;?></dd>
						<dd>
						    <a class="btn_bg" href="<?php echo $row_ur_change;?>">修改</a>
							<span>测试过：<?php echo $row->answer_count;?></span>
						</dd>
					</a>
				</dl>
                <?php } ?>
			</div>
			<div class="load_more">加载更多</div>
			
		</section>
		
      
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
        var url = "<?php echo Yii::$app->urlManager->createUrl(['survey/index-ajax','page'=>'#page#','sort'=>1,'self'=>1]);?>";
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
