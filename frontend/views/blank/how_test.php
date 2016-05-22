<?php
use common\z\ZCommonFun;
global $survey_tax;
// ZCommonFun::print_r_debug($survey_tax);
echo $this->renderFile(__DIR__.'/../layouts/head-login.php');
$this->title="";
$step_arr = [];
switch ($tax):
case 1:
    $this->title = '如何创建无题测试';
    $step_arr = [
        [
            'title'=>'步骤1.标题简介 ',
            'prompt'=>'为你的测试取一个名字，并简单介绍一下',
        ],
        [
        'title'=>'步骤2.封面图 ',
        'prompt'=>'为你的测试上传一张图片，作为封面',
        ],
        [
        'title'=>'步骤3.添加测试结果 ',
        'prompt'=>'添加测试结果，作为大家做测试后得出的结果',
        ],
        [
        'title'=>'步骤4.选择算法',
        'prompt'=>'大神蒜将根据你选择的算法，为大家算出结果',
        ],
        [
        'title'=>'步骤5.预览 ',
        'prompt'=>'看一下你添加的全部内容，发布出去让大家来测',
        ],
    ];
    break;
case 2:
    $this->title = '如何创建分数型测试';
    $step_arr = [
        [
            'title'=>'步骤1.标题简介 ',
            'prompt'=>'为你的测试取一个名字，并简单介绍一下',
        ],
        [
            'title'=>'步骤2.封面图 ',
            'prompt'=>'为你的测试上传一张图片，作为封面',
        ],
        [
            'title'=>'步骤3.添加测试题目 ',
            'prompt'=>'添加选择题，包括题目和选项，为选项设定分数',
        ],
        [
        'title'=>'步骤4.预览分数区间 ',
        'prompt'=>'为结果设定分数区间，大家根据得分得出结果',
        ],
        [
            'title'=>'步骤5.添加测试结果 ',
            'prompt'=>'添加测试结果，作为大家做测试后得出的结果',
        ],

        [
            'title'=>'步骤6.预览 ',
            'prompt'=>'看一下你添加的全部内容，发布出去让大家来测',
        ],
    ];
    break;
case 3:
    $this->title = '如何创建跳转型测试';
    $step_arr = [
        [
            'title'=>'步骤1.标题简介 ',
            'prompt'=>'为你的测试取一个名字，并简单介绍一下',
        ],
        [
            'title'=>'步骤2.封面图 ',
            'prompt'=>'为你的测试上传一张图片，作为封面',
        ],
        [
            'title'=>'步骤3.添加测试题目',
            'prompt'=>'添加选择题，包括题目和选项',
        ],
        [
            'title'=>'步骤4.添加测试结果',
            'prompt'=>'添加测试结果，作为大家做测试后得出的结果',
        ],
        [
            'title'=>'步骤5.设置跳转',
            'prompt'=>'将选项设置为跳转到后面的题目或测试结果',
        ],
        [
            'title'=>'步骤6.预览 ',
            'prompt'=>'看一下你添加的全部内容，发布出去让大家来测',
        ],
    ];
    break;
endswitch;;

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
.btn_bg, .s_reg .btn_bg, .s_reg a.btn_bg, .btn_bg input, .btn-z-change, .btn-z-bind {
    font-size: 14px !important;
    font-weight: 100 !important;
}
</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js1"></script>
<div id="main_body">


	<?php echo $this->renderFile(__DIR__.'/../layouts/head-top.php');?>

	<section class="s_moreread s_reg s_login" style="margin-top:50px;">
		<?php //echo $this->renderFile(__DIR__.'/../layouts/header-user.php');?>

        <div class="btn_bg btn-2" style="padding:0;width: 120px;">
            	<a style="" href="<?php echo Yii::$app->urlManager->createUrl(['survey/step2','tax'=>$tax]);?>" id="prev-step">开始创建</a>
		</div>
		<br/>
        <?php
        foreach ($step_arr as $id=>$row){
//             $url = Yii::$app->urlManager->createUrl(['survey/step2','tax'=>$id]);

        ?>

            <a class="btn_bg btn-up" href="javascript:void(0);">
    			<input type="submit" id="submit" value="<?php echo $row['title'];?>">
    		</a>
    		<a class="btn_bg btn-down" href="javascript:void(0);">
    		  <?php echo $row['prompt'];?>
    		</a>
    		<br />
        <?php }?>

	</section>


 </div>
 <?php echo $this->renderFile(__DIR__.'/../layouts/group-add.php');?>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>