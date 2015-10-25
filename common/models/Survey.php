<?php

namespace common\models;

use Yii;
use common\z\ZCommonFun;

/**
 * This is the model class for table "survey".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $tax
 * @property integer $uid
 * @property string $title
 * @property string $intro
 * @property integer $theme
 * @property integer $theme_mobile
 * @property integer $is_publish
 * @property string $created
 * @property string $start_date
 * @property string $end_date
 * @property integer $answer_count
 * @property integer $visit_count
 * @property string $pass
 * @property integer $is_public
 * @property integer $is_statistics_public
 * @property integer $max_answer_count
 * @property integer $is_share_template
 * @property integer $answer_total_time
 * @property integer $answer_average_time
 * @property integer $answer_limit_time
 * @property double $reward_total
 * @property double $reward_average
 * @property integer $reward_count
 * @property integer $front_img
 */
class Survey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'survey';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['front_img','type','tax', 'uid', 'theme', 'theme_mobile', 'is_publish', 'answer_count', 'visit_count', 'is_public', 'is_statistics_public', 'max_answer_count', 'is_share_template', 'answer_total_time', 'answer_average_time', 'answer_limit_time', 'reward_count'], 'integer'],
            [['created', 'start_date', 'end_date'], 'safe'],
            [['reward_total', 'reward_average'], 'number'],
    
            [['title', 'intro', 'pass'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'type' => '类型',
            'tax' => '分类',
            'uid' => 'Uid',
            'title' => '标题',
            'intro' => '介绍',
            'theme' => '主题',
            'theme_mobile' => 'Theme Mobile',
            'is_publish' => '是否发布',
            'created' => '创建时间',
            'start_date' => '开始时间',
            'end_date' => '结束时间',
            'answer_count' => '回答次数',
            'visit_count' => '访问次数',
            'pass' => '密码',
            'is_public' => '是否公开',
            'is_statistics_public' => '是否公开统计信息',
            'max_answer_count' => '最好回答数,0不限制，大于0限制',
            'is_share_template' => '是否共享到模板库',
            'answer_total_time' => '答题总时间',
            'answer_average_time' => '答题平均时间',
            'answer_limit_time' => '答题时间限制',
            'reward_total' => '总打赏',
            'reward_average' => '平均打赏',
            'reward_count' => '打赏次数',
            'front_img'=>'封面图片',
        ];
    }
    /*
     * 获取问题梳理
     */
    public function getQuestionCount($survey_id){
        $condition['table_id'] = $survey_id;
        //问题数量
        return  Question::find()->where($condition)->orderBy([])->count();
    }
    /**
     * 分页查找测试问题
     * @param integer $survey_id
     * @param integer $limit
     * @param integer $offset
     * @return array
     */
    public function findOneQuestion($survey_id,$limit,$offset){
        
        $model_Question = new Question();
        $model_QuestionOptions = new QuestionOptions();
        $condition['table_id'] = $survey_id;
        //问题数量
        $data['count'] = Question::find()->where($condition)->orderBy([])->count();
        //问题内容
        $data['question'] = null;
        //问题选项
        $data['options'] = null;
        if($data['count']>0){
            
            $model_Question = $model_Question->find()->where($condition)->limit($limit)->offset($offset)->one();
//             ZCommonFun::print_r_debug($model_Question);
            if( $model_Question){
                $data['question'] = $model_Question;
                $condition = null;
                $condition['question_id'] = $model_Question->question_id;
                $a_QuestionOptions = $model_QuestionOptions->find()->where($condition)->orderBy([])->all();
//                 ZCommonFun::print_r_debug($a_QuestionOptions);
                //没有问题就没有选项
                if(!isset($a_QuestionOptions[0]))
                    $a_QuestionOptions=[];
                $data['options'] = $a_QuestionOptions;
               
            }
        }
        return $data;
    }
    /**
     * 获取调查问题
     * @param unknown $survey_id
     * @return multitype:
     */
    public function FindAllQuestionsOptions($survey_id){
        $model_Question = new Question();
        $model_QuestionOptions = new QuestionOptions();
        $condition['table_id'] = $survey_id;
        
       
        $a_Question = $model_Question->find($condition)->orderBy([])->all();
        
        $a_QuestionOptions = $model_QuestionOptions->find($condition)->orderBy([])->all();
        
        $a_Question? null :$a_Question=[];
        $a_QuestionOptions? null :$a_QuestionOptions=[];
        $a_options = [];
        $question_total_count=0;
        $question_total_score=0;
        //没有问题就没有选项
        if(!isset($a_Question[0]))
            $a_QuestionOptions=[];
        else{
            foreach ($a_Question as $key=>&$row){
                $question_total_count++;
                foreach ($a_QuestionOptions as $key2=>&$row2){
                    if($row->question_id==$row2->question_id){
                        $a_options[$key][] = $row2;
                        $question_total_score+=$row2->option_score;
                    }
                    
                }
//                 isset($a_Question[$key]['options'][0])? null :$a_Question[$key]['options']=[];
            }
        } 
        $data['questions'] = $a_Question;
        $data['options']   = $a_options;
        $data['question_total_count'] = $question_total_count;
        $data['question_total_score'] = $question_total_score;
        return $data;
    }
    /**
     * 设置回答数量
     * @param unknown $id
     */
    public function setAnswerCount($id){
        $condition['id'] = $id;
        $model = $this->find()->where($condition)->one();
        $this->answer_count = $this->randCount($this->answer_count);
        $this->save();
    }
    
    public function randCount($count){
        $rand = rand(1, 9);
        $rand<=8?$count++:$count+=10;
        return $count;
    }
    
    public function  getImages(){
        return $this->hasOne(Images::className(),  ['id'=>'front_img']);
    }
}
