<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "answer_survey_resulte".
 *
 * @property integer $answer_sr_id
 * @property integer $sr_id
 * @property string $name
 * @property string $value
 * @property integer $uid
 * @property integer $s_id
 * @property string $intro
 * @property double $score_min
 * @property double $score_max
 * @property string $image
 * @property integer $comment_count
 * @property integer $visit_count
 */
class AnswerSurveyResulte extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer_survey_resulte';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sr_id'], 'required'],
            [['sr_id', 'uid', 's_id','visit_count','comment_count'], 'integer'],
            [['intro'], 'string'],
            [['score_min', 'score_max'], 'number'],
            [['name', 'value', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'answer_sr_id' => '回答内容id',
            'sr_id' => 'Sr ID',
            'name' => 'Name',
            'value' => 'Value',
            'uid' => 'Uid',
            's_id' => '调查id',
            'intro' => 'Intro',
            'score_min' => '最小分数',
            'score_max' => '最大分数',
            'image' => 'Image',
            'visit_count',
            'comment_count',
        ];
    }
    /**
     * 设置评论次数
     */
    public function setcomment_count($id){
        $model = AnswerSurveyResulte::findOne($id);
        if($model){
            $model->comment_count++;
            $model->save();
        }
    
    }
    /**
     * 设置浏览次数
     */
    public function setvisit_count($id){
        $model = AnswerSurveyResulte::findOne($id);
        if($model){
            $model->visit_count++;
            $model->save();
        }
    }
}
