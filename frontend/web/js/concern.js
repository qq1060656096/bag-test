/**
 * 
 */

function concern(now_element){
	//定义ajax请求
	var ajax_name = 'concern_ajax_request';
	var $now = $(now_element);
	var fuid = $now.attr('fuid');
	var url = $now.attr('url');
	var ajax = $now.attr(ajax_name);
	if( ajax == undefined ){
		ajax = 0;
	}
	if(!url){
		return false;
	}
	ajax++;
	ajax--;
	if( ajax > 0 ){
		return false;
	}
	$now.attr(ajax_name,1);
	$.getJSON(url,function(json){
		$now.attr(ajax_name,0);
		if( json.status == undefined ){
			alert('操作错误,'+json);
		}
		else if( json.status==-1 ){
			alert('请登录');
		}else if( json.status==0  ){
			json.data ? $now.html(json.data) : null;
			alert(json.message);
		}else{
			alert(json.message);
		}
	});
	return false;
}