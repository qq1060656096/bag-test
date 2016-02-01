var firstid,name;

window.onload = function(){
	Newmsg();
}
function Newmsg(){
	var firstid = [];
	for(i=0;i<10;i++){
		firstid[i] = $('.diy-item').eq(i).attr('date-id');
	}
	var cookie = getCookie();
	if(cookie){
		var newindex = 10;
		for(var i = 0;i<10;i++){
			if(cookie.indexOf(firstid[i]) >= 0){
				newindex -= 1;
			}
		}
		if( newindex >= 4 ){
			console.log(newindex)
			$('.alertbox').show();
			$('.new-ceshi').addClass('bouncein');
		}else{
			console.log(newindex)
		}
	}else{
		$('.alertbox').show();
		$('.new-ceshi').addClass('bouncein');
	}
}
function setCookie(){
	var exdate=new Date();
	var c_name = "quce_newmessage_id";
	var value = [];
	for(i=0;i<10;i++){
		value[i] = $('.diy-item').eq(i).attr('date-id');
	}
	exdate.setDate(exdate.getDate()+1)
	document.cookie=c_name+ "=" +escape(value)+((1==null) ? "" : "; expires="+exdate.toGMTString())
}
function getCookie(){
	var c_name = "quce_newmessage_id";
	if (document.cookie.length>0){ 
		c_start=document.cookie.indexOf(c_name + "=")
		if (c_start!=-1){ 
			c_start=c_start + c_name.length+1 
			c_end=document.cookie.indexOf(";",c_start)
			if (c_end==-1)
				c_end=document.cookie.length
			return unescape(document.cookie.substring(c_start,c_end))
		} 
	}
	return ""
}

$('#closebtn').click(function(){
	setCookie();
	$('.new-ceshi').addClass('bounceout');
	setTimeout(function(){$('.alertbox').hide();},700);
});
	
$('#morebtn').click(function(){
	setCookie();
	$('.new-ceshi').addClass('bounceout');
	setTimeout(function(){
		$('.alertbox').hide();
		var allGameEle = document.getElementById('all-game');
		var top = allGameEle.offsetTop - 100;
		var timeDelta = 800/100;
		var topDelta = top/timeDelta;
		console.log(topDelta)
		var scrollTop = 0;
		var scrollTopTimer = setInterval(easeTop,100);
		function easeTop(){
			scrollTop = scrollTop + topDelta;
			if(scrollTop > top){
				clearInterval(scrollTopTimer);
			}
			document.body.scrollTop = scrollTop;
		}
	},700);
});

var swiper = new Swiper('#banner-slider', {
	pagination: '.swiper-pagination',
	paginationClickable: true,
	autoplay:'2000',
	loop: true
});

var appSwiper = new Swiper('#app-slider', {
	pagination: false,
	paginationClickable: true,
	slidesPerView: '4.5',
	loop: false,
	spaceBetween: 10
});

var rcmdClose = document.querySelectorAll('.search-rcmd-close')[0];
var searchPanel = document.querySelectorAll('.search-rcmd')[0];

rcmdClose && (rcmdClose.onclick = function(){
	$('.main-content').removeClass('woqu-hide').addClass('woqu-show');
	hideSearchPanel();
});

function showSearchPanel(){
	$('.main-content').removeClass('woqu-show').addClass('woqu-hide');
	//$('.mui-content').addClass('hide-head');
	pullDataFlag = false;
	var searchKey = $('#search').val();
	searchKey = searchKey.replace('大家都在搜：','');
	$('#search').val(searchKey);
	searchPanel.style.display = "block";
}

function  hideSearchPanel(){
	pullDataFlag = true;
	//$('.mui-content').removeClass('hide-head');
	searchPanel.style.display = "none";
}


var autoSearch = (function(){
	var searchTag = document.querySelectorAll('.search-label');
	var searchEle = document.getElementById('search');
	var closeEle = document.querySelector('.icon-close');
	var searchInput = document.getElementById('search-btn');
	var searchTitle = []; /*搜索标题数组*/
	var searchUrl = []; /*搜索链接数组*/
	var index = 0;

	var timer; /* 检测输入*/
	var changeTimer; /*自动变化关键词*/

	for(var key=0; key<searchTag.length; key++){
		searchTitle[key] = searchTag[key].innerText;
		searchUrl[key] = searchTag[key].getAttribute('href');
	}

	function setAutoSearch(){
		changeTimer = setInterval(function(){
			index++;
			if(index >= searchTag.length) index=0;
			var value = '大家都在搜：' + searchTitle[index];
			//$('#search').val(value);
			$('#search').attr('placeholder',value );
		},4000);
	}
	setAutoSearch();

	searchEle.onchange = function(){
		closeEle.classList.add('search-active');
	}
	closeEle.onclick = function(){
		searchEle.value = '';
		closeEle.classList.remove('search-active');
	}
	searchEle.onfocus = function(){
/*		if(searchUrl[index].indexOf('http://') > -1)
		window.location = searchUrl[index];*/
		clearInterval(changeTimer);
		showSearchPanel();
		timer = setInterval(function(){
			var search = searchEle.value;
			if(search.length) {
				closeEle.classList.add('search-active');
			}else{
				closeEle.classList.remove('search-active');
			}
		},500);
	};

	searchInput.onclick = function(){
		var searchInput = $('#search').val();
		if(searchInput){
			var action = $('#search-form').attr('action');
			window.location = action + searchInput;
		}else{
			window.location = searchUrl[index];
		}

	};
	searchEle.onblur = function(){
		clearInterval(timer);
		setAutoSearch();
	}
}());

function woquScoll(top,time){
	var timeDelta = time/100;
	var topDelta = top/timeDelta;
	console.log(topDelta)
	var scrollTop = 0;
	var scrollTopTimer = setInterval(easeTop,100);
	function easeTop(){
		scrollTop = scrollTop + topDelta;
		if(scrollTop > top){
			clearInterval(scrollTopTimer);
		}
		document.body.scrollTop = scrollTop;
	}
}

/*
var  hashJump = (function(){
     setTimeout(function(){
		 var hash = location.hash;
		 if(hash.indexOf('hash-category') > -1){
			 window.location = "#category";
			 var category = document.getElementById('category');
			 var top = category.offsetTop - 40;
			 document.body.scrollTop = top;

		 }
	 },800)
}());*/





