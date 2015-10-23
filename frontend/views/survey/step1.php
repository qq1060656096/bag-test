<?php 
use common\z\ZCommonFun;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');
$this->title="创建测试";
?>
<style>
.s_login div,.s_reg div{
	padding:0;
}
.s_reg .btn_bg{
	display: block;
}
</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js1"></script>
<div id="main_body">
    
	
	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>
	
	<section class="s_moreread s_reg s_login">
		<?php echo $this->renderFile(__DIR__.'/../layouts/header-user.php');?>
			
        <?php 
        foreach ($survey_tax as $id=>$name){
            $url = Yii::$app->urlManager->createUrl(['survey/step2','tax'=>$id]);
        ?>
    
            <a class="btn_bg" href="<?php echo $url;?>">
    			<input type="submit" id="submit" value="<?php echo $name;?>"> 
    		</a>
    		<br />
        <?php }?>

	</section>
		
      
 </div>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>    