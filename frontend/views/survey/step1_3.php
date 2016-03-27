<?php
global $survey_tax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Survey;
use frontend\controllers\SurveyController;

/* @var $this yii\web\View */
/* @var $model common\models\Survey */
/* @var $form yii\widgets\ActiveForm */
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');
$this->title=isset($survey_tax[$tax])? $survey_tax[$tax] : '';
$this->title= empty($this->title) && isset($survey_tax[$model->tax]) ? $survey_tax[$model->tax] : $this->title;
$this->title .= '-步骤2/'.SurveyController::stepCount($tax);

$this->title .='.封面图';

?>
<style>
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
</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="./common/js/cropit-master/dist/jquery.cropit.js"></script>
<div id="main_body">
    
	
	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
	
	<section class="s_moreread s_reg s_login">

    <?php $form = ActiveForm::begin(['id'=>'form1']); ?>
        <h1 class="po_title common-color"><?php echo $model->title;?></h1>
        <p class="intro"><?php echo $model->intro;?></p>
        <div class="form-group field-images-image">
            <label class="control-label upload-click" for="images-image">上传封面图
                <div id="BlockCon" class="">
                    <i class="QaddImg " >
                        
                    </i>
                </div>
            </label>
            <input id="upload" type="file" name="file">
            <input type="hidden" id="images-image" class="form-control " name="image" value="<?php echo isset($model->images->image)?$model->images->image: '';?>">
            
            <div class="help-block"></div>
        </div>
        
        <div class="btn_bg btn-2 btn-100">
			<a href="<?php echo Yii::$app->urlManager->createUrl(['survey/step2','id'=>$model->id]);?>" id="prev-step">上一步</a> 
		</div>
		<br/>
        <?php 
            $submitText = '';
            switch ($model->tax):
                case 1:
                    $submitText = '保存/下一步';//'保存/下一步添加结果';
                    break;
                case 2:
                    
                case 3:
                    $submitText = '保存/下一步';//'保存/下一步添加题目';
                    break;
            endswitch;
       ?>
        <div class="btn_bg" >
			<input type="submit" id="submit" value="<?php echo $submitText;?>"> 
		</div>
		<br />
		<?php /*
		<a class="btn_bg" 
		href="<?php echo Yii::$app->urlManager->createUrl(['survey/step2','id'=>$model->id]);?>" 
		id="prev-step">上一步</a> 
		<br />
		
		<a class="btn_bg" href="<?php echo Yii::$app->urlManager->createUrl(['survey/done','id'=>$model->id]);?>">
	       <input type="button" value="预览"> 
	    </a> 
        <br />
        */
        ?>
        
        <div id="image-wrap">
            <?php 
                if(isset($model->images->image) && !empty($model->images->image)){
                    echo '<img src="',Survey::getImageUrl($model),'"/>';
                }
            ?>
        </div>
        
		

        <?php ActiveForm::end(); ?>
        <p class="text-hint">保存配图后，在下一步，你需要依次创建不少于<?php echo SurveyController::stepCount($tax)-2;?>个测试结果。后面还有3个步骤，这个测试就能创建完毕。</p>
	</section>
		
      
 </div>
<script src="common/php-html5-uploadz/ZHtml5Upload.js">
</script>
<script>
var change = false;

$(function() {

    $('form').submit(function() {
        /* if($("#images-image").val()==""){
            alert("请先上传图片");
            return false;
        } */
    	$("#upload").val("");
    });
    $(".upload-click").click(function(){
        $("#upload").click();
    });

    $("#upload").ZHtml5Upload({
		uploadSucess: function(result,uploadz){
			var json = $.parseJSON(result);
			//console.log( json );
			if( json.result.status==1 && json.id){
				$("#images-image").val(json.id);
		    }
			
			//console.log(this);
			if( uploadz.isReaderFile ){
				$("#image-wrap").empty();
				$("#image-wrap").append('<img src="<?php echo Yii::$app->request->baseUrl,UPLOAD_DIR;?>'+json.id+'" />');
			}
			console.log( uploadz.base64Data );
		},
		uploadError: function(result){
			console.log( result);
		}
	});
});
</script> 
<style>
#BlockCon{
    position: relative;
	width: 75px;
	height: 45px;
	display: inline-block;

}
.field-images-image label{
	font-size: 2em;
	line-height: 45px;
	color: #2E8EC1;
}
.field-images-image{
	text-align: center;
	margin-bottom: 10px;
}
#BlockCon input{
	display: none;
}
.QaddImg {
    position: absolute;
    right: 10px;
    top: 11px;
    width: 60px;
    height: 55px;
    margin: 0 auto;
    overflow: hidden;
    background-position: 0 0;
    background-repeat: no-repeat;
    background-size: contain;
    background-image: url('./images/camera.png');
}
    #upload{
	display: none;
    height: 0;
    	width:0;
    }
    

      .image-size-label {
        margin-top: 10px;
      }

      input {
        display: block;
      }

.upload-click{
	cursor: pointer;
}
    </style>
     <?php echo $this->renderFile(__DIR__.'/../layouts/group-add.php');?>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>  
