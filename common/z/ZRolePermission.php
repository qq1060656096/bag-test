<?php 
namespace common\z;

class ZRolePermission{
    /**
     * 动作
     * @var string
     */
    const action        = 'action';
    /**
     * 控制器
     * @var string
     */
    const controller    = 'controller';
    /**
     * 模块
     * @var string
     */
    const module        = 'module';
    
    /**
     * 管理员权限
     * @var integer
     */
    const roleAdmin = 1;
    
    /**
     * 匿名权限
     * @var integer
     */
    const roleAnonymity=0;
    
    /**
     * 获取当前用户权限
     * @return array
      Array
    (
        [action] => Array
            (
                [0] => public0/order/create
    
            )
    
        [controller] => Array
            (
                [0] => public0/order
            )
    
        [module] => Array
            (
                [0] => public0
            )
    
    )
     */
    function getNowRolePermission(){
        $role_id=1;
        return $this->getRolePermission($role_id);
    }
    /**
     * 获取指定角色权限
     * @param integer $role_id
     * @return array
     * Array
    (
        [action] => Array
            (
                [0] => public0/order/create
    
            )
    
        [controller] => Array
            (
                [0] => public0/order
            )
    
        [module] => Array
            (
                [0] => public0
            )
    
    )
     */
    public function getRolePermission($role_id){
        switch ( $role_id ){
            //管理员权限
            case self::roleAdmin:
                return $this->getRolePermission1();
                break;
            //匿名权限
            default :
                return $this->getRolePermission0();
                break;
        }
       
    }
    
    
    
    /**
     * 匿名用户权限
     */
    public function getRolePermission0(){
        $permission = [
            //动作优先1 [module名/controller名/动作名]
            self::action.'' =>[
                //'test/test/index',
                
            ],
            //控制器2 [module名/controller名]
            self::controller.''=>[
                //'test/test',
            ],
            //模块权限3 [module名]
            self::module.''=>[
                //'test'
            ],
        ];
 
        return  $permission;
    }
    
    /**
     * 管理员权限
     */
    public function getRolePermission1(){
        $permission = [
            //动作优先1 [module名/controller名/动作名]
            self::action.'' =>[
                //                 'seller/goods/list',
                'public0/order/create',//购物车
                'public0/buy-json/buy-cart-order-discount-add',//折扣新增
                'public0/buy-json/buy-cart-goods-add',//商品新增数量
                'public0/buy/buy-cart-goods-delete',//商品删除
                'public0/goods/buy-list',//购物车商品列表
                'seller/goods/list',//商品列表
                'public0/order/my',//我的销售
            ],
            //控制器2 [module名/controller名]
            self::controller.''=>[
    
            ],
            //模块权限3 [module名]
            self::module.''=>[
            ],
        ];
        ZCommonFun::print_r_debug($permission);
        return  $permission;
    }
}