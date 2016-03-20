<?php

$url_new    = Yii::$app->urlManager->createUrl(['survey/index','sort'=>1]);
$url_hot    = Yii::$app->urlManager->createUrl(['survey/index','sort'=>0]);
$url_find   = Yii::$app->urlManager->createUrl(['survey/step1','sort'=>0]);
$url_me     = Yii::$app->urlManager->createUrl(['survey/my']);
//测试结果页面才有分享
if(in_array(strtolower($this->context->action->id), ['step2-answer2'])){
    echo $this->renderFile(__DIR__.'/../layouts/share.php');
}
?>
    
    <footer>
        <div>
            <nav class="footer-nav">
                <a class="new" href="<?php echo $url_hot;?>">
                    <span class="fa fa-home"><br />首页</span>
                </a>
                <a class="hot" href="<?php echo $url_new;?>">
                    <span class="fa fa-fire"><br />最新</span><br />
                </a>
                <a class="find" href="<?php echo $url_find;?>">
                    <span class="fa fa-edit"><br />创建测试</span>
                </a>
                <a class="me" href="<?php echo $url_me; ?>">
                    <span class="fa fa-user"><br />我的</span>
                </a>
            </nav>
        </div>
    </footer>
  
<link rel="stylesheet" href="./css/Font-Awesome-master/css/font-awesome.min.css">
<style>
.footer-nav .fa{
	display: inline-block;
	vertical-align: middle; 
	font-size: 1.2em;
	    margin-top: 9px;
}
.footer-nav a{
	line-height: normal;
}
.footer-nav .fa:before{
	color: #FE8C78;
} 
</style>