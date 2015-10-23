<?php 
namespace common\z;

use common;
/**
 * 权限验证
 * @author z
 *
 */
class ZPermissionValidation{
    /**
     * 权限验证
     * @param string $module 模块
     * @param string $controller 控制器
     * @param string $action    动作
     * @return boolean true验证权限成功|false验证权限失败
     */
    public function valid($module,$controller,$action){
        //设置权限
        $permission_action = $module.'/'.$controller.'/'.$action;
        $permission_controller = $module.'/'.$controller;
        $permission_module = $module;
//         ZCommonFun::print_r_debug($permission_action,'action','action',__LINE__,__FILE__);
        
        //角色权限
        $z_ZRolePermission = new ZRolePermission();
        //获取当前角色权限
        $permisson = $z_ZRolePermission->getNowRolePermission(); 
//         ZCommonFun::print_r_debug($permisson,'permission-print','permission-print',__LINE__,__FILE__);
       
        //有动作权限
        if( isset($permisson[ZRolePermission::action]) && in_array($permission_action, $permisson[ZRolePermission::action] ) ){            
            $operation = true;
        }//控制器权限
        else if( isset($permisson[ZRolePermission::controller]) && in_array($permission_controller, $permisson[ZRolePermission::controller] ) ){
            $operation = true;
        }//模块权限
        else if( isset($permisson[ZRolePermission::module]) && in_array($permission_module, $permisson[ZRolePermission::module] ) ){
            $operation = true;
        }//没有权限
        else{
            $operation = false;
        }
    }
}