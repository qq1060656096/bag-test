<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $model common\models\Survey */

?>
<div>
    <h3><?php echo $model->title; ?></h3>
    <img src="" />
    <div class="intro">
        <?php echo $model->intro; ?>
    </div>
    <?php if( isset($result) ){?>
    <div class="result">
        <span>经过对你的名字笔画进行分析，系统认为</span>
        <span>
        <?php echo $result->name;?>
        <span class="text-red"><?php echo $posts['name'];?></span>
        <?php echo $result->value;?>
        <span class="text-red"><?php echo $result->intro;?></span>
        </span>
    </div>
    <?php } ?>
</div>
<div class="answer">
    <h3><?php echo $model->title; ?></h3>
    <div>
        <?php $form = ActiveForm::begin(); ?>
        <span>姓名<input type="text" name="name"/></span>
        
        <div id="examples">
            <div class="picker" id="picker3"></div>       
        </div>
        <?php echo Html::submitButton('马上测一测', ['class' => 'start']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="row">
        <div>已测试人数:<span><?php echo $model->answer_count;?></span></div>
        <div>测试准去率:<span>98.3%</span></div>
    </div>
    <div class="now-answer">还有:<span><?php echo $data['question_total_count'];?></span>道题</div>
</div>
<script type="text/javascript">

</script>
<script type="text/javascript" src="./common/js/birthdaypicker-master/bday-picker.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
        
        $("#picker3").birthdaypicker({
          dateFormat: "bigEndian",
          monthFormat: "long",
          placeholder: false,
          hiddenDate: false
        });
        
      });
    </script>
    <style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; }
      h1 { margin: 0; padding-top: 20px; }
      fieldset { padding: none; border: none; }
      #container { height: 100%; width: 600px; margin: 0 auto; padding: 0 50px; background: #eee; }
      .text-red{color: red;}
    </style>