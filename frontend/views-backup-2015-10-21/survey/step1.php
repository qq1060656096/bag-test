<?php 
use common\z\ZCommonFun;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);
?>
    <?php 
    foreach ($survey_tax as $id=>$name){
        $url = Yii::$app->urlManager->createUrl(['survey/step2','tax'=>$id]);
    ?>
        <a class="btn btn-primary" href="<?php echo $url;?>"><?php echo $name;?></a>
    <?php }?>