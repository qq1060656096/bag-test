<?php 
namespace common\z;

/**
 * 
 * @author z
 *
 */
class FormElementGeneration2{
    
    public $nameQuestion = 'question';
    public $nameQuestionOptionLabel = 'question-label';
    public $nameQuestionOptionImage = 'question-image';
    public $nameQuestionOptionScore = 'question-Score';
    /**
     * 默认替换字符串
     * @var string
     */
    public $replaceString = '{template}';
    /**
     * 问题包裹clss
     * @var string
     */
    public $classQuestionWrap = 'question-wrap';
    
    /**
     * 默认问题选项class
     * @var string
     */
    public $classQuestionOptionWap = 'question-option-wrap';
    
    /**
     * 问题选项 class
     * @var string
     */
    public $classQuestionOptionItem   = 'question-option-item';
    
    /**
     * 单个添加
     * @var string
     */
    public $question_option_add    = 'question-option-add';
    /**
     *选项批量添加
     * @var string
     */
    public $question_option_add_mult    = 'question-option-add-mult';
    /**
     * 选项得分
     * @var string
     */
    public $question_option_score = 'question-option-score';
    
    /**
     * 获取模板
     * @param string $type 本类中的type前缀开始的常量
     * @param string html字符串
     */
    public static function getTemplate($type){
        $html = '';
        switch ($type){
            case FormElementType::typeText:
                break;
                
            case FormElementType::typeDropdownlist:
                
            break;
        }
        return $html;
    }
    /**
     * 获取wrap
     * @return string
     */
    public function wrap($class){
        return '<div class="{$class}">'.$this->replaceString.'</div>';
    }
    
    /**
     * 获取问题wrap
     * @param string $calss
     * @return string
     */
    public function QuestionWrap($calss=''){
        $calss ? $class = $this->classQuestionWrap : null;
        return $this->wrap($class);
    }
    /**
     * 获取选项wrap
     * @param string $calss
     * @return string
     */
    public function QuestionOptionWrap($calss=''){
        $calss ? $class = $this->classQuestionOptionWap : null;
        return $this->wrap($class);
    }
    
    public function QuestionOptionHtml(){
        
    }
    /**
     * 获取option html 
     * @param string $name
     * @param  array $option_values
     * @return string
     */
    public function questionOptionWrap($name,$option_values){
        $html = '';
        if( isset( $option_values[0] ) && is_array($option_values)){
            foreach ( $option_values as $key=>$value ){
                ;
            }
        }
        return $html;
    }
    
    public function getdropdownlist($name='question',$option_name='question-option',$items){
        $html = '';
        //问题class
        $question_class = $this->question_class;
        //选项class
        $question_option_class = $this->question_option_class;
        //选项包裹元素
        $question_option_item = $this->question_option_item;
            
        $question_option_add = $this->question_option_add;
        $question_option_add_mult = $this->question_option_add_mult;
        
        
        $question_option_score = $this->question_option_score;
        
        $items_html = '';
        foreach ($items as $key=>$value ){
            $items_html .= <<<str
<div class="{$question_option_item} ">
    <input type="text" value="'.$value.'"/>
    <select class="">
    </select>
</div>        
str;
    
        }
        $html = <<<str
<div class="{$question_class}">
    <input name="{$name}"/>
    <div class="{$question_option_class}">
        {$items_html}
        <button class="{$question_option_add}" type="button" title="增加选项">增加选项</button>
        <button class="{$question_option_add_mult}" type="button" title="批量添加选项">批量添加选项</button>
    </div>
</div>
str;
                
        return $html;
    }
}