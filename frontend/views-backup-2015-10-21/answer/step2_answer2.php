<?php

/* @var $model common\models\Survey */

?>
<div>
    <h3><?php echo $model->title; ?></h3>
    <img src="" />
    <div class="intro">
        <?php echo $model->intro; ?>
    </div>
    
</div>
<div class="answer">
    <h3><?php echo $model->title; ?></h3>
    <div class="row">
       <div class="question"><?php echo $data['question']->title; ?>：</div>
       <div class="options">
            <?php 
            foreach ($data['options'] as $key=>$option){
            ?>
            <?php } ?>
       </div>  
    </div>
    <div class="now-answer">还有:<span><?php echo $data['count']-$page-1;?></span>道题</div>
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