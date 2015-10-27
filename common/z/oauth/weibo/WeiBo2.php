<?php 
namespace common\z\oauth\weibo;
include_once( dirname(__FILE__).'/libweibo-master/config.php' );


if( !class_exists('OAuthException') ){
    include_once(dirname(__FILE__). '/libweibo-master/saetv2.ex.class.php' );
}
if( !class_exists('SaeTOAuthV2') ){
    include_once(dirname(__FILE__). '/libweibo-master/saetv2.ex.class.php' );
}
if( !class_exists('SaeTClientV2') ){
    include_once(dirname(__FILE__). '/libweibo-master/saetv2.ex.class.php' );
}

/**
 * 微博登录
 * @author pc
 *
 */
class WeiBo2 extends \SaeTClientV2{
    
    
}