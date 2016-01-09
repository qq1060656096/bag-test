<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
use common\z\ZCommonSessionFun;
use yii\widgets\ActiveForm;
use common\models\SurveyResulte;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Survey */
$this->title = '测试预览';
$this->params['breadcrumbs'][] = $this->title;

echo $this->renderFile(__DIR__.'/../layouts/head.php');

?>
<style>
<!--
h1{
	font-size: xx-large;
	text-align: center;
}
#main_body{
	text-align: center;
}
-->


.s_login div,.s_reg div{
	padding:0;
}
.s_reg .btn_bg{
	display: block;
}
.form-group{
	text-align: left;
	font-weight: bold;
}
.s_reg form{
	margin-top: 1em;
}
.po_title{
	text-align: left;
	font-size: 2em;
}
.intro{
	text-align: left;
	color: #999;
	text-indent: 2em;
}

.row{
	border-bottom: 3px dashed #DDD;
	margin-top: 1em;
}    
.label-name{
    display: block;
    text-align: left;
}   
.row textarea ,.row input,.s_reg input[type=text], .s_reg input[type=password], .s_reg textarea{
	width: 99%;
	height: 2em;
	line-height:2em;
	padding: 0;
	margin: 0;
	float: left;
	margin-bottom: 0.5em;
}
.s_reg .btn_bg{
	float: left;
	width: 30%;
	border: none;
	margin-top: 1em;

}
.s_reg .btn_bg:last-child{
}
.s_reg .btn_bg.btn-2{
margin-left: 4.5%;
}
.s_reg .btn_bg.save{

}
.s_reg .btn_bg{
	float: left;
}
.s_reg .btn_bg.btn-r{
	float: right;
}
.s_reg .btn_bg.btn-100{
	width: 100%;
}
#page-content{

}
.rich_media_area_primary {
    position: relative;
    padding: 20px 15px 15px;
    background-color: #fff;
}
.rich_media_title {
    margin-bottom: 10px;
    line-height: 1.4;
    font-weight: 400;
    font-size: 24px;
}
.rich_media_content p {
	    text-align: left;
    font-size: 16px;
}
.rich_media_content * {
    max-width: 100%!important;
    box-sizing: border-box!important;
    -webkit-box-sizing: border-box!important;
    word-wrap: break-word!important;
}
.rich_media_meta_list {
    position: relative;
    z-index: 1;
}
.rich_media_meta_list {
    margin-bottom: 18px;
    line-height: 20px;
    font-size: 0;
}
.rich_media_inner {
    font-size: 16px;
    word-wrap: break-word;
    -webkit-hyphens: auto;
    -ms-hyphens: auto;
    hyphens: auto;
}
.article135{
white-space: normal; color: rgb(62, 62, 62); 
line-height: 25.6000003814697px; font-family: 微软雅黑;	
}
.135editor{
	box-sizing: border-box; border: 0px none; padding: 0px; margin: 0px; 
}
.layout{
	margin: 5px auto; border: 3px solid rgb(255, 129, 36); padding: 5px; box-sizing: border-box;
}
.lighten{
	border: 1px solid rgb(255, 158, 87); padding: 15px; text-align: center; color: inherit; box-sizing: border-box; margin: 0px;
}
.red{
	padding-left: 5px;
	color: red; 
}
.arithmetic-button{

	margin: 0;
	padding: 0 10px;
	height: 50px;
	line-height: 50px;
	border: 3px solid #E46C0A;
	    border-radius: 15px;
	color: #E46C0A;
	font-weight:bold;
	font-size: 25px;
	margin-bottom: 10px;
	background: #fff;
	
}
</style>
<?php 
$test_url = $model->tax==1 ? Yii::$app->urlManager->createUrl(['answer/step1','id'=>$model->id])
: Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$model->id]);
$pre_url    = Yii::$app->urlManager->createUrl(['survey/step4_2','id'=>$model->id]);
switch ($model->tax){
    case 3:
        $pre_url    = Yii::$app->urlManager->createUrl(['survey/step4_4','id'=>$model->id]);
        break;
    case 2:
        $pre_url    = Yii::$app->urlManager->createUrl(['survey/step4_2','id'=>$model->id]);
        break;
    default:
        $pre_url    = Yii::$app->urlManager->createUrl(['survey/step-airthmetic','id'=>$model->id]);
        break;
}


$create_url = Yii::$app->urlManager->createUrl(['survey/step1','id'=>$model->id]);
$update_url = Yii::$app->urlManager->createUrl(['survey/step2','id'=>$model->id]);

// ZCommonFun::print_r_debug($question_all);
// ZCommonFun::print_r_debug($result_all);

isset($question_all['questions'][0]) ? null:$question_all['questions']=[];
isset($question_all['options'][0]) ? null:$question_all['options']=[];
isset($result_all[0]) ? null:$result_all=[];

$replace_prefix = '<b class="replace_word" style="color: blue;">';
$replace_self = false;
$replace_suffix = '</b>';
$replace = true;
?>
<div id="main_body">
	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
	<div id="page-content">
        <div id="img-content" class="rich_media_area_primary">
            <h2 class="rich_media_title" id="activity-name">
                <?php 
                echo ZCommonFun::replace_filter_words($model->title, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
                $error_title = empty($model->title) ? '标题不能为空':'';
                ?> 
                <span class="red"><?php echo $error_title;?></span>
            </h2>                              
            
            <div class="rich_media_content " id="js_content">
                
                <section class="article135" >
                    <section class="135editor" >
                        <section class="layout">
                            <section data-bcless="lighten">
                                <p style="text-align: left;">
                                    <?php   
                                    echo ZCommonFun::replace_filter_words($model->intro, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
                                  
                                    $error_intro = empty($model->intro) ? '简介不能为空':'';
                                    ?> 
                                    <span class="red"><?php echo $error_intro;?></span>
                                </p>
                            </section>
                        </section>
                        <section style="width: 0px; height: 0px; clear: both; box-sizing: border-box; padding: 0px; margin: 0px;">
                        </section>
                    </section>
                    <p><br></p>
                    <?php 
                    $index=0;
                    
                    foreach ($question_all['questions'] as $key=>$question){
                        $index++;
                        $label = $question->label;
                        $replace_count = 0;
                        $label = ZCommonFun::replace_filter_words($label, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
                        $error = !empty($label) ? '' : '问题不能为空';
                    ?>
                    <p>
                        <?php echo $index;?>
                        <span class="question-label"><?php echo $label;?></span>
                        <span class="red"><?php echo $error ;?></span>
                    </p>
                        <?php 
                        isset($question_all['options'][$key]) ? null : $question_all['options'][$key]=[];
                        if(count($question_all['options'][$key])<1){
                        ?>
                        <p>
                            <span class="option_label"></span>
                            <span class="red"><?php echo '问题',$index,'至少包含一个选项';?></span>
                        </p>
                        <?php }?>
                        <?php
                        
                        foreach ($question_all['options'][$key] as $key2=>$question_option){
                            $option_label = $question_option->option_label;
                            $option_label =  ZCommonFun::replace_filter_words($option_label, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
                            $error_option_label = !empty($option_label) ? '':'选项不能为空';
                            $speparator = $question_option->skip_question>0 || $question_option->skip_resulte>0 ? '——' :'';
                            $skip_text = '';
                            
                            $question_option->skip_question>0 ? $skip_text="转{$question_option->skip_question}题":'';
                            $question_option->skip_resulte>0 ? $skip_text="转{$question_option->skip_question}结果":'';
                            $score_text=''; 
                            if($model->tax==2){
                                $score_text='—('.$question_option->option_score.'分)';
                            }
                        ?>
                        <p>
                        
                            <span class="option_label"><?php echo $option_label,$score_text,$speparator,$skip_text;?></span>
                            <span class="red"><?php echo $error_option_label;?></span>
                        </p>
                        <?php }?>
                    <?php }?>
                 
                 </section>
                 <section class="layout">
                    <section data-bcless="lighten">
                        <h2>选择算法</h2>
                        <p style="text-align: left;">
                        <?php 
                        $arr = $model->arithmetic!='' ? explode(',', $model->arithmetic):null;
                        $arr?null:$arr=[];
                        $arithmetic_arr =[];
                        foreach (Survey::$arithmeticList as $key=>$value){
                            $active = '';
                            if(in_array($key, $arr)){
                                $arithmetic_arr[] = $value;
                            }
                         } 
                         echo implode('，', $arithmetic_arr );
                         ?>
                        </p>
                    </section>
                 </section>        
                 <?php 
                 $index=0;
                 foreach ($result_all as $key=>$result){
                     $index++;
                     $name          = $result->name;
                     $name =  ZCommonFun::replace_filter_words($name, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
                     $error_name    = !empty($name) ? '' : '姓名之前不能为空';
                     $value         = $result->value;
                     $value =  ZCommonFun::replace_filter_words($value, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
                     $error_value   = !empty($value) ? '' : '姓名之后不能为空';
                     $intro         = $result->intro;
                     $intro =  ZCommonFun::replace_filter_words($intro, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
                     $error_intro   = !empty($intro) ? '' : '结果详情不能为空';
                     $image         = $result->image;
                     $error_image   = !empty($image) ? '' : '图片不能为空';
                     $image = SurveyResulte::getImageUrl($result);
                     $score_text='';
                     if($model->tax==2){
                         $score_text=''.$result->score_min.'分~~'.$result->score_max.'分';
                     }
                 ?>
                 <section class="layout">
                    <section data-bcless="lighten">
                        <h2><?php echo '结果',$index;?></h2>
                        <p style="text-align: left;">
                            <?php echo $name;?>
                            <span class="red"><?php echo $error_name;?></span>
                        </p>
                        <p style="text-align: left;">
                            <?php echo $value;?>
                            <span class="red"><?php echo $error_value;?></span>
                        </p>
                        <p style="text-align: left;">
                            <?php echo $intro;?>
                            <span class="red"><?php echo $error_intro;?></span>
                        </p>
                        <p style="text-align: left;">
                            <img alt="" src="<?php echo $image;?>">
                            <span class="red"><?php echo $error_image;?></span>
                        </p>
                        <p style="text-align: left;">
                            <?php echo $score_text;?>
                        </p>
                    </section>
                 </section>
                 <?php }?>
                 <?php 
                 if($index<1){
                 ?>
                 <section class="layout">
                    <section data-bcless="lighten">
                        <h2 class="red">最少包含一个测试结果</h2>
                    </section>
                 </section>   
                 <?php } ?>
            </div>
        </div>
    </div>
    <?php $form = ActiveForm::begin()?>
	<section class="s_moreread s_reg s_login">
	   <p>&nbsp;</p>
	   <p>已成功的创建了一个奇趣测试，您已是测试大师</p>
	   <button type="button" class="btn_bg btn btn-primary btn-100" 
	   onclick="javascript:location.href='<?php echo $pre_url;?>';"
	   name="save-next">上一步</button>
	   <button type="button" class="btn_bg btn btn-primary btn-l" 
	   onclick="javascript:location.href='<?php echo $test_url;?>';"
	   name="save-next">我要试用</button>
	   <button type="button" class="btn_bg btn btn-primary btn-2" 
	   onclick="javascript:location.href='<?php echo $create_url;?>';"
	   name="save-next">在创建一个</button>
	   <button type="button" class="btn_bg btn btn-primary btn-r" 
	   onclick="javascript:location.href='<?php echo $update_url;?>';"
	   name="save-next">修改次测试</button>
	   
	   <button type="submit" class="btn_bg btn btn-primary btn-100" 
	  
	   name="save" id="submit">直接发布</button>
	   
    </section>    
    <?php ActiveForm::end(); ?>
</div>  
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	<?php 
	if($message){
	    echo 'alert("',$message,'");';
	}
	?>
	$("#submit").click(function(){
	    var len = $(".replace_word").length;
	    if(len>0){
		    alert("包含"+len+"组敏感词，不能发布");
	        return false;
		}
		var len2 = 0;
		$("span.red").each(function(){
		    var value = $(this).text();
		    if(value){
		    	len2++;
			}
		});
		if( len2 ){
			alert("有"+len2+"必填项未填写，不能发布");
	        return false;
		}
	});
});
</script>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>