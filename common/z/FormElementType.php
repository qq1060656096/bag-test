<?php
namespace common\z;

/**
 * 获取表单元素类型
 * @author pc
 *
 */
class FormElementType{
    /**
     * 普通文本框
     * @var string
     */
    const typeText = 'text';
    
    /**
     * 多行文本框
     * @var string
     */
    const typeTextArea = 'textarea';
    
    /**
     * 普通下拉列表
     * @var string
     */
    const typeDropdownlist = 'dropdownlist';
    
    /**
     * 矩阵下拉列表
     * @var string
     */
    const typeDropdownlistMatrix = 'dropdownlistMatrix';
    
    /**
     * 日期下拉列表
     * @var string
     */
    const typeDropdownlistDate = 'dropdownlistDate';
    
    
    /**
     * 地址下拉列表
     * @var string
     */
    const typeDropdownlistAddress = 'dropdownlistAddress';
    
    /**
     * 普通单选按钮
     * @var string
     */
    const typeRadio = 'readio';
    /**
     * 图片阵单选按钮
     * @var string
     */
    const typeRadioImage = 'readioImage';
    
    /**
     * 多选按钮
     * @var string
     */
    const typeMult = 'mult';
    
    /**
     * 矩阵多选按钮
     * @var string
     */
    const typeMultMatrix = 'multMatrix';
    
    /**
     * 多选图片按钮
     * @var string
     */
    const typeMultImageMatrix = 'multImageMatrix';
    
   
    public function cache(){
        
    }
}