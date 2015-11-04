<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question_options".
 *
 * @property integer $qo_id
 * @property integer $question_id
 * @property string $table
 * @property integer $table_id
 * @property string $option_label
 * @property string $option_image
 * @property integer $max_len
 * @property string $value_describe
 * @property integer $uid
 * @property integer $option_total_count
 * @property string $created
 * @property double $option_score
 * @property double $option_total_score
 * @property integer $sort
 * @property integer $c_uid
 * @property integer $skip_question
 */
class QuestionOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'table_id', 'max_len', 'uid', 'option_total_count', 'sort', 'c_uid','skip_question'], 'integer'],
            [['created'], 'safe'],
            [['option_score', 'option_total_score'], 'number'],
            [['table'], 'string', 'max' => 32],
            [['option_label', 'option_image', 'value_describe'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qo_id' => '选项id',
            'question_id' => '问题id',
            'table' => '表',
            'table_id' => '表id',
            'option_label' => '选项标注',
            'option_image' => '图片',
            'max_len' => '多少字以内,0不限制',
            'value_describe' => 'Value Describe',
            'uid' => '用户id',
            'option_total_count' => '本选项选择次数',
            'created' => '创建时间',
            'option_score' => '选项得分',
            'option_total_score' => '选择总得分',
            'sort' => '排序',
            'c_uid' => '问题创建者',
            'skip_question'=>'跳转问题',
        ];
    }
}
