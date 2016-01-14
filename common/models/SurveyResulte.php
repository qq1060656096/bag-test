<?php

namespace common\models;
use common\models\Survey;
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
 * @property string $image
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
            [['name', 'value','intro','image'], 'string', 'max' => 255]
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
            'scpre_max'=>'',
            'image'=>'图片'
        ];
    }
    
    /**
     * 获取调查id所有结果
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
        $number = sprintf("%.0f", $number);
        if($count<1)
            return null;
            
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
    
    /**
     * 分页查找测试结果
     * @param integer $survey_id
     * @param integer $limit
     * @param integer $offset
     * @param boolean $question 是否查找问题,默认true
     * @param boolean $SurveyResulte_lis_multi 是否多条
     * @return array
     */
    public function findOneSurveyResulte($survey_id,$limit,$offset,$question = true,$SurveyResulte_lis_multi=false){
    
        $model_SurveyResulte = new SurveyResulte();
        $model_QuestionOptions = new QuestionOptions();
        $condition['s_id'] = $survey_id;
        //结果数量
        $data['count'] = SurveyResulte::find()->where($condition)->orderBy([])->count();
        //结果内容
        $data['SurveyResulte'] = [];
        //问题
        $data['question'] = [];
        if($data['count']>0){
            
            $query = $model_SurveyResulte->find()->where($condition)->limit($limit)->offset($offset);
            $model_SurveyResulte = $SurveyResulte_lis_multi ? $query->all() : $query->one();
            $data['SurveyResulte'] = $model_SurveyResulte;
            $data['question']      = $question ?  (new Survey())->FindAllQuestionsOptions($survey_id) : [];
        }
        return $data;
    }
    
    public static function getImageUrl($model){
        $image = !empty( $model->image ) ? UPLOAD_DIR.$model->image : DEFAULT_IMAGE;
        $image = Yii::$app->request->baseUrl.$image;
        return $image;
    }
}
