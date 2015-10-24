<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "survey_resulte".
 *
 * @property integer $sr_id
 * @property string $name
 * @property string $value
 * @property integer $uid
 * @property integer $s_id
 * @property int $score_min
 * @property int $score_max
 */
class SurveyResulte extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'survey_resulte';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 's_id'], 'integer'],
            [['score_min', 'score_max'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sr_id' => 'Sr ID',
            'name' => 'Name',
            'value' => 'Value',
            'uid' => 'Uid',
            's_id' => '调查id',
            'score_min'=>'',
            'scpre_max'=>''
        ];
    }
    
    /**
     * 获取调查所有id
     * @param unknown $sid
     */
    public function getAll($sid){
        $find = $this->find();
        $models = $find->where(['s_id'=>$sid])->all();
        return $models;
    }
    
    /**
     * 测试结果
     * @param unknown $sid
     * @param unknown $name
     * @param unknown $birth
     * @return unknown
     */
    public function getStep1Result($sid,$name,$birth){
        $models = $this->getAll($sid);
        $count = count($models);
        $tem = $name.$birth;
        $number = $this->getStrAsciiCode($name);
        $number = abs($number);
        $number = sprintf("%.0f", $number);;       
        $index = $number%$count;     
        return $models[$index];
    }
    
    /**
     * 获取字符串ascii码
     * @param unknown $str
     * @return number
     */
    function getStrAsciiCode($str){
        if(is_array($str) )
            $arr  = $str;
        else 
            $arr = str_split($str);
        $number = 0;
        foreach ($arr as $char){
            $number+=ord($char);
        }
        return $number;
    }
    
    
    /**
     * 测试结果2
     * @param unknown $sid
     * @param unknown $score
     * @return unknown
     */
    public function getStep2Result($sid,$score){
        $models = $this->getAll($sid);
        foreach ($models as $key=>$model){
            //$this->score_max = $this->score_min;
            if($model->score_min>=$score && $score<= $model->score_max ){
                return $model;
            }
        }
        return isset($models[0]) ? $models[0] : null;
    }
}
