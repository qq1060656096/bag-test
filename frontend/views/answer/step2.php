<?php

/* @var $model common\models\Survey */

?>
<div>
    <h3><?php echo $model->title; ?></h3>
    <img src="" />
    <div class="intro">
        <?php echo $model->intro; ?>
    </div>
    <div>
            通过 <?php echo $count;?> 道题进行科学分析，预计需要 1 分钟。
    </div>
    <a class="start" href="<?php echo Yii::$app->urlManager->createUrl(['answer/step2-answer','id'=>$model->id,'page'=>0]);?>">开始测试</a>
    
    <div class="row">
        <div>已测试人数:<span><?php echo $model->answer_count;?></span></div>
        <div>测试准去率:<span>98.3%</span></div>
    </div>
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
    </style>