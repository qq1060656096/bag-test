<div class="ux-popmenu ux-popmenu1" style="background-color: rgba(0, 0, 0, 0.498039);vertical-align: bottom;">
<div id="box-comment" class="container stage-publisher">

	<div id="boxId_1447072618335_3"></div>
	<header class="module-topbar" id="boxId_1447165659499_1" >
		<a class="fl txt-link cancel1"  title="取消" >取消</a>
		<a class="fr txt-link disable1"  title="发送" >发送</a>
		<div class="title-group">
			<h1 class="title txt-cut">发私信</h1>
		</div>
	</header>
	<article class="module-publisher" >
		<div class="txt-publisher-wrapper">
		    <input type="text" disabled="disabled" id="txt-to_uid" uid="" name="content" class="" placeholder="@Ta" value="@<?php echo $ta_user_showNickname;?>"/>
			<textarea id="txt-publisher" name="content" class="J-textarea txt-publisher" placeholder="内容"></textarea>
		</div>
		<div class="wrapper-info-publisher">
			<div class="info-publisher selfclear">
				<span class="J-limit fr"></span>

			</div>
		</div>
		<section class="action-publisher layout-box line-bottom">
			<div class="toolbaricon">
				<span class="iconf iconf_compose_mention"></span>
			</div>
			<div class="toolbaricon">
				<span class="iconf emotion iconf_compose_emoticon"></span>
			</div>
		</section>


	</article>

</div>
</div>
<style>

.container,body {
    padding: 0;
	margin:0;
}
#box-comment {
    position: fixed;
    bottom: 0;
    width: 100%;
    min-height: 215px;
}
.module-topbar .title-group .title:only-child {
    font-size: 1.125rem;
    line-height: 44px;
	margin: 0;
}
.module-topbar {
    height: 44px;
    color: #333;
    text-align: center;

    width: 100%;
    z-index: 19;
    -wekbit-box-shadow: 0 1px 2px #cfcfcf;
    box-shadow: 0 1px 2px #cfcfcf;
    background: #f9f9f9;
}


.module-topbar .txt-link {
    padding: 0 10px;
    font-size: 1.0625rem;
    line-height: 44px;
    color: #FF8200;
}
.module-topbar .txt-link {
    padding: 0 10px;
    font-size: 1.0625rem;
    line-height: 44px;
    color: #FF8200;
	text-decoration: none;
}
.fl {
    float: left;
}

.fr {
    float: right;
}

.module-topbar .title-group .title:only-child {
    font-size: 1.125rem;
    line-height: 44px;
}

.txt-cut {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.module-publisher {
    position: absolute;
    background-color: #fafafa;
    max-height: 100%;
    width: 100%;
}

.module-publisher .txt-publisher-wrapper {
    background-color: #fff;
    padding: 5px 0 0 0;
}

.module-publisher .J-textarea {
    padding: 8px 14px 0 14px;
    width: 100%;
    height: 120px;
    font-size: 16px;
    resize: vertical;
    border: none;
    background-color: #fff;
    -webkit-tap-highlight-color: transparent;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.module-publisher .action-publisher {
    background-color: #f9f9f9;
    overflow: hidden;
    font-size: 22px;
    text-align: center;
    position: relative;
    height: 43px;
    z-index: 1;
}

.module-publisher .wrapper-face {
    padding: 0 0 1px;
    background-color: #f2f2f2;
    position: relative;
    z-index: 1;
    -webkit-tap-highlight-color: transparent;
}

.module-publisher .J-preview {
    background-color: #fafafa;
    position: absolute;
    margin-top: 15px;
    padding-top: 1px;
    width: 100%;
    overflow: hidden;
    -webkit-overflow-scrolling: touch;
}

.module-publisher .J-preview .add-picture {
    display: inline-block;
    position: relative;
    text-align: center;
    vertical-align: bottom;
    visibility: hidden;
    margin: 0 0 10px 10px;
}

.iconf {
    font-family: wb440;
    color: #444;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.module-publisher .J-preview input {
    position: absolute;
    left: 0;
    opacity: 0;
    vertical-align: middle;
}
#txt-to_uid{
	width: 100%;
	height: auto;
	padding: 0 14px 0 14px;
}
</style>
