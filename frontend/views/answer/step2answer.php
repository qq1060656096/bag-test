<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZController;
use common\models\UserProfile;
/* @var $model common\models\Survey */
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

<meta name="keywords" content="<?php echo $model->title; ?>">
<title>
<?php 
echo empty(ZController::$site_name) ? '':ZController::$site_name.' - ';
echo $this->title,' ',$model->title;

$create_url = Yii::$app->urlManager->createUrl(['survey/step1','id'=>$model->id]);
?>
</title>
<link rel="stylesheet" href="./css/v1.css">
<style type="text/css">
.user-info{
    width: 91.5%;
    margin: 0 auto;	
	background: #f5f5f5;
    border: 2px solid #ddd;
}
.user-info table{
	width: 100%;
	margin: 20px;
}
.red{
	color: red;
}
</style>
</head>
<body>
	<div id="mainbox" class="main">
		<div id="bg1" class="bg1">
			<img id="topimg1" class="topimg imgshow" src="./images/clips1.png">
			<div class="bg2"></div>
			<div id="maintext-title" class="maintext maintext-ready mainactive maintext-play">
				<div id="home-title" class="maintitle"><?php echo $model->title;?></div>
				<div id="home-desc" class="maindesc">
				    <?php 
				    if($image)
				        echo '<img class="image" src= "',$image,'" title="',$model->title,'"/>';
				    echo $model->intro;
				    ?>
				</div>
			</div>
			
			<?php $form = ActiveForm::begin(); ?>
			<!-- question start  -->
			<div  class="maintext maintext-play maintext-play2">
				<div class="maintitle">
				    <?php echo $model->title;?>
				</div>
				<div id="question" class="question">
				    
				    
					<p id="question-text">
					   <?php 
    				    if($image)
    				        echo '<img class="image" src= "',$image,'" title="',$model->title,'"/>';
    				    echo $model->intro;
    				    ?>
					</p>
					<img id="question-pic"
						style="max-width: 100%; max-height: 200px; margin: 0 auto; display: block;"
						src="">
				</div>
				<div  class="btnbox btn-play next-false">
    				<span id="tia" vel="a" num="你的姓名" class="span next-false" >
    				    <input type="text" id="name" name="name" value="" size="15">   
    				</span>
    				
    				<span id="tia" vel="a" num="你的年龄" class="span next-false" >
    				    <input type="text" id="age" name="age" value="" size="15">   
    				</span>
    			</div>
    			<div  class="btnbox btn-ready btnactive btnbox-next">
    				<p >下一题</p>
    			</div>
			</div>
			<!-- question end  -->
			
			
			<?php 
            $question_count = count($data['questions']);
            foreach ($data['questions'] as $key=>$question){
               
            ?>
			<!-- question start  -->
			<div  class="maintext maintext-play row-qestion" style="display: none;">
				<div class="maintitle">
				    <?php echo $model->title;?>
				</div>
				<div id="question" class="question">
					<p id="question-text">
					   当前第<?php echo $key+1;?>/<?php echo $question_count;?>题
					</p>
					<img id="question-pic"
						style="max-width: 100%; max-height: 200px; margin: 0 auto; display: block;"
						src="">
				</div>
				<div  class="btnbox btn-play">
				    <?php 
                    isset($data['options'][$key]) ? null : $data['options'][$key]=[];
                    
                    foreach ($data['options'][$key] as $key2=>$option){
                    ?>
    				<span id="tia" vel="a" num="选项<?php echo $key2+1; ?>：" class="span options <?php echo $question_count==$key+1 ? 'btnbox-submit':'';?>" >
    				    <input type="radio" class="hide"
    				    id="option-id-<?php echo $option->qo_id;?>" 
						res="<?php echo $option->skip_resulte;?>" 
						skip-question="<?php echo $option->skip_question;?>"
						name="options[<?php echo $question->question_id; ?>][]" value="<?php echo $option->qo_id;?>">
						<?php echo $option->option_label;?>  
    				</span>
                    <?php } ?>
    			</div>
    			<?php 
    			/* <div  class="btnbox btn-ready btnactive  <?php echo $question_count==$key+1 ? 'btnbox-submit': 'btnbox-next';?>">
    				<p >下一题</p>
    			</div> */
    			?>
			</div>
			<!-- question end  -->
			
			<?php } ?>
			
			<input type="hidden" name="res" id="res" />
			<?php ActiveForm::end(); ?>
			
			
			<div id="maintext-result" class="maintext maintext-result">
				<div id="result-title" class="resuletitle"></div>
				<div id="result-desc" class="resuledesc"></div>
			</div>

			<!-- btn -->
			<div id="gameready" class="btnbox btn-ready btnactive">
				<p >开始测试</p>
				
				<p onclick="javascript:location.href='<?php echo $create_url;?>';" 
				style="margin-top: 30px;">创建我的测试</p>
			</div>

			

			<div id="gameend" class="btnbox btn-more">
				<p >更多测试</p>
			</div>
		</div>
		
		<div class="user-info">
		    <div style="height: 3.5em;overflow: hidden;">
		  <?php echo $this->renderFile(__DIR__.'/../layouts/share.php'); ?>
		  </div>
		    <div>
		      <table>
		          <tr>
		              <td align="right">
		                  <img src="<?php echo $model_UsersProfile->getHeadImage0();?>" />
		              </td>
		              <td align="left">
		                  
		                  <label>创建测试者：
		                      <b><?php echo $model_UsersProfile->getNickname0();?></b>
		                  </label>
		                  <div class="user-intro">
		                      <?php echo $model_UsersProfile->getIntro0();?>
		                  </div>
		                  <div class="user-test-info">
		                                                  创建了<span class="red"><?php echo isset($model_UsersProfile->test_count) ? $model_UsersProfile->test_count:0;?></span>个测试，
		                                                  被测试过<span class="red"><?php echo $model->answer_count;?></span>次，
		                                                  准确率<span class="red"><?php echo UserProfile::getRate0(); ?></span>。
		                  </div>
		              </td>
		          </tr>
		      </table>
		   </div>
		</div>
		
	</div>
	
    <script type="text/javascript" src="./js/jquery.js"></script>
    <link href="./js/jquery-ui.css" rel="stylesheet" type="text/css"/>  
    <script src="./js/jquery-ui.min.js"></script> 
	<script type="text/javascript">
	$(document).ready(function(){
		$.datepicker.regional["zh-CN"] = { closeText: "关闭", prevText: "&#x3c;上月", nextText: "下月&#x3e;", currentText: "今天", monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"], dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"], dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"], weekHeader: "周", dateFormat: "yy-mm-dd", firstDay: 1, isRTL: !1, showMonthAfterYear: !0, yearSuffix: "年" };
	    //设置默认语言
	    $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);
	    //日期插件
	    $( "#age" ).datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '-60'
		});
		var index = 0; 
		$("#gameready,.btn-play .span,.btnbox-next,.btnbox-submit").click(function(){

			if($(this).hasClass('next-false')){
				return true;
		    }
			//zhao start 屏蔽 name和age元素动画	
			if($(this).hasClass('btnbox-next') ){
    			var name = $('#name');
    			if( name && name.val()=="" ){
    				alert("请输入你的名字");
    			    return true;
    		    }
    			var age = $('#age');
    			if( age && age.val()=="" ){
    				alert("请输入你的年龄");
    			    return true;
    		    }
		    }
			//选择答案
		    $("input[type=radio]",this).attr('checked',true);
		    //直接跳转结果
		    var res = $(this).find('input').attr('res'); 
			//提交
		    if($(this).hasClass('options') &&  res ){
		        $("#res").val(res);
		    	$("form").submit();
			    return true;
			}
		    //提交
		    if($(this).hasClass('btnbox-submit')){
		    	$("form").submit();
			    return true;
			}
			//index当前元素索引 
			//显示元素索引
		    show_index = index+1;
			  //跳到指定的题
		    var skip_question =  $(this).find('input').attr('skip-question');
		    skip_question++;
		    skip_question--;
			  //提交
		    if($(this).closest(".row-qestion").length>0 &&  skip_question>0 ){
		    	
		    	show_index=index+skip_question-1;
// 		    	alert(skip_question+"--"+show_index);
			}
		    
			//zhao end 屏蔽 name和age元素动画	
			$(".maintext-play").eq(index).animate({marginLeft:"-"+$(".maintext-play").eq(index).width()},'slow',function(){
				$(".maintext-play").eq(index).hide();
				$(".maintext-play").eq(show_index).fadeIn('slow');
				$("#gameready").hide();
				index++;
		    });	    
		});	

		$(".btnbox-submit").click(function(){

			var name = $('#name');
			if( name && name.val()=="" ){
				alert("请输入姓名");
			    return true;
		    }
			var age = $('#age');
			if( age && age.val()=="" ){
				alert("请输入年龄");
			    return true;
		    }
		    //$("form").submit();
	   });
		   
    });
		
	</script>
</body>
</html>
