<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $row common\models\Survey */

$this->params['breadcrumbs'][] = $this->title;

echo $this->renderFile(__DIR__ . '/../layouts/head.php');

?>

<link href="http://www.weceshi.com/favicon.ico" type="image/x-icon"
	rel="shortcut icon">
<link href="./css/index/mui.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css"
	href="./css/index/swiper.min.css">
<link rel="stylesheet" type="text/css"
	href="./css/index/app.min.css">
<meta property="wb:webmaster" content="c41cd18eb37d09a1">
<script src="./css/index/zepto.min.js"></script>
<script src="./css/index/swiper.min.js"
	type="text/javascript" charset="utf-8"></script>
<div class="mui-inner-wrap">
<style>
.diy-tab-item{
	width: 33.3%;
}
.mui-bar-nav~.mui-content{
	position: relative;
}
section#all-game {
    padding-bottom: 100px;
}
.refresh-tip{
	position: absolute;
	left : 0;
	bottom: 50px;
}
.footer-nav{
	z-index: 9999;
}
</style>
	<!-- 主页面标题 -->
	<header class="mui-bar mui-bar-nav">
		<div class="game-fl diy-nav-bar ">
			<a class="diy-control-item mui-active"
				href="http://www.weceshi.com/index.php?s=/wetest/index/index">首页</a>
			<a class="diy-control-item"
				href="http://www.weceshi.com/index.php?s=/wetest/index/category">分类</a>
			<a class="diy-control-item"
				href="http://www.weceshi.com/index.php?s=/wetest/index/played">我测的</a>
		</div>
		<a href="http://www.weceshi.com/index.php?s=/wetest/index/usercenter"
			title="用户中心" class="nav-user"> <i
			class="mui-icon iconfont icon-contact"> <span class="user-nologin"></span>
		</i>
		</a>
	</header>

	<div class="mui-content">
		<section class="diy-content-space-small"></section>
		<!--search form-->
		<section class="container search diy-content-space-small">
			<form
				action="http://www.weceshi.com/index.php?s=/wetest/index/search/q/"
				class="form" method="post" data-ui="static" id="search-form">
				<div data-role="input">
					<input placeholder="大家都在搜：史上最坑手机测试" type="text" autocomplete="off"
						autocorrect="off" maxlength="64" name="q" id="search"> <i
						class="iconfont icon-search"></i> <i class="iconfont icon-close"></i>
				</div>
				<button class="ui-btn" data-ui="danger small" type="button"
					id="search-btn">搜索</button>
			</form>
		</section>
		<!--slider-->
		<!-- end slider -->
		<section class="main-content" id="hash-rcmd">
			<h5 class="diy-content-padded">
				精品测试 <a class="diy-more"
					href="http://www.weceshi.com/index.php?s=/wetest/index/gettestgame/limit/0">
					更多<i class="iconfont icon-right"></i>
				</a>
			</h5>
			<ul class="mui-table-view mui-grid-view mui-grid-9">
				<li class="mui-table-view-cell mui-media mui-col-xs-3"><a
					href="http://www.weceshi.com/index.php?s=/wetest/entry/index/id/2283"
					target="_blank">
						<figure class="cover">
							<img src="./css/index/1450663570xZQ5h.jpg"
								class="tuijian-img">
						</figure>
						<div class="mui-media-body tuijian-title">你会成为《芈月传》里面的谁？</div>
				</a></li>
				<li class="mui-table-view-cell mui-media mui-col-xs-3"><a
					href="http://www.weceshi.com/index.php?s=/wetest/entry/index/id/2494"
					target="_blank">
						<figure class="cover">
							<img src="./css/index/1452667218Lexq0.png"
								class="tuijian-img">
						</figure>
						<div class="mui-media-body tuijian-title">你是否患有忧郁症？</div>
				</a></li>
				<li class="mui-table-view-cell mui-media mui-col-xs-3"><a
					href="http://www.weceshi.com/index.php?s=/wetest/entry/index/id/2338"
					target="_blank">
						<figure class="cover">
							<img src="./css/index/1450926628me70h.png"
								class="tuijian-img">
						</figure>
						<div class="mui-media-body tuijian-title">你在后宫能活几天？</div>
				</a></li>
				<li class="mui-table-view-cell mui-media mui-col-xs-3"><a
					href="http://www.weceshi.com/index.php?s=/wetest/entry/index/id/1960"
					target="_blank">
						<figure class="cover">
							<img src="./css/index/1447331550offtO.png"
								class="tuijian-img">
						</figure>
						<div class="mui-media-body tuijian-title">全国人格分裂等级认证</div>
				</a></li>
				<li class="mui-table-view-cell mui-media mui-col-xs-3"><a
					href="http://www.weceshi.com/index.php?s=/wetest/entry/index/id/560"
					target="_blank">
						<figure class="cover">
							<img src="./css/index/1431097411790.jpg"
								class="tuijian-img">
						</figure>
						<div class="mui-media-body tuijian-title">你会在哪里结束单身？</div>
				</a></li>
				<li class="mui-table-view-cell mui-media mui-col-xs-3"><a
					href="http://www.weceshi.com/index.php?s=/wetest/entry/index/id/2477"
					target="_blank">
						<figure class="cover">
							<img src="./css/index/1452566611XILEa.png"
								class="tuijian-img">
						</figure>
						<div class="mui-media-body tuijian-title">回到后宫你能居何位？</div>
				</a></li>
				<li class="mui-table-view-cell mui-media mui-col-xs-3"><a
					href="http://www.weceshi.com/index.php?s=/wetest/entry/index/id/2414"
					target="_blank">
						<figure class="cover">
							<img src="./css/index/1451965010arKEJ.png"
								class="tuijian-img">
						</figure>
						<div class="mui-media-body tuijian-title">你的感性和理性各占多少？</div>
				</a></li>
				<li class="mui-table-view-cell mui-media mui-col-xs-3"><a
					href="http://www.weceshi.com/index.php?s=/wetest/entry/index/id/2307"
					target="_blank">
						<figure class="cover">
							<img src="./css/index/1450495315vqryM.png"
								class="tuijian-img">
						</figure>
						<div class="mui-media-body tuijian-title">你还剩多少女人味？</div>
				</a></li>
			</ul>
		</section>

		<!-- category start -->
		<!-- category end -->
		
		<!-- all list  -->
		<section id="all-game" class="main-content">
			<h5 class="diy-content-padded">
				全部测试<a class="diy-more"
					href="http://www.weceshi.com/index.php?s=/wetest/index/morehighquality"></a>
			</h5>
			<div class="diy-tab diy-space-big">
				<a class="diy-tab-item mui-active"
					url="/index.php?s=/wetest/index/getpagedata/order/utime/pageIndex/">最新</a>
				<a class="diy-tab-item"
					url="/index.php?s=/wetest/index/getpagedata/order/view/pageIndex/">最火</a>
				<a class="diy-tab-item "
					url="/index.php?s=/wetest/index/getpagedata/order/top/rcmd/1/pageIndex/">推荐</a>
			</div>
			<ul class="list " id="jingp">
				<li class="diy-item" date-id="2626"><a
					href="http://www.weceshi.com/index.php?s=/wetest/entry/brief/id/2626"
					target="_blank">
						<figure class="cover">
							<img class=""
								src="./css/index/14539484533fPSr.png">
						</figure>
						<div class="diy-meta">
							<div class="title mui-ellipsis">你的嫉妒心超标了吗</div>
							<span class="iconfont icon-start-filled5"></span> <span
								class="count">0.3 万人在测</span>
							<div class="desc mui-ellipsis">嫉妒是这样一种情绪——没有它，你会活在一个没有刺激感的世界，自己也会越来越麻木；被它控制，你会活得越来越辛苦，心理也随之越来越扭曲。看看你的嫉妒荷尔蒙是否超标了呢？</div>
						</div>
				</a> <a
					href="http://www.weceshi.com/index.php?s=/wetest/entry/brief/id/2626"
					class="play" data-ui="danger small icon-right"> 去测<i
						class="iconfont icon-right"></i>
				</a></li>
	
				
				
			</ul>
		</section>
        <div class="refresh-tip main-content">
    		<span><img src="./css/index/loading.gif"></span>正在加载
    	</div>
	
	</div>
	
	<a
		href="http://www.weceshi.com/index.php?s=/wetest/index/index/from/tl#">
		<img id="goTop" src="./css/index/gotop.png"
		style="display: none;">
	</a>
</div>

<textarea id="game-item" style="display: none;">            &lt;li class="diy-item"&gt;
                &lt;a href="/index.php?s=/wetest/entry/brief/id/##id##" target="_blank"&gt;
                	&lt;figure class="cover"&gt;
                		 &lt;img class="" src="http://7xlmq3.com1.z0.glb.clouddn.com/##img##?imageView2/1/w/100/h/100"&gt;
                	&lt;/figure&gt;                   
		            &lt;div class="diy-meta"&gt;
		                 &lt;div class="title mui-ellipsis"&gt;##title##&lt;/div&gt;
		                 &lt;span class="iconfont icon-start-filled5"&gt;&lt;/span&gt;
		                 &lt;span class="count"&gt;##view## 万人在测&lt;/span&gt;
		                 &lt;div class="desc mui-ellipsis"&gt;##desc##&lt;/div&gt;
		             &lt;/div&gt;
                &lt;/a&gt;
				&lt;a href="/index.php?s=/wetest/entry/brief/id/##id##" class="play" data-ui="danger small icon-right"&gt;
					去测&lt;i class="iconfont icon-right"&gt;&lt;/i&gt;
				&lt;/a&gt;                                
            &lt;/li&gt;
	</textarea>

<script>
		var pageIndex = 2;
		var serverUrl = "/index.php?s=/wetest/index/getpagedata/order/utime/pageIndex/";
    </script>
<script src="./css/index/common.js"
	type="text/javascript" charset="utf-8"></script>
<script src="./css/index/app.js" type="text/javascript"
	charset="utf-8"></script>
<!--common share for game platform-->
<script src="./css/index/jweixin-1.0.0.js"> </script>
<script>
	var conf_data = {
		appId: 'wxa2c107575b8a6fa1',
		timestamp: 1454334099,
		nonceStr: 'wetest',
		signature: '85349f168d43eb571b441026fe5e68c51f4733e9' 
	}
var shareData = {
	trigger: function(res) {
		wx.onMenuShareAppMessage(shareData);
		wx.onMenuShareTimeline(shareData);
	},
};
wx.config({
	debug: false,
	appId: conf_data.appId,
	timestamp: conf_data.timestamp,
	nonceStr: conf_data.nonceStr,
	signature: conf_data.signature,
	jsApiList: ['checkJsApi', 'onMenuShareAppMessage', 'onMenuShareTimeline','closeWindow']
});
wx.ready(function() {
	wx.onMenuShareAppMessage(shareData);
	wx.onMenuShareTimeline(shareData);
});
wx.error(function(res) {  

});
wx.checkJsApi({
	jsApiList: ['onMenuShareTimeline'],
	success: function(res) {

	} 
});

function ajaxGet(url,callback){
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET",url,true);
	xmlHttp.onreadystatechange= function(){
		if (xmlHttp.readyState==4 && xmlHttp.status==200){
			callback&&callback(xmlHttp.responseText);
		}
	}
	xmlHttp.send();
}

function shareCallBack(){
	setTimeout(attention_wx,500);
	}
function attention_wx() {
	alert("《微测试》 - 每天发布最萌、逗、炫、酷的小测试！无需下载，点开即测！每日更新！\n----点击确认，立即去关注----");
	location.href='http://mp.weixin.qq.com/s?__biz=MzA4OTY4ODUyOA==&mid=201224433&idx=1&sn=854e678b07926f3e37cab8afbeb58312#rd';
}

var _host = "http://" + window.location.host;
var share_url = _host + "/index.php?s=/wetest/index/index/from/tl";
shareData = {
	title : '每天发布最萌、逗、炫、酷的小测试！无需下载，点开即测！每日更新！',
	desc   : '来自--【微测试】',
	link  : share_url,
	imgUrl   : "http://7xlmq1.com1.z0.glb.clouddn.com/index/img/share-icon.png",
	trigger: shareData.trigger,
	success: function (res) {
		shareCallBack();
	}
};
</script>


<div style="display: none">
	<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256625807'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/stat.php%3Fid%3D1256625807' type='text/javascript'%3E%3C/script%3E"));</script>
	<span id="cnzz_stat_icon_1256625807"><a
		href="http://www.cnzz.com/stat/website.php?web_id=1256625807"
		target="_blank" title="站长统计">站长统计</a></span>
	<script src="./css/index/stat.php"
		type="text/javascript"></script>
	<script src="./css/index/core.php" charset="utf-8"
		type="text/javascript"></script>
</div>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>