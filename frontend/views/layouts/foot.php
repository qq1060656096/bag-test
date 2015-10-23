
    <?php 
    $url_new    = Yii::$app->urlManager->createUrl(['survey/index','sort'=>1]);
    $url_hot    = Yii::$app->urlManager->createUrl(['survey/index','sort'=>0]);
    $url_find   = '';
    $url_me     = Yii::$app->urlManager->createUrl(['survey/my']);
    ?>
    <footer>
        <div>
            <nav class="footer-nav">
                <a class="new" href="<?php echo $url_new;?>">
                    <span class="fa fa-home"><br />最新</span>
                </a>
                <a class="hot" href="<?php echo $url_hot;?>">
                    <span class="fa fa-fire"><br />最热</span><br />
                </a>
                <a class="find">
                    <span class="fa fa-search"><br />发现</span>
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
}
.footer-nav .fa:before{
	color: #FE8C78;
} 
</style>
</body>
</html>