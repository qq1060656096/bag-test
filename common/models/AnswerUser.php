<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "answer_user".
 *
 * @property integer $au_id
 * @property string $ip
 * @property string $address
 * @property string $url
 * @property string $star_time
 * @property string $end_time
 * @property integer $uid
 * @property string $phone
 * @property string $email
 * @property string $data
 * @property string $table
 * @property integer $table_id
 * @property integer $sid 调查id
 * @property string $answer_name
 * @property string $answer_age
 * @property integer $constellation
 */
class AnswerUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['star_time', 'end_time'], 'safe'],
            [['uid', 'table_id','sid','constellation'], 'integer'],
            [['data'], 'string'],
            [['ip'], 'string', 'max' => 24],
            [['address','answer_name', 'url'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 64],
            [['table','answer_age'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'au_id' => '回答者编号',
            'ip' => 'ip地址',
            'address' => '地区',
            'url' => '回答者来源',
            'star_time' => '答题开始时间',
            'end_time' => '答题结束时间',
            'uid' => '用户id',
            'phone' => '电话',
            'email' => '邮箱',
            'data' => '附加数据',
            'table' => '表id',
            'table_id' => '表id',
            'sid'=>'调查id',
            'answer_name'=>'回答姓名',
            'answer_age'=>'回答年龄',
            'constellation'=>'星座'
        ];
    }
}
