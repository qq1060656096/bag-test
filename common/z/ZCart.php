<?php 
namespace common\z;
/**
 * 购物车
 * @author pc
 *
 */
class ZCart{
    /**
     * 购物车名字
     * @var string
     */
    private $_cartName = 'buycart';
    /**
     * 错误信息
     * @var string
     */
    public  $error = '';
    /**
     * 购物车数据
     * @var mixed
     */
    public $cartData = null;
    
    /**
     * 购物车存放类型 
     * @var boolean true存放到session , false 存放到 cookie
     */
    public $saveTypeIsSession = true;
    
    /**
     * 获取购物车名
     * @return string
     */
    public function getCartName(){
        $this->_cartName;
    }
    /**
     * 购物车添加
     * @param mixed $id
     * @param mixed $data
     */
    public function cartAdd($id,$data){
        //session操作
        if($this->saveTypeIsSession){
            $_SESSION[$this->getCartName()][$id]=$data;
        }//cookie 操作
        else{
            $_COOKIE[$this->getCartName()][$id]=$data;
        }
    }
    /**
     * 购物车删除商品
     * @param mixed $id
     */
    public function cartRemove($id){
        //session操作
        if($this->saveTypeIsSession){
            unset( $_SESSION[$this->getCartName()][$id]);
        }//cookie 操作
        else{
            unset( $_COOKIE[$this->getCartName()][$id] );
        }
    }
    /**
     * 获取购物车数据
     */
    public function getMyCartData(){
        //session操作
        if($this->saveTypeIsSession){
            return $_SESSION[$this->getCartName()];
        }//cookie 操作
        else{
            return $_COOKIE[$this->getCartName()];
        }
    }
    /**
     * 清空购物车
     */
    public function clear(){
        //session操作
        if($this->saveTypeIsSession){
            unset( $_SESSION[$this->getCartName()] );
        }//cookie 操作
        else{
            unset( $_COOKIE[$this->getCartName()] );
        }
    }
    
}