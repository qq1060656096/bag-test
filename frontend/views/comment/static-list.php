
<div class="module module-comment" id="boxId_1447072536042_3">
	<div class="info-bar txt-l">
		<div class="layout-box line-bottom">
			<div class="box-col">
				<span class="info-txt" data-node="repost">浏览次数&nbsp;<em><?php echo $model->visit_count;?></em><i
					class="arrow-up line-top"><i class="arrow-up-in line-top"></i></i></span><span
					class="line-right"></span><span class="info-txt current"
					data-node="comment">评论&nbsp;<em><?php echo $model->comment_count;?></em><i
					class="arrow-up line-top"><i class="arrow-up-in line-top"></i>
					</i></span>
					<button class="comment-button" url="<?php echo Yii::$app->urlManager->createUrl(['comment/add','id'=>$model->answer_sr_id,'tid'=>$model->uid,'content'=>'#content#']); ?>">评论</button>
			</div>
			<div class="plus">
				<span class="info-txt" data-node="like">&nbsp;<em></em><i
					class="arrow-up line-top"><i class="arrow-up-in line-top"></i></i></span>
			</div>
		</div>
	</div>
	<div class="line-around comment-box hid" data-node-type="repost-list">
		<ul class="comment-list">
			<div class="loading"></div>
		</ul>
	</div>
	<div class="line-around comment-box" data-node-type="comment-list">
		<ul class="comment-list">
			<section class="mod-pagelist card-combine" id="boxId_1447072536042_5">
				<div data-node="cardList" class="card-list">
					
				</div>
				<div class="load_more2">加载更多</div>
			</section>
		</ul>
	</div>
	<div class="line-around comment-box hid" data-node-type="like-list">
		<ul class="comment-list">
			<div class="loading"></div>
		</ul>
	</div>
</div>
<style>
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}
.module-comment {
    border-bottom: 0 none;
    box-shadow: none;
}
.line-around, .module {
    background-color: #fff;
    border-top: 1px solid #e6e6e6;
    border-bottom: 1px solid #d8d8d8;
    box-sizing: border-box;
    box-shadow: 0 1px .1875rem -.125rem rgba(0,0,0,.2);
	
}
.card, .module {
   margin-bottom: 3.5em;
}


.hid {
    display: none;
}



.module-comment .info-bar {
    height: 43px;
    line-height: 43px;
 
    position: relative;
    z-index: 1;
}
.txt-l {
    font-size: .9375rem;
}

.line-around, .module {
    background-color: #fff;
    border-top: 1px solid #e6e6e6;
    border-bottom: 1px solid #d8d8d8;
    box-sizing: border-box;
    box-shadow: 0 1px .1875rem -.125rem rgba(0,0,0,.2);
}



.module-comment .comment-box {
    position: relative;
    border: 0;
    background-color: #fefefe;
}

.module-comment .mod-pagelist .card-list {
    box-shadow: none;
}


.module-infobox {
    position: relative;
    padding: 10px 12px;
}
.line-bottom, .card-combine .line-around:not(.card9), .line-separate::after {
    border-bottom: 1px solid #dadada;
}
.layout-box {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
}
.layout-box .box-col {
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    width: 100%;
}
.module-comment .info-txt {
    display: inline-block;
    padding: 0 9px;
    position: relative;
    color: #929292;
}
.module-comment .info-txt .arrow-up {
    display: none;
}
.module-comment .arrow-up {
    top: 39px;
    left: 50%;
    margin-left: -4px;
}
.arrow-up {
    position: absolute;
    top: -.3125rem;
    left: .5rem;
    z-index: 0;
    width: .5rem;
    height: .5rem;
    background-color: #fefefe;
    -webkit-transform: rotate(45deg);
}
.line-top {
    border-top: 1px solid #dadada;
}
.line-right, .line-separate::before, .card.col-1 .line-separate::before, .card.col-2 .line-separate::before, .card.col-3 .line-separate::before, .card.col-4 .line-separate::before, .card.col-5 .line-separate::before, .line-gradient {
    border-right: 1px solid #dadada;
}
.module-comment .info-txt.current {
    color: #333;
}
.module-comment .info-txt {
    display: inline-block;
    padding: 0 9px;
    position: relative;
    color: #929292;
}

.layout-box .plus {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
    -webkit-box-pack: end;
    -ms-flex-pack: end;
    -webkit-justify-content: flex-end;
    justify-content: flex-end;
}



.module-infobox .mod-media {
    height: 34px;
    margin: 0 12px 0 0;
    padding: 0;
}
.mod-media:first-child {
    margin-left: .75rem;
}
.size-xs {
    width: 2.125rem;
}
.mod-media {
    position: relative;
    display: block;
    text-align: center;
    margin: .625rem 0 .625rem .5rem;
}



.mod-media .media-main {
    position: relative;
}
.module-infobox img {
    vertical-align: text-bottom;
}
.mod-media img {
    display: block;
    vertical-align: top;
}


infobox .item-list {
    padding: 0 15px 0 0;
}
.media-graphic .item-list {
    padding: .5rem .6875rem;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-direction: normal;
    -webkit-box-orient: vertical;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
}
.layout-box .box-col {
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    width: 100%;
}

.module-infobox .item-main {
    font-weight: 400;
}
.media-graphic .item-main {
    line-height: 1.125rem;
    overflow: hidden;
}
a .mct-a, .mct-a {
    color: #333;
}
.txt-cut {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.txt-s {
    font-size: .8125rem;
}

.media-graphic .item-minor, .media-graphic .item-other {
    padding: .25rem 0 0;
    line-height: 1rem;
}
a .mct-d, .mct-d {
    color: #929292;
}
.txt-cut {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.txt-xxs {
    font-size: .625rem;
}

.module-infobox .item-minor {
    padding: 5px 0 0;
    line-height: 1.25rem;
    word-wrap: break-word;
}
.media-graphic .item-minor, .media-graphic .item-other {
    padding: .25rem 0 0;
    line-height: 1rem;
}
a .mct-b, .mct-b {
    color: #5d5d5d;
}
.txt-l {
    font-size: .9375rem;
}


.module-infobox .operate-box {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 48px;
    height: 1rem;
    text-align: right;
    padding: 22px 12px 22px 0;
    cursor: pointer;
}

.load_more2 {
    height: 30px;
    font-size: 14px;
    text-align: center;
    border-top: 1px dashed #DFDFDF;
    line-height: 30px;
    color: #666;
    padding: 10px 0;
	cursor: pointer;
}
</style>
<script>
ajaxLoad2();
$(".load_more2").click();
/**
 * ajax加载分页
 */
function ajaxLoad2(){
	
	commentPage = 0;
	isAjaxLoad2 = false; 
    $(".load_more2").click(function(){
        var now =$(this);
        commentPage++;
        var url = "<?php echo Yii::$app->urlManager->createUrl(['comment/list','id'=>$model->answer_sr_id,'page'=>'#page#','sort'=>'sort']);?>";
        url = url.replace('%23page%23',commentPage);
        console.log(url);
        //有没有执行ajax就执行ajax,在执行，等执行后在加载
        if(!isAjaxLoad2){
        	isAjaxLoad2 = true;
        	now.text('加载中');
            $.get(url,function(html){
            	now.text('加载更多');
            	isAjaxLoad2 = false;
//                 console.log(html);
                //没有找到
                if(html==''){
                	isAjaxLoad2 = true;
                	now.text('已经没有了');
                	console.log('已经没有了');
                }
                $(".card-list").append( html );
            });
        }
    });
}
</script>