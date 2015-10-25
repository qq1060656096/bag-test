<?php
global $survey_tax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Survey */
/* @var $form yii\widgets\ActiveForm */
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');
$this->title=isset($survey_tax[$tax])? $survey_tax[$tax] : $survey_tax['0'];
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
        <?= $form->field($model_Images, 'image')->hiddenInput(); ?>
        <textarea rows="" cols="" name="upload" id="upload"></textarea>
        <div class="image-editor">
          <input type="file" class="cropit-image-input">
          <div class="cropit-image-preview"></div>
          <div class="image-size-label">
      
          </div>
          <input type="range" class="cropit-image-zoom-input">
          
        </div>
    
        <div class="btn_bg" >
			<input type="submit" id="submit" value="保存"> 
		</div>
		<br />

        <?php ActiveForm::end(); ?>

	</section>
		
      
 </div>
<script>
var change = false;

  $(function() {
    $('.image-editor').cropit({
    	imageState: {
            src: '<?php echo Yii::$app->request->hostInfo.Yii::$app->request->baseUrl.UPLOAD_DIR.$model_Images->image;?>',
          }
    });
    $(".cropit-image-input").change(function(){
//         console.log($(this).val());
    	change = true;
    });
    $('form').submit(function() {
      $(".cropit-image-input").val('');
      var imageData = $('.image-editor').cropit('export');
      if(change){
    	  $("#upload").val(imageData);
      }
      
      
    });
  });
</script> 
<style>
    #upload{
	display: none;
    height: 0;
    	width:0;
    }
      .cropit-image-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 400px;
        height: 400px;
        cursor: move;
      }

      .cropit-image-background {
        opacity: .2;
        cursor: auto;
      }

      .image-size-label {
        margin-top: 10px;
      }

      input {
        display: block;
      }

      .export {
        margin-top: 10px;
      }
    </style>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>  
