<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property integer $question_id
 * @property integer $uid
 * @property string $label
 * @property integer $qt_id
 * @property string $q_describe
 * @property integer $sort
 * @property string $table
 * @property integer $table_id
 * @property string $question_valid
 * @property string $question_data
 * @property integer $question_total_count
 * @property integer $use_option_count
 * @property string $right_option
 * @property string $create_time
 * @property string $update_time
 * @property double $question_score
 * @property double $question_total_score
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'qt_id', 'sort', 'table_id', 'question_total_count', 'use_option_count'], 'integer'],
            [['question_data', 'right_option'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['question_score', 'question_total_score'], 'number'],
            [['label', 'q_describe', 'question_valid'], 'string', 'max' => 255],
            [['table'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'question_id' => '问题编号',
            'uid' => '用户id',
            'label' => '标注',
            'qt_id' => '问题类型',
            'q_describe' => '问题描述',
            'sort' => 'Sort',
            'table' => '表',
            'table_id' => '表id',
            'question_valid' => '验证器',
            'question_data' => '附加自定义数据',
            'question_total_count' => '本题回答次数',
            'use_option_count' => '最多选择多少个选项',
            'right_option' => '正确选项',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'question_score' => '问题得分',
            'question_total_score' => '问题总分',
        ];
    }
}
