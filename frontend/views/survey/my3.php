<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
use common\z\ZCommonSessionFun;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $row common\models\Survey */
$this->title = '我创建的测试';
$login_user_showNickname = User::getUidShowName(ZCommonSessionFun::get_user_id());
$this->title = $login_user_showNickname.'的个人主页';
$this->params['breadcrumbs'][] = $this->title;

echo $this->renderFile(__DIR__.'/../layouts/head.php');

?>
<style>
.btn_bg{
	float: left;
}
.btn_bg.ajax-publish{
	float: right;
}
</style>
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
                        case 3:
                            $row_url = Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$row->id]);
                            break;
                        default: $row_url='';break;
                    }
                    $row_ur_done   = Yii::$app->urlManager->createUrl(['survey/done','id'=>$row->id]);
                    //发布
                    $row_ur_done_publish   = Yii::$app->urlManager->createUrl(['survey/done','is_ajax'=>1,'id'=>$row->id]);
                    $row_ur_not_publish   = Yii::$app->urlManager->createUrl(['survey/is-not-publish','id'=>$row->id]);
                    $row_ur_change = Yii::$app->urlManager->createUrl(['survey/step2','id'=>$row->id]);
                    $image = common\models\Survey::getImageUrl($row);
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
						<dd>
						  <a class="btn_bg" href="<?php echo $row_ur_done;?>">预览/修改</a>


					      &nbsp; &nbsp;
					      <span>测试过：<?php echo $row->answer_count;?></span>
					      <?php
					      if( $row->is_publish ==1 ):
					      ?>

					      <a class="btn_bg ajax-publish is_not" href="<?php echo $row_ur_not_publish;?>" pk_id="<?php echo $row->id;?>">取消发布</a>
					      <?php
					      else:
					      ?>
					      <a class="btn_bg ajax-publish" href="<?php echo $row_ur_done_publish;?>"  pk_id="<?php echo $row->id;?>">发布</a>
					      <?php endif;?>

						  <?php //echo $row->intro;?>
						</dd>
						<dd>


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
$(document).ready(function(){
	$(".list_box").on('click',".ajax-publish",function(){

		var element = $(this);
		var url = element.attr('href');
		if(element.text()=="取消发布" ){
			element.text('取消发布中...');
		}else{
			element.text('发布中...');
		}

// 		alert(url);
// 		$.post(url,{save:1},function(json){
// 			element.text('发布');
// 			alert(json.message);
// 		    console.log(json);
// 		});
		//发布

		$.ajax({
			type:"POST",
			dataType:"json",
			data:{"save":1},
			url: url+"",
			success:function(json) {
				var row_ur_done_publish   = "<?php echo Yii::$app->urlManager->createUrl(['survey/done','is_ajax'=>1,'id'=>'#id#']);?>";
				row_ur_done_publish = row_ur_done_publish.replace('%23id%23',element.attr('pk_id'));

		        var row_ur_not_publish   = "<?php echo Yii::$app->urlManager->createUrl(['survey/is-not-publish','id'=>'#id#']);?>";
		        row_ur_not_publish = row_ur_not_publish.replace('%23id%23',element.attr('pk_id'));
				if(json.status==0){
					if(element.text()=="取消发布中..."){
						element.text('发布');
						element.attr('href',row_ur_done_publish);
					}else{
						element.text('取消发布');
						element.attr('href',row_ur_not_publish);
					}

				}else{
					if(element.text()=="取消发布中..."){
						element.text('发布');
					}else{
						element.text('已发布');
					}
				 }

				alert(json.message);
			}
		});

		return false;
   });
});

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
            $.getJSON(url,function(html){
            	now.text('加载更多');
            	isAjaxLoad = false;
                console.log(html);
                //没有找到
                if(html.data==''){
                	isAjaxLoad = true;
                	now.text('已经没有了');
                	console.log('已经没有了');
                }
                $(".list_box").append( html.data );
            });
        }
    });
}
</script>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>
