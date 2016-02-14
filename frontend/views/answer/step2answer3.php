<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\z\ZController;
use common\models\UserProfile;
/* @var $model common\models\Survey */
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport"
	content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes">
<meta name="keywords" content="<?php echo ZController::$keywords;?>" />
<meta name="description" content="<?php echo ZController::$description;?>">
<title>
<?php
echo empty(ZController::$site_name) ? '' : ZController::$site_name . ' - ';
echo $this->title, ' ', $model->title;

$create_url = Yii::$app->urlManager->createAbsoluteUrl([
    'survey/step1',
    'id' => $model->id
]);
?>
</title>
<link rel="stylesheet" href="./css/answer2/bootstrap.min.css">
<link rel="stylesheet" href="./css/answer2/style.css">
<link rel="stylesheet" href="./css/answer2/index.css">
<link href="./css/answer2/jquery.mmenu.all.css" rel="stylesheet">
<script src="./css/answer2/hm.js"></script>
<script type="text/javascript" src="./js/jquery.js"></script>
<script src="./css/answer2/bootstrap.min.js"></script>
<script src="./css/answer2/hammer.min.js"></script>
<script src="./css/answer2/jquery.mmenu.min.all.js"></script>
<script type="text/javascript" src="./css/answer2/jweixin-1.0.0.js"></script>
<link href="./js/jquery-ui.css" rel="stylesheet" type="text/css"/>  
<link rel="stylesheet" href="./bag-test/css/common.css">
<script src="./js/jquery-ui.min.js"></script>
<script type="text/javascript">
var sharedata={title:'<?php echo $model->title;?>',img:'<?php echo Yii::$app->request->hostInfo,$image;?>',
		desc: '<?php echo $model->intro;?>',
		url: '<?php echo $create_url;?>',
		successurl:'http://dwz.cn/2kGo8W',
};var wxlink = '<?php echo $create_url;?>';</script>
<script type="text/javascript">wx.config({debug: window.location.href.indexOf("m_dbg=1") > 0 ? true: false,appId: "wx6081e88ae13bda8a",timestamp: "1453757006",nonceStr: 'zyxONtonutlewt3I',signature: '1fa02b44caec1d8812ef02f6db864369bc6544a3',jsApiList: ['checkJsApi','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone']});wx.ready(function() {wx.onMenuShareTimeline({title: document.title,link: wxlink,imgUrl: sharedata.img,success: function () {shareSuccess()},cancel: function () {}});wx.onMenuShareQQ({title: sharedata.title,link: sharedata.url,imgUrl: sharedata.img,success: function () {shareSuccess()},cancel: function () {}});wx.onMenuShareWeibo({title: sharedata.title,link: sharedata.url,imgUrl: sharedata.img,success: function () {shareSuccess()},cancel: function () {}});wx.onMenuShareQZone({title: sharedata.title,link: sharedata.url,imgUrl: sharedata.img,success: function () {shareSuccess()},cancel: function () {}});wx.onMenuShareAppMessage({title: sharedata.title,desc: sharedata.desc,link: sharedata.url,imgUrl: sharedata.img,type: '',dataUrl: '',success: function () {shareSuccess()},cancel: function () {}});}); </script>
<script src="./css/answer2/qc.php" type="text/javascript"
	charset="utf-8"></script>
<script src="http://tajs.qq.com/qc.php?dm=" type="text/javascript"
	charset="utf-8"></script>
</head>
<body>
	<div id="content">
		
		<div class="container newcontent">
			<a id="top"></a>
			<div class="title header-title">
			    <h2><?php echo $model->title;?></h2>
				<div>
					<?php
                    if ($image)
                        echo '<img class="image" style="width:100%;" src= "', $image, '" title="', $model->title, '"/>';
                    ?>
				</div>
				
				<div class="title-sub">
					<div>
						<span class="newmiaoshu">简介:<?php echo $model->intro;?></span>
						<p>
							已有<span><?php echo $model->answer_count;?></span>人参与测试
						</p>
					</div>
				</div>
			</div>
			<!-- E header -->
			<div id="bd" class="panel">
				<div id="panel1" class="panel-body  btn-body">
				
						<div class="buttons">
							<a class="btn btn-lg btn-success start-test" style="width: 100%"
								href="#">开始测试</a>
							<!--<a href="/index.php?g=member&m=index&a=index" class="btn btn-lg btn-success" style="width:100%">登录开始</a>-->
							<div class="share-box">
								
							</div>
						</div>
			
				</div>
				<?php $form = ActiveForm::begin(); ?>
				<div id="panel2" class="panel-body js_answer" style="display: none;">
					
						<a name="result" href="javascript:void(0)"></a>
						<div id="test_content">
							<div class="progre">
								<span class="value"><span class="current">开始测试</span>/<span
									class="question-length">请输入你的姓名和年龄</span></span>
							</div>
							<span><p>
									<br>
								</p> </span>
						</div>
						<ul class="js_group">
							<li class="list-xuan list-xuan-text" style="width: 70%;margin:0 auto;"><input placeholder="你的姓名"
								id="name" name="name" type="text" class="" value=""></li>
							<li class="list-xuan list-xuan-text" style="width: 70%;margin:0 auto;">
							     生日<select id="age" name="age birth_year" class="" onchange="adjustAstro();"></select>
							     <select id="birth_month" name="birth[month]" onchange="adjustAstro();"></select>
							     <select id="birth_day" name="birth[day]" onchange="adjustAstro();"></select>
							 
							</li>
							
							<li class="list-xuan list-xuan-text" style="width: 70%;margin:0 auto;">
							 <SELECT id=astro disabled name=astro runat="server" style="width: 100%;border:none;-webkit-appearance: none;"> 
                                <OPTION selected>处女座</OPTION>
                            </SELECT>
							</li>
						</ul>
						<input type="hidden" id="birth_year" name="birth[year]" value=""/>
						<a class="btn btn-lg btn-success submit-test" style="width: 100%"
								>答题</a>
					<!-- question end  -->
        			
				
				</div>
				
				
				<?php 
                $question_count = count($data['questions']);
                foreach ($data['questions'] as $key=>$question){    
                        
                ?>
                <!-- question start  -->
				<div id="panel3" class="panel-body js_answer question-row" style="display: none;">
						<a name="result" href="javascript:void(0)"></a>
						<div id="test_content">
							<div class="progre">
								<span class="value"><span class="current"><?php echo $key+1;?></span>/<span
									class="question-length"><?php echo $question_count;?></span></span>
							</div>
							<span><p class="p1">
									<strong><?php echo $question->label;?></strong>
								</p>
								
						</div>
						<ul class="js_group">
						    <?php 
                            isset($data['options'][$key]) ? null : $data['options'][$key]=[];
                            $option_index = 1;
                            foreach ($data['options'][$key] as $key2=>$option){
                                empty($option->option_label) ? $option->option_label = $option_index : null;
                                $option_index++;
                            ?>
							<li class="list-xuan">
							     <input  type="radio"  id="option-id-<?php echo $option->qo_id;?>" 
        						          res="<?php echo $option->skip_resulte;?>" 
        						          skip-question="<?php echo $option->skip_question;?>"
        						          name="options[<?php echo $question->question_id; ?>][]" value="<?php echo $option->qo_id;?>"
							 ><?php echo $option->option_label;?>
							</li>
						    <?php } ?>
						</ul>
				</div>
				<!-- question end  -->
				<?php } ?>
				<input type="hidden" name="res" id="res" />
				<?php ActiveForm::end(); ?>
				
			</div>
			<!-- E bd -->
		</div>
		<!-- E container -->

	</div>
	<script>function closeADFunc() {
document.getElementById('hideADbtn').style.display='none';
document.getElementById('spn').style.display='none';
}
</script>
<script type="text/javascript" src="js/date-select.js"></script>		
<script>
birthday = false;
$(document).ready(function(){
	$.datepicker.regional["zh-CN"] = { closeText: "关闭", prevText: "&#x3c;上月", nextText: "下月&#x3e;", currentText: "今天", monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"], dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"], dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"], weekHeader: "周", dateFormat: "yy-mm-dd", firstDay: 1, isRTL: !1, showMonthAfterYear: !0, yearSuffix: "年" };
    //设置默认语言
//     $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);
//     //日期插件
//     $( "#age" ).datepicker({
//     	changeMonth: true,
//     	changeYear: true,
//     	yearRange: '-60'
// 	});
    $(".btn.btn-lg.start-test").click(function(){
    	$("#panel1").hide();
        $("#panel2").show();
        return false;
    });
    $('#age').change(function(){
    	birthday = true;
        $("#birth_year").val($(this).val());
    });
    $(".submit-test").click(function(){
    	var name = $('#name');
		if( name && name.val()=="" ){
			alert("请输入姓名");
		    return true;
	    }
		var age = $('#age');
		if( age && age.val()=="" || !birthday ){
			alert("请选择生日");
		    return true;
	    }
		$("#panel2").hide();
        $("#panel3").show();
    });

    var index = 0; 
    $(".question-row .list-xuan").click(function(){
    	$(this).closest(".question-row").find("input[type=radio]").attr('checked',false);
    	//选择答案
	    $("input[type=radio]",this).attr('checked',true); 
	    console.log($("input[type=radio]",this).attr('checked'));
	    //直接跳转结果
	    var res = $(this).find('input').attr('res'); 
		  //提交
	    if($(this).hasClass('options') &&  res ){
	        $("#res").val(res);
	    	$("form").submit();
		    return true;
		}
		  //index当前元素索引 
		//显示元素索引
	    show_index = index+1;
		  //跳到指定的题
	    var skip_question =  $(this).find('input').attr('skip-question');
	    skip_question++;
	    skip_question--;
	    var question_row_len = $(".question-row").length;
	    console.log('show_index=',show_index,'--',question_row_len);
		  //提交
	    if(question_row_len>0 &&  skip_question>0){
	    	
	    	show_index=index+skip_question-1;
//		    	alert(skip_question+"--"+show_index);
		}
		//最后一题
		if(question_row_len<=show_index){
// 			alert("已经是最后一题");
			$("#birth_year").val($(this).val());
			$("form").submit();
		    return true;
	    }
		  //zhao end 屏蔽 name和age元素动画	
		$(".question-row").eq(index).animate({"opacity":"0"},'slow',function(){
			$(".question-row").eq(index).hide();
			$(".question-row").eq(show_index).fadeIn('slow');
			index++;
	    });	
    });

    
});
</script>
	<div class="container">
		<div id="more">
			<h3 class="bold text-muted">
				随便测测：<a class="pull-right text-muted more_link"
					onclick="return toggleMore();"><i
					class="glyphicon glyphicon-refresh"></i> &nbsp;换一批</a>
			</h3>
			<section class="s_moreread">
				<div class="list_box">
				    <?php 
        		   foreach ($randSurvey as $key=>$row){
        		       $key_index = $key+1;
        		       if($row->tax==1){
        		           $url = Yii::$app->urlManager->createUrl(['answer/step1','id'=>$row->id]);
        		       }else{
        		           $url = Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$row->id]);
        		       }
        		       $image = isset( $row->images->image ) ? UPLOAD_DIR.$row->images->image : DEFAULT_IMAGE;
        		   ?>
					<div class="list-a">
						<a
							href="<?php echo $url;?>"><div
								class="img">
								<img src="<?php echo $image;?>">
							</div> <span class="title"><h3><?php echo $row->title;?></h3></span></a>
					</div>
					<?php }?>
					
				</div>
			</section>
		</div>
	</div>
	<!-- suiji -->
	<style>
.layer {
	background: rgba(0, 0, 0, .6);
	-pie-background: rgba(0, 0, 0, .6);
	behavior: url(/css3pie/PIE.htc);
	position: fixed;
	top: 0;
	left: 0;
	bottom: 0;
	display: none;
	right: 0;
	margin: 0;
	z-index: 100;
	-webkit-tap-highlight-color: transparent;
}

.center-align-outer {
	display: table;
	position: absolute;
	height: 100%;
	width: 100%;
}

.center-align-outer .center-align-middle, .vertical-middle {
	display: table-cell;
	vertical-align: middle;
}

.center-align-outer .center-align-middle .center-align-inner,
	.horizontal-center {
	margin-left: auto;
	margin-right: auto;
	text-align: center;
}

.center-layer-inner {
	display: inline-block;
}

.share-dialog-outer {
	margin: 16px;
}

.white-dialog {
	background: #fff;
	border: 1px solid #d0d0d0;
}

.share-dialog-outer .white-dialog .title {
	font-size: 20px;
	border: none;
	padding: 15px;
}

.white-dialog .title {
	position: relative;
	padding: 10px;
	text-align: center;
	font-size: 16px;
	font-weight: 700;
	border-bottom: solid 1px #d0d0d0;
}

.white-dialog .close {
	position: absolute;
	right: 0;
	top: 0;
	padding: 7px;
	background: 0 0;
}

.white-dialog .body {
	background: 0 0;
	min-width: 270px;
}

.layer .l2 {
	padding: 0 15px 15px;
	display: none;
}

.layer .qr-img {
	width: 100%;
	padding: 10px;
}

.layer .l2 span {
	width: 100%;
	color: #b0b0b0;
	font-size: 14px;
	display: inline-block;
	line-height: 17px;
	height: 34px;
}

.layer .l2 .return {
	color: red;
	font-size: 18px;
}

.layer .l2 input {
	width: 100%;
	height: 38px;
	font-size: 15px;
	text-align: center;
	line-height: 15px;
	border: 3px solid #dc6082;
}

#share-arrow {
	position: absolute;
	max-width: 250px;
	right: 20px;
	top: 10px;
}

#share-tip {
	color: red;
	position: absolute;
	left: 20px;
	right: 20px;
	text-align: center;
	top: 260px;
	font-family: "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial,
		sans-serif;
	font-size: 22px;
	line-height: 1.5;
	font-weight: bold;
}

.share-in-app {
	width: 100%;
	height: 100%;
	display: none;
}

.share-dialog-outer .white-dialog .share-items {
	padding: 0 15px 15px;
}

.share-dialog-outer .white-dialog .share-item {
	float: left;
	width: 33.333%;
	min-width: 60px;
}

.share-dialog-outer .white-dialog .share-item .share-item-button {
	background: 0 0;
	width: 100%;
	padding-top: 5px;
	border: none;
}

.share-dialog-outer .white-dialog .share-item .share-item-button .icon {
	width: 45px;
	height: 45px;
	margin: 0 auto 5px;
	border-radius: 50%;
	overflow: hidden;
}

.share-dialog-outer .white-dialog .share-item .share-item-button .text {
	display: block;
	width: 100%;
	color: #b0b0b0;
	font-size: 14px;
	line-height: 17px;
	height: 34px;
}

a:not (.flat ):after, button:not (.flat ):after {
	content: '\A';
	position: absolute;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	background: rgba(0, 0, 0, .05);
	visibility: hidden;
	pointer-events: none;
}

.footer {
	margin-bottom: 51px;
}

.footer_tj {
	position: fixed;
	width: 100%;
	left: 0px;
	display: none;
	bottom: 0px;
	background: #21ADE2;
}

.footer_tj span {
	float: left;
	max-height: 50px;
}

.footer_tj .tj_img {
	height: 50px;
}

.footer_tj img {
	height: 50px;
}

.footer_tj .tj_title {
	line-height: 24px;
	font-size: 18px;
	display: none;
	padding-left: 10px;
	width: 80%;
	color: #fff;
}

.footer_tj .close_ad {
	position: absolute;
	right: 4px;
	top: 5px;
	background: #FD7909;
	font-size: 13px;
	padding: 5px;
	color: white;
}

#myModal button.close span {
	color: #fff !important;
	font-size: 30px;
}
</style>
	<div class="footer">
		<div class="container">
			<ul>
				<li>联系人 : dashensuan@qq.com</li>
			</ul>
			<div class="disclaimer">
				<span>友情提示：本网站所有内容以娱乐性为目的</span>
			</div>
			<div class="disclaimer">
				<span>京ICP备09042499号-10&nbsp;&nbsp;<span><a href="http://dashensuan.com" >dashensuan.com</a></span></span>
			</div>
			<div class="copyright"></div>
		</div>
	</div>
	<div class="modal modal2 fade in" id="myModal" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel"
		style="padding-top: 20px; display: none; background: rgba(0, 0, 0, 0.6);"
		aria-hidden="false">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div
					style="background-image: none !important; background: #FF566A; padding: 5px; border-radius: 5px 5px 0 0; color: #fff;">
					<button type="button" class="close close_fenxiang"
						data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="text-center" id="myModalLabel"
						style="font-size: 32px; font-weight: bold; text-shadow: 0px 2px 2px rgba(0, 0, 0, 0.50);">感谢分享</h4>
				</div>
				<div class="modal-body text-center">
					<div class="member_in">
						<span style="font-size: 14px; color: #4A4A4A; font-weight: bold;">改变，从这里开始——发现未知的自己。</span><span
							class="text-center"><img style="width: 100%"
							src="./css/answer2/erweima.jpg"></span>长按 识别图中二维码 进入
					</div>
				</div>
				<div
					style="background-image: none !important; background: #FF566A; padding: 5px; border-radius: 0 0 5px 5px; color: #fff;"></div>
			</div>
		</div>
	</div>
	<?php 
    echo $this->renderFile(__DIR__ . '/../layouts/foot-menu.php');
    ?>
</body>
</html>