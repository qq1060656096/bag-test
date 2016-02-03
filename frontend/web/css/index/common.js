///**
// * Created by delan on 2015/10/19.
// */
//var getFlag = true,endFlag = false, pullDataFlag = true;
//window.onscroll = function(){
//    var top = document.documentElement.scrollTop || document.body.scrollTop;
//    if(top +document.body.clientHeight>=document.body.scrollHeight - 40){
//        if(pullDataFlag)
//        pulldownRefresh(true);
//    }
//
//}
//String.prototype.temp = function(obj) {
//    return this.replace(/\##\w+\##/gi, function(matchs) {
//        var returns = obj[matchs.replace(/\##/g, "")];
//        return (returns + "") == "undefined"? "": returns;
//    });
//};
//
//function appendListItem(content , append){
//    var length = content&&content.length;
//    var htmlTemp,htmlList = "";
//    if(!length) {
//        endFlag = true;
//        $('.refresh-tip').html('更多游戏正在开发中');
//        setTimeout(function(){
//            $('.refresh-tip').hide();
//        },1000)
//        return true;
//    }
//    for(var i=0; i<length;i++){
//        htmlTemp = $('#game-item').val();
//        if(content[i]['is_game'] == 0){
//            htmlTemp = htmlTemp.replace('brief','index');
//        }
//        htmlList += htmlTemp.temp(content[i]);
//    }
//    if(append && htmlList && $('.diy-item').length){
//        $('.diy-item').last().after(htmlList);
//    }
//    else{
//        $('#jingp').html(htmlList);
//    }
//    $('.refresh-tip').hide();
//}
//
//function ajaxGetdata(url,callback){
//    $.ajax({
//        type: 'get',
//        url: url,
//        success:function(result){
//            $result = JSON.parse(result);
//            callback&&callback($result);
//        }
//    });
//}
//
//function pulldownRefresh(append){
//    var url = serverUrl + pageIndex;
//    $('.refresh-tip').show();
//    if(endFlag){
//        $('.refresh-tip').html('更多游戏正在开发中');
//        setTimeout(function(){
//            $('.refresh-tip').hide();
//        },1000)
//        return true;
//    }
//    if(!getFlag) return true; 	 /*is getting data now */
//    getFlag = false;
//
//    ajaxGetdata(url,function(content){
//        getFlag = true;  /*get data finished */
//        pageIndex = pageIndex + 1;
//        appendListItem(content ,append);
//
//    });
//}
//
//$('.diy-tab-item').click(function(){
//    if($(this).hasClass('mui-active')){
//        return true;
//    }
//    pageIndex = 1;
//    endFlag = false;
//    $('#loading-tip').html('正在加载');
//    $('.diy-tab-item').removeClass('mui-active');
//    $(this).addClass('mui-active');
//    serverUrl = $(this).attr('url');
//    pulldownRefresh(false);
//})
//
