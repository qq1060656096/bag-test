<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\z\ZCommonFun;
use common\models\Survey;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SurverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $row common\models\Survey */
$this->title = '个人中心';
$this->params['breadcrumbs'][] = $this->title;

echo $this->renderFile(__DIR__.'/../layouts/head.php');
?>
<style>
.user-info{
	margin:  15px;
}
.user-info>table{
	width: 100%;
}
.user-info .user-image{
	font-size: 4em;
}
.user-info .td-1{
	text-align: center;
	width: 25%
}
.user-info table td{
	vertical-align: bottom;
	
}
.user-info .td-2,.user-info .td-3{
	line-height:2em;
	font-size: 0.95em;
}
.user-menu a{
	border-top:1px dashed #ddd;
	border-bottom: 1px solid #ddd;
	color: #888;
	width: 33.3333%;
	display: block;
	float: left;
	text-align: center;
	line-height: 2em;
}

#main_body a:first-child span,a>span.vertical-line{
	border: ;
	font-size: 0.95em;
	width:1px;
	height: 2.1em;
	border-right: 1px dashed #f6f6f6;
	float: right;
}
#main_body .list_box a:first-child span{
	width: auto;
	margin-left: -0.2em;
}
</style>
<script type="text/javascript" src="./bag-test/js/jquery-2.1.0.min.js"></script>
<div id="main_body">
    <header class="s_header">
		<nav>


			 <span style="font-size: 1.4rem"><?php echo $this->title;?></span>
		</nav>
	</header>
	
	
	
	<section class="s_moreread">
			<div class="user-info">
				<table>
					<tr>
						<td class="td-1">
							<i class="fa fa-user user-image  common-color"></i>
						</td>
						<td class="td-2">
							<h3  class="common-color">风之谷</h3>
							<div>创建了<sapn class="common-color">100685</sapn>个测试  </div>
							<div>收到打赏 <sapn class="common-color">10089元</sapn></div>
						</td>
						<td class="td-3">
							<div>测过<sapn class="common-color">1258</sapn>次 </div>
							<div>给朋友打赏<sapn class="common-color"> 2080.96元</sapn></div>
						</td>
					</tr>
				</table>
			</div>
			<nav class="user-menu">
				<a>我创建的测试<span class="vertical-line"></span></a>
				<a>余额提现<span class="vertical-line"></span></a>
				<a>修改设置 </a>
			</nav>
			
			
			
			<div  style="clear: both;">
			</div>
			
			<div class="list_box">

				<dl>
					<a href="./start.html">
						<dt>
							<img src="./bag-test/test-images/103754b6unkvhquepniein.jpg!50"
								alt="你有多怕谈恋爱：恋爱恐怖程度自评">
						</dt>
						<dd>
							<h3>你有多怕谈恋爱：恋爱恐怖程度自评</h3>
						</dd>
						<dd>爱情就像一场赌博,你越恐惧就越得不到幸福。你会因为曾经的伤害,而不敢接受新的恋情吗?完成测试,看看你的恐惧指数有多高。</dd>
						<dd>
							<span>测试过：11593</span>
						</dd>
					</a>
				</dl>

			</div>
			<div class="load_more">加载更多</div>
			
		</section>
		
      
 </div>
<?php echo $this->renderFile(__DIR__.'/../layouts/foot.php');?>
