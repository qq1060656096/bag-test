<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property integer $a_id
 * @property string $table
 * @property integer $table_id
 * @property integer $uid
 * @property integer $question_id
 * @property integer $qo_id
 * @property string $value
 * @property string $value_data
 * @property double $answer_score
 * @property integer $au_id
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_id', 'uid', 'question_id', 'qo_id', 'au_id'], 'integer'],
            [['value', 'value_data'], 'string'],
            [['answer_score'], 'number'],
            [['table'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'a_id' => '回答编号',
            'table' => '表',
            'table_id' => '表id',
            'uid' => '用户id',
            'question_id' => '问题id',
            'qo_id' => '选项id',
            'value' => '值',
            'value_data' => '附加数据',
            'answer_score' => '回答问题得分',
            'au_id' => '回答者id',
        ];
    }
}
