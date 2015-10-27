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
class WeiBo extends \SaeTOAuthV2{
    /**
     * @ignore
     */
    protected function id_format(&$id) {
        if ( is_float($id) ) {
            $id = number_format($id, 0, '', '');
        } elseif ( is_string($id) ) {
            $id = trim($id);
        }
    }
    /**
     * 获取用户id
     */
    function get_uid()
    {
        return $this->get( 'account/get_uid' );
    }
    /**
     * 获取用户信息
     * @param integer $uid
     * @return mixed
     */
    function show_user_by_id( $uid )
    {
        $params=array();
        if ( $uid !== NULL ) {
            $this->id_format($uid);
            $params['uid'] = $uid;
        }
    
        return $this->get('users/show', $params );
    }
}