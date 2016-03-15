<?php 
namespace common\z\oauth\weixin;

/**
 * 请开启php_curl模块【php.ini文件】
 * 微信TOKEN
 * @var unknown
 */
class WeiXin {
	/**
	 * 微信token
	 * @var string
	 */
	public $TOKEN = "";
	/**
	 * appid
	 * @var string
	 */
	public $APPID = "wx389a3d914a54f385";
	//wx1ebfaefb5cf5edc5
	//116db9d5c7a1469b97e65be1b93d622d
	/**
	 * appsecrets
	 * @var string
	 */
	public $SECRETS = "78d58f632ed51cca2c7e740fb4728eb2";
	/**
	 * 凭证接口认证 地址
	 * @var string
	 */
	public $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
	/**
	 * 主动发送客户消息地址
	 * @var string
	 */
	public $url_send_message = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=";
	/**
	 * 上传图片地址
	 * @var unknown
	 */
	public $url_upload_media = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=%s&type=%s";
	/**
	 * 创建自定义菜单
	 * @var string
	 */
	public $url_create_menu  = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=";
	/**
	 * 
	 * @var string 开发者 网址
	 */
	public $URL = '';
	/**
	 * 
	 * @var string 接收方帐号（收到的OpenID）
	 */
	public $ToUserName	 = '';//是	 
	/**
	 * 
	 * @var string 开发者微信号
	 */
	public $FromUserName = '';// 是	开发者微信号
	/**
	 * 
	 * @var int 消息创建时间 （整型）
	 */
	public $CreateTime	 = 0;//是	
	/**
	 * 消息类型
	 * voice 语音
	 * image 图片
	 * video 视频
	 * text  文本
	 * @var string
	 */ 
	public $MsgType	     = null;//是	 text
	/**
	 * 
	 * @var string 回复的消息内容
	 */
	public $Content	     = '';//是	 （换行：在content中能够换行，微信客户端就支持换行显示）
	/**
	 *  通过上传多媒体文件，得到的id
	 * @var unknown
	 */
	public $MediaId 	 = '';//是 通过上传多媒体文件，得到的id
	/**
	 * 图片链接
	 * @var string
	 */
	public $PicUrl       = '';
	/**
	 * 语音格式，如amr，speex等
	 * @var unknown
	 */
	public $Format       = '';
	/**
	 * 视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。
	 * @var unknown
	 */
	public $ThumbMediaId ='';
	/**
	 * post 提交 XML 解析
	 * @var mixed
	 */
	public $xml_parse   = null;
	/**
	 * 消息id，64位整型
	 * @var unknown
	 */
	public $MsgId       = '';
	/**
	 * 事件key
	 * @var string
	 */
	public $EventKey = '';
	/**
	 * 微信事件
	 * @var string
	 */
	public $Event = '';
	/**
	 * 关注事件
	 * @var string
	 */
	public $event_type_subscribe='subscribe';
	/**
	 * 取消关注事件
	 * @var string
	 */
	public $event_type_unsubscribe='unsubscribe';
	/**
	 * 获取地理位置
	 * @var string
	 */
	public $event_type_LOCATION = 'LOCATION';
	/**
	 * 点击菜单跳转链接时的事件推送
	 * @var string
	 */
	public $event_type_VIEW = 'VIEW';
	/**
	 * 点击菜单拉取消息时的事件推送
	 * @var string
	 */
	public $event_type_CLICK = 'CLICK';
	/*================ get user info==================*/
	
	/**
	 *用户基本信息url
	 * @var string
	 */
	public $userInfoUrl ="https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=%s";

	/**
	 * 用户认证地址
	 * @var string
	 */
	public $oauth2Url   ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=%s&scope=%s&state=%s#wechat_redirect";
	
	/**
	 * 用户认证成功后获取code
	 * @var string 
	 */
	public $oauth2_code = '';
	/**
	 * 通过code换取网页授权access_token
	 * @var string
	 */
	public $oauth2_access_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code';
	
	/**
	 * 刷新授权token
	 * @var string
	 */
	public $oauth2_refresh_token_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=%s&grant_type=%s&refresh_token=%s';
	/**
	 * 访问token
	 * 调用接口凭证
	 * @var string
	 */
	public $access_token = '';
	public $params_arr =array(
		'text'=>array(
			'ToUserName','FromUserName','Content','MsgId'	
		),
		'image'=>array(
				'ToUserName','FromUserName','PicUrl','MediaId','MsgId'
		),
		'voice'=>array(
				'ToUserName','FromUserName','MediaId','Format','MsgId'
		),
		'video'=>array(
				'ToUserName','FromUserName','MediaId','ThumbMediaId','MsgId'
		),
		'event'=>array(
				'ToUserName','FromUserName','Event','EventKey','MsgId'
		),
		'CLICK'=>array(
				'ToUserName','FromUserName','Event','EventKey','MsgId'
		),
		'LOCATION'=>array(
				'ToUserName','FromUserName','Event','MsgType','Latitude','Longitude','Precision'
		),
	);
	public function __construct($xml=''){
	    $GLOBALS['HTTP_RAW_POST_DATA'] = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
		$xml = empty($xml)?$GLOBALS['HTTP_RAW_POST_DATA'] : $xml;
		$this->xml_parse = simplexml_load_string($xml);//$GLOBALS['HTTP_RAW_POST_DATA']	
		if(isset($this->xml_parse->CreateTime) || isset($this->xml_parse->MsgType) ){
		    $this->CreateTime = trim($this->xml_parse->CreateTime);
		    $this->MsgType    = trim($this->xml_parse->MsgType);
		}
		

		
		if( !empty($this->xml_parse->EventKey) ){
			$this->event_key = trim( $this->xml_parse->EventKey );
		}
		if(!empty($this->xml_parse->Event )){
			$this->Event = $this->xml_parse->Event;
		}
		
		$this->parseValue();
		
	}
	
	/**
	 * 微信token验证
	 */
 	public function valid()
	{
		$echoStr = $_GET["echostr"];
	
		//valid signature , option
		//if($this->checkSignature()){
		if($echoStr){
			echo $echoStr;
			exit;
		}
			
		//}
	}
// 	private function checkSignature()
// 	{
// 		$signature = $_GET["signature"];
// 		$timestamp = $_GET["timestamp"];
// 		$nonce = $_GET["nonce"];
	
// 		$token = $this->TOKEN;
// 		$tmpArr = array($token, $timestamp, $nonce);
// 		sort($tmpArr);
// 		$tmpStr = implode( $tmpArr );
// 		$tmpStr = sha1( $tmpStr );
	
// 		if( $tmpStr == $signature ){
// 			return true;
// 		}else{
// 			return false;
// 		}
// 	}
	
	
	
	
	
	/**
	 * 解析sample xml 对象 的值
	 */
	public function parseValue(){
		$data = array();	
		if($this->MsgType==='text'){
			$data = $this->params_arr['text'] ;
		}else if($this->MsgType=='image'){
			$data = $this->params_arr['image'] ;
		}else if($this->MsgType=='voice'){
			$data = $this->params_arr['voice'] ;
		}else if($this->MsgType=='video'){
			$data = $this->params_arr['video'] ;
		}else if($this->MsgType=='event'){
			$data = $this->params_arr['event'] ;
			//地理位置
			if($this->Event==$this->event_type_LOCATION){
				$data = $this->params_arr['LOCATION'] ;
			}
		}
	
		foreach ($data as $key=>$value){
			$this->$value = trim($this->xml_parse->$value);
		}
	}
	/**
	 * 获取access_token
	 * @param string $appId
	 * @param string $secrets
	 * @param string $debug 调试
	 * @return mixed|string
	 */
	public function get_access_token($appId=null,$secrets=null,$debug=false){
		$appId 			    = empty($appId)?$this->APPID:$appId;
		$secrets 		    = empty($secrets)?$this->SECRETS : $secrets;
		$access_token_url   = sprintf($this->url_access_token,$appId,$secrets);
		$data 			    = $this->curl_post_simple($access_token_url, null);
		$json_data 		    = json_decode($data);
// 		print_r($json_data);
		if($debug){
			return $json_data;
		}
		$this->access_token = empty($json_data->access_token) ? '' : $json_data->access_token;
		return $this->access_token;
	}
	/*================ repay message start====================*/
	/**
	 * 回复文本
	 * @param string $FromUserName 发送者
	 * @param string $ToUserName 接收者
	 * @param int $time 时间戳
	 * @param string $content 发送内容
	 * @param string $debug 调试
	 * @return string 开启调试返回回复内容
	 */
	public function repayText($FromUserName,$ToUserName,$time,$content,$debug=false){
		$FromUserName     = empty($FromUserName) ? $this->ToUserName : $FromUserName;
		$ToUserName       = empty($ToUserName) ? $this->FromUserName : $ToUserName;;
		$time 			  = empty($time) ? time():$time;
		$data = <<<str
		<xml>
			<ToUserName><![CDATA[{$ToUserName}]]></ToUserName>
			<FromUserName><![CDATA[{$FromUserName}]]></FromUserName>
			<CreateTime>{$time}</CreateTime>
			<MsgType><![CDATA[text]]></MsgType>
			<Content><![CDATA[{$content}]]></Content>
		</xml>
str;
		
		echo $data;
		if($debug){
			return $data;
		}
	}
	/**
	 * 回复图片
	 * @param string $FromUserName 发送者
	 * @param string $ToUserName 接收者
	 * @param int $time 时间戳
	 * @param string $media_id 图片media_id
	 * @param string $debug 调试
	 * @return string 开启调试返回复图片内容
	 * 
	 */
	public function repayImage($FromUserName,$ToUserName,$time,$media_id,$debug=false){
		$FromUserName     = empty($FromUserName) ? $this->ToUserName : $FromUserName;
		$ToUserName       = empty($ToUserName) ? $this->FromUserName : $ToUserName;
		$time = empty($ToUserName) ? time():$time;
		$data = <<<str
		<xml>
			<ToUserName><![CDATA[{$ToUserName}]]></ToUserName>
			<FromUserName><![CDATA[{$FromUserName}]]></FromUserName>
			<CreateTime>{$time}</CreateTime>
			<MsgType><![CDATA[image]]></MsgType>
			<Image>
			<MediaId><![CDATA[{$media_id}]]></MediaId>
			</Image>
		</xml>
str;
		echo $data;
		if($debug){
			return $data;
		}	
	}
	/**
	 * 回复图文消息
	 * @param string $FromUserName 发送者
	 * @param string $ToUserName 接收者
	 * @param int $time 时间戳
	 * @param array $data 数组【$data = array(
 				array(
 				"title"=>"内容1",
 				"description"=>"内容2",
				////跳转地址
 				"url"=>"mjerp.com",
				////图片地址【图文消息的图片链接，支持JPG、PNG格式，较好的效果为大图640*320，小图80*80】
 				"picurl"=>"a.hiphotos.baidu.com/exp/w=500/sign=fda2a43faf51f3dec3b2b964a4eff0ec/314e251f95cad1c8c73290d27f3e6709c83d51bd.jpg"
 			),
 		);】
	 * @param unknown $debug 调试
	 * @return string
	 */
	public function repayImagesTexts($FromUserName,$ToUserName,$time,$data,$debug){
		$FromUserName     = empty($FromUserName) ? $this->ToUserName : $FromUserName;
		$ToUserName       = empty($ToUserName) ? $this->FromUserName : $ToUserName;
		$time = empty($ToUserName) ? time():$time;
		$count = count($data);
		foreach ($data as $key=>$value){
		$items .="
			<item>
				<Title><![CDATA[{$value['title']}]]></Title>
				<Description><![CDATA[{$value['description']}]]></Description>
				<PicUrl><![CDATA[{$value['picurl']}]]></PicUrl>
				<Url><![CDATA[{$value['url']}]]></Url>
			</item>";
		}
		$str = "<xml>
		<ToUserName><![CDATA[{$ToUserName}]]></ToUserName>
		<FromUserName><![CDATA[{$FromUserName}]]></FromUserName>
		<CreateTime>{$time}</CreateTime>
		<MsgType><![CDATA[news]]></MsgType>
		<ArticleCount>{$count}</ArticleCount>
		<Articles>
		{$items}
		</Articles>
		</xml>";
		echo $str;
		if($debug){
			return $str;
		}
	}
	/*================ repay message start====================*/
	/**
	 * 发送文本
	 * @param string $access_token 调用接口凭证
	 * @param string $touser OpenID
	 * @param string $text 内容
	 * @param boolean $debug 调试
	 * @return mixed|boolean 开启调试返回mixed,默认返回 true或者false
	 */
	public function send_text($access_token,$touser,$text,$debug=false){
		
		//调用接口凭证
		$access_token 			= empty($access_token) ? $this->access_token:$access_token;	 
		//普通用户openid
		$data['touser']		 	= empty($touser)? $this->FromUserName : $touser;
		//消息类型，image
		$data['msgtype'] 	  	= 'text';
		//内容
		$data['text']['content']= $text;	
		$url = $this->url_send_message.$access_token;
		$json_data = $this->array_to_json_format($data);
		$return = $this->curl_post_json($url, $json_data);
		$json_return = json_decode($return);
		if($debug){
			$json_return->json_data = $json_data;
			return $json_return;
		}
		if($json_return->errcode==0){
			return true;
		}
		return false;
	}
	/**
	 * 发送图片
	 * 
	 * @param string $access_token 调用接口凭证
	 * @param string $touser 发送用户
	 * @param string $media_id 媒体文件ID
	 * @param boolean $debug 调试【默认关闭】
	 * @return mixed|boolean 成功返回true,失败false 【开启调试返回数组】
	 */
	public function send_image($access_token,$touser,$media_id,$debug=false){
		//调用接口凭证
		$access_token 	= empty($access_token) ? $this->access_token:$access_token;
		$touser 		= empty($touser)?$this->FromUserName : $touser;
		$data['touser'] = $touser;
		$data['msgtype']= "image";
		$data['image']  = array(
			'media_id'=>$media_id
		);
		$json_data = json_encode($data);
		$url = $this->url_send_message.$access_token;
		$return = $this->curl_post_json($url, $json_data);
		$json_data = json_decode($return);
		if($debug){
			$json_data->debug_custom = $url;
			return $json_data;
		}
		if($json_data->errcode==0){
			return true;
		}
		return false;
	}
	/**
	 * 
	 * @param string $access_token 调用接口凭证
	 * @param string $touser 发送用户
	 * @param array $data 发送图文信息【$data = array(
 				array(
 				"title"=>"内容1",
 				"description"=>"内容2",
				////跳转地址
 				"url"=>"mjerp.com",
				////图片地址【图文消息的图片链接，支持JPG、PNG格式，较好的效果为大图640*320，小图80*80】
 				"picurl"=>"a.hiphotos.baidu.com/exp/w=500/sign=fda2a43faf51f3dec3b2b964a4eff0ec/314e251f95cad1c8c73290d27f3e6709c83d51bd.jpg"
 			),
 		);】最多10条
	 * @param boolean $debug 调试【默认关闭】
	 * @return mixed|boolean 成功返回true,失败false 【开启调试返回数组】
	 */
	public function send_images_texts($access_token,$touser,$data,$debug=false){
// 	$data = array(
// 				array(
// 				"title"=>"内容1",
// 				"description"=>"内容2",
				////跳转地址
// 				"url"=>"mjerp.com",
				////图片地址【图文消息的图片链接，支持JPG、PNG格式，较好的效果为大图640*320，小图80*80】
// 				"picurl"=>"a.hiphotos.baidu.com/exp/w=500/sign=fda2a43faf51f3dec3b2b964a4eff0ec/314e251f95cad1c8c73290d27f3e6709c83d51bd.jpg"
// 			),
// 		);
		//调用接口凭证
		$access_token 	= empty($access_token) ? $this->access_token:$access_token;
		$touser 		= empty($touser)?$this->FromUserName : $touser;
		$json_data['touser'] = $touser;
		$json_data['msgtype'] = 'news';
		$json_data['news']['articles'] = $data;
		$json_str = $this->array_to_json_format($json_data);
		$url = $this->url_send_message.$access_token;
		$return = $this->curl_post_json($url, $json_str);
		$return_data = json_decode($return);
		if($debug){
			$return_data->debug_custom_url = $url;
			$return_data->debug_custom_json_str = $json_str;
			return $return_data;
		}
		if($return_data->errcode==0){
			return true;
		}
		return false;
			
	}
	/*================ send message end====================*/
	/*================ menu operation start====================*/
	/**
	 * 创建用户菜单
	 * @param string $access_token
	 * @param string $menu_data 菜单数据
	 * 【button	 是	 一级菜单数组，个数应为1~3个
		sub_button	 否	 二级菜单数组，个数应为1~5个
		type	 是	 菜单的响应动作类型，目前有click、view两种类型
		name	 是	 菜单标题，不超过16个字节，子菜单不超过40个字节
		key	 click类型必须	 菜单KEY值，用于消息接口推送，不超过128字节
		url	 view类型必须	 网页链接，用户点击菜单可打开链接，不超过256字节
	 * @param string $debug 调试
	 * @return mixed|boolean 开启调试返回数组，创建成功true,失败false】
	 */
	public function create_menu($access_token,$menu_data,$debug=false){
		$access_token = empty($access_token)?$this->access_token : $access_token;
		$url = $this->url_create_menu.$access_token;
		$json_str = $this->array_to_json_format($menu_data);
		$json_str = $this->curl_post_json($url, $json_str);
		$json_return = json_decode($json_str);
		if($debug){
			$json_return->debug_custom_json_str = $json_str;
			return $json_return;
		}
		if($json_return->errcode==0){
			return true;
		}
		return false;
	}
	
	public function create_menu_json($access_token,$menu_data_json,$debug=false){
		$access_token = empty($access_token)?$this->access_token : $access_token;
		$url = $this->url_create_menu.$access_token;
		//$json_str = $this->array_to_json_format($menu_data_json);
		$json_str = $this->curl_post_json($url, $menu_data_json);
		$json_return = json_decode($json_str);
		if($debug){
			$json_return->debug_custom_json_str = $json_str;
			return $json_return;
		}
		if($json_return->errcode==0){
			return true;
		}else{
			return $json_return;
		}

	}
	/**
	 * 删除菜单
	 * @param unknown $access_token
	 * @return number|mixed 返回0删除成功,失败返回一个对象
	 */
	public function delete_menu($access_token){
		$access_token  = $access_token ? $access_token : $this->access_token;
		$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=$access_token";
		$resulte = $this->curl_post_simple($url, null);
		$resulte_obj = json_decode($resulte);
		if($resulte_obj->errcode==0){
			return 0;
		}else{
			return $resulte_obj;
		}
	}
	
	/*================ menu operation end====================*/
	
	/*================ upload or download media start====================*/
	public function media_upload($file_path,$access_token,$type,$debug=false){
		$access_token = empty($access_token)?$this->access_token : $access_token;
		$type 		  = empty($type) ? 'image' : $type;
		$url 		  = sprintf($this->url_upload_media,$access_token,$type);
		$data		  = array('file'=>'@'.$file_path);
		$json_str 	  = $this->curl_post_simple($url, $data);
		$json_data    = json_decode($json_str);
		if($debug){
			$json_data['debug_custom'] = $data;
		}
		if(empty($json_data->media_id)){
			return false;
		}
		return $json_data;
	}
	/*================ upload or download media end====================*/

	/*================ user oauth operation start ====================*/
	
	/**
	 * 生成oauch2认证地址
	 * @param string $appid 公众号的唯一标识
	 * @param string $redirect_uri [urlencode($str)] 授权后重定向的回调链接地址
	 * @param bealoon $scope  false 不弹出授权  true 弹出授权
	 * @param string $state 重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值
	 * @return string oauch2 跳转地址
	 */
	public function oauth2_url($appid,$redirect_uri,$scope=false,$state=''){
		
		//公众号的唯一标识
		$appid         = empty($appid)?$this->APPID:$appid;
		//授权后重定向的回调链接地址，请使用urlencode对链接进行处理
		$redirect_uri  = urlencode($redirect_uri);
		//请填写code
		$response_type = 'code';
		//snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），
		//snsapi_userinfo （弹出授权页面，
		//可通过openid拿到昵称、性别、所在地。并且，即使在未关注的情况下，只要用户授权，也能获取其信息）
		$scope 		   = $scope==true?'snsapi_userinfo':'snsapi_base';
		//重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值
		$state 		   = empty($state) ? 'STATE': $state;
		//appid=$APPID&redirect_uri=$redirect_uri&
		//response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
		
		return sprintf($this->oauth2Url,$appid,$redirect_uri,$response_type,$scope,$state);
	}
	/**
	 * 获取用户数据
	 * subscribe	 用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息。
		openid	 用户的标识，对当前公众号唯一
		nickname	 用户的昵称
		sex	 用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
		city	 用户所在城市
		country	 用户所在国家
		province	 用户所在省份
		language	 用户的语言，简体中文为zh_CN
		headimgurl	 用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空
		subscribe_time	 用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间
	 * @param string $access_token 调用接口凭证
	 * @param string $openid 普通用户的标识，对当前公众号唯一
	 * @param string $lang 国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
	 * @param boolean $debug 开启调试
	 * @return 成功返回 array 失败返回 false 开启调试返回 错误信息array 
	 */
	public function user_info($access_token,$openid,$lang='zh_CN',$debug=false){
		//调用接口凭证
		$access_token = empty($access_token) ? $this->access_token : $access_token;
		//普通用户的标识，对当前公众号唯一
		$openid       = empty($openid) ? $this->ToUserName : $openid;
		//国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
		$lang		  = empty($lang) ? 'zh_CN' : $lang;
		$this->userInfoUrl = sprintf($this->userInfoUrl,$access_token,$openid,$lang);
		$data = $this->curl_post_simple($this->userInfoUrl,null);
		$json_data = json_decode($data);
		if($debug){
			$json_data->debug_custom = $this->userInfoUrl;
			return $json_data;
		}
		if($json_data->errcode==0){
			return $json_data;
		}
		return false;
	}
	
	/**
	 * 用户认证后获取code
	 */
	public function oautch_get_code(){
		$this->oauth2_code = $_GET['code'];
		return $this->oauth2_code;
	}
	/**
	 * 登录授权后获取 授权token
	 * access_token	 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
		expires_in	 access_token接口调用凭证超时时间，单位（秒）
		refresh_token	 用户刷新access_token
		openid	 用户唯一标识，请注意，在未关注公众号时，用户访问公众号的网页，也会产生一个用户和公众号唯一的OpenID
		scope	 用户授权的作用域，使用逗号（,）分隔
	 * @param string $appid 公众号的唯一标识
	 * @param string $secret 公众号的appsecret
	 * @param string $code 第一步获取的code参数
	 * @param boolean $debug 默认 false关闭调试 true 开启
	 * @return 成功返回 array 失败返回 false 开启调试返回 错误信息array 
	 */
	public function oautch_access_token($appid,$secret,$code,$debug=false){
		//调用接口凭证
		$access_token = empty($access_token) ? $this->access_token : $access_token;
		//普通用户的标识，对当前公众号唯一
		$appid       = empty($appid) ? $this->APPID : $appid;
		//公众号的appsecret
		$secret       = empty($secret) ? $this->SECRETS : $secret;
		$this->oauth2_code = empty($this->oauth2_code)?$_GET['code'] : $this->oauth2_code;
		//第一步获取的code参数
		$code= empty($code)? $this->oauth2_code : $code;
		$this->oauth2_access_token_url = sprintf($this->oauth2_access_token_url,$appid,$secret,$code);
// 		exit($this->oauth2_access_token_url);
		//$data = file_get_contents($this->oauth2_access_token_url);
		$data = $this->curl_post_simple($this->oauth2_access_token_url, null);
		$json_data = json_decode($data);
		if($debug){
			$json_data->debug_custom = $this->oauth2_access_token_url;
			return $json_data;
		}
		if(isset($json_data->errcode)&&$json_data->errcode!=0){
		    return false;
		}
		return $json_data;
		
	}
	
	/**
	 * 刷新网页授权token
	 * 
	 * access_token	 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
		expires_in	 access_token接口调用凭证超时时间，单位（秒）
		refresh_token	 用户刷新access_token
		openid	 用户唯一标识
		scope	 用户授权的作用域，使用逗号（,）分隔	
	 * @param string $appid 公众号的唯一标识
	 * @param string $refresh_token  填写通过access_token获取到的refresh_token参数
	 * @param boolean $debug 默认 false关闭调试 true 开启
	 * @return 成功返回 array 失败返回 false 开启调试返回 错误信息array 
	 */
	public function oauth2_refresh_token($appid,$refresh_token,$debug=false){
		//appid	 是	 公众号的唯一标识
		$appid = empty($appid) ? $this->APPID : $appid;
		//grant_type	 是	 填写为refresh_token
		$grant_type = 'refresh_token';
		//refresh_token	 是	 填写通过access_token获取到的refresh_token参数
		$refresh_token;
		$this->oauth2_refresh_token_url = sprintf($this->oauth2_refresh_token_url,$appid,$grant_type,$refresh_token);
		$data = file_get_contents($this->oauth2_refresh_token_url);
		$json_data = json_decode($data);
		if($debug){
			$json_data->debug_custom = $this->oauth2_refresh_token_url;
			return $json_data;
		}
		if($json_data->errcode==0){
			return $json_data;
		}
		return false;
	}
	
	/*================ user oauth operation end ====================*/
	
	/*================ lib start ====================*/
	function curl_post_simple($url,$data){ // 模拟提交数据函数
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$tmpInfo = curl_exec($curl); // 执行操作
		if (curl_errno($curl)) {
			echo 'Errno'.curl_error($curl);//捕抓异常
		}
		curl_close($curl); // 关闭CURL会话
		return $tmpInfo; // 返回数据
	}
	function curl_post_json($url,$json_data){ // 模拟提交数据函数
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		        'Content-Type: application/json',
		        'Content-Length: ' . strlen($json_data))
		);
		$tmpInfo = curl_exec($curl); // 执行操作
		if (curl_errno($curl)) {
			echo 'Errno'.curl_error($curl);//捕抓异常
		}
		curl_close($curl); // 关闭CURL会话
		return $tmpInfo; // 返回数据
	}
	/**
	 * 生成json
	 * @param unknown $array
	 * @return boolean|string
	 */
	function array_to_json_format( $array ){
		if( !is_array( $array ) ){
			return false;
		}
	
		$associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
		if( $associative ){
	
			$construct = array();
			foreach( $array as $key => $value ){
	
				// We first copy each key/value pair into a staging array,
				// formatting each key and value properly as we go.
	
				// Format the key:
				if( is_numeric($key) ){
					$key = "key_$key";
				}
				$key = '"'.addslashes($key).'"';
	
				// Format the value:
				if( is_array( $value )){
					$value = $this->array_to_json_format( $value );
				} else if( !is_numeric( $value ) || is_string( $value ) ){
					$value = '"'.addslashes($value).'"';
				}
	
				// Add to staging array:
				$construct[] = "$key: $value";
			}
	
			// Then we collapse the staging array into the JSON form:
			$result = "{ " . implode( ", ", $construct ) . " }";
	
		} else { // If the array is a vector (not associative):
	
			$construct = array();
			foreach( $array as $value ){
	
				// Format the value:
				if( is_array( $value )){
					$value = $this->array_to_json_format( $value );
				} else if( !is_numeric( $value ) || is_string( $value ) ){
					$value = '"'.addslashes($value).'"';
				}
	
				// Add to staging array:
				$construct[] = $value;
			}
	
			// Then we collapse the staging array into the JSON form:
			$result = "[ " . implode( ", ", $construct ) . " ]";
		}
	
		return $result;
	}
	
	/*================ lib end====================*/
	
}