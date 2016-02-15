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
.btn-up{
	border-radius: 5px 5px 0px 0px !important;
	border: 1px solid #FE8C78;
	line-height: 36px;
}
.btn-down{
	border-radius:  0px 0px 5px 5px !important;
	background: none !important;
    color: #999 !important;
    border: 1px solid #FE8C78;
    border-top: none;
	line-height: 36px;
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
//             if($id>=3){
//                 break;
//             }
            switch ($id):
            case 1: 
                $note = '无需做题，通过算法，直接得出测试结果。';
                break;
            case 2:
                $note = '做选择题，通过分数，的粗测试结果。';
                break;
            case 3: 
                $note = '做选择题，通过跳转到题目和结果，得出测试结果。';
                break;
            endswitch;
        ?>
    
            <a class="btn_bg btn-up" href="<?php echo $url;?>">
    			<input type="submit" id="submit" value="<?php echo $name;?>"> 
    		</a>
    		<a class="btn_bg btn-down" href="<?php echo $url;?>">
    		  <?php echo $note;?>
    		</a>
    		<br />
        <?php }?>

	</section>
		
      
 </div>
 <?php echo $this->renderFile(__DIR__.'/../layouts/group-add.php');?>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>    