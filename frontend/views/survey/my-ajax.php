<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
use common\z\ZCommonSessionFun;
use common\models\User;
use common\z\ZController;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $row common\models\Survey */
$this->title = '我创建的测试';
$login_user_showNickname = User::getUidShowName(ZCommonSessionFun::get_user_id());
$this->title = $login_user_showNickname . '的个人主页';
$this->params['breadcrumbs'][] = $this->title;

?>
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

                    $title_right_text = $row->is_publish ==1 ? '已发布': '草稿';
                ?>
				<dl>
					<a href="<?php echo $row_url;?>">
						<dt>
							<img src="<?php echo $image;?>"
								alt="<?php echo $row->title;?>">
						</dt>
						<dd>
							<h3><?php echo $row->title;?>&nbsp;
							     <a class="title-right-text" href="#"><?php echo $title_right_text;?></a>
							</h3>
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
