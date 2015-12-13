(function($) {     

$.fn.ZHtml5Upload = function(options) {     
	//默认值 
	var defaults = {    
		uploadSucess:null, //上传成功返回
		uploadError:null, //上传错误
		uploadUrl:'./common/php-html5-uploadz/upload.php', // 上传服务器url
		uploadArg:'file', //上传参数
		base64Data:null, //只有触发 readerDAtaEvent事件才会有该值
		readerDAtaEvent:'change', //触发事件上传函数
		isReaderFile: false,
		auto:true
	};    

	this.uploadzData = null;
	// Extend our default options with those provided.    
	var uploadz = $.extend(defaults, options);  
	$.extend(uploadz, null);
	//是否读取文件,执行了readerDAtaEvent才会为true
	uploadz.isReaderFile = false ;
	uploadz.file = null;

	uploadz.errorType = ['不是图片类型','上传错误'];
	
	$(this).on(uploadz.readerDAtaEvent,  function(event){
		uploadz.file = this.files[0];
		uploadz.eventCall( event );

	});
	
	//读取事件
	uploadz.eventCall = function( event ){
		uploadz.clear();
		var file = uploadz.file ;
		//判断是不是图片类型
		var imageType = /image.*/;
		if (file.type.match(imageType)) {
			var reader = new FileReader();
			reader.onload = function() {
				uploadz.base64Data = reader.result;
				uploadz.isReaderFile = true;
				//自动上传
				if(uploadz.auto){
					uploadz.upload();
				}
			};
			reader.readAsDataURL(file);
			
		}else{
			uploadz.uploadError('请上传图片格式');
		}
	}
	//上传
	uploadz.upload = function upload(){
		$.post(	uploadz.uploadUrl,
		{file:uploadz.base64Data} , function(result){
			uploadz.uploadSucess(result,uploadz);
		} ).error( uploadz.uploadError );
		
	}

	uploadz.clear = function(){
		uploadz.base64Data = null;
		uploadz.isReaderFile = false;
	}
	this.uploadzData=uploadz;

	return this;
};     

})(jQuery);  