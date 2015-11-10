<div class="ux-popmenu ux-popmenu2"
	style="display: block; position: fixed; background-color: rgba(0, 0, 0, 0.498039);">
	<div class="content show" style="bottom: 0px; position: fixed;">
		<section class="card-combine">
			<a href="" node-type="recommend" class="line-bottom"
				reporttype=""><span>回复</span></a><a href="javascript:;"
				node-type="reportPL" reporttype=""><span>举报</span></a> <a
				class="close line-top" href="javascript:;"><span>取消</span></a>
		</section>
	</div>
</div>
<style>
.ux-popmenu {
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1001;
    transition: background-color .2s ease-in-out;
    overflow: hidden;
}

.ux-popmenu .content.show {
    bottom: 0;
    transition: bottom .2s ease-in-out;
}
.ux-popmenu .content {
    position: absolute;
    left: 0;
    bottom: -300px;
    width: 100%;
    background: #e7e7e7;
    border-top: 3px solid orange;
    box-shadow: 0 -1px 40px rgba(0,0,0,.3);
}

.ux-popmenu section a {
    display: block;
    height: 48px;
    line-height: 48px;
    text-align: center;
    font-size: 16px;
    background: #f8f8f8;
    color: #333;
    margin-bottom: 1px;
}

.ux-popmenu section span {
    display: block;
    background: #f8f8f8;
}
</style>
<script type="text/javascript">
//取消评论
$(".ux-popmenu2 .close").click(function(){
	$(this).closest(".ux-popmenu2").hide();
});
//评论
$(".ux-popmenu2 .line-bottom").click(function(){
	$(".ux-popmenu").show();
	$(".ux-popmenu2").hide();
	return false;
});
</script>
<?php 
echo $this->renderFile(__DIR__ . '/../comment/static-comment-message.php',['model'=>$model]);
?>
