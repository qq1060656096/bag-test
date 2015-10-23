<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reward".
 *
 * @property integer $r_id
 * @property string $table
 * @property integer $table_id
 * @property string $reward_total
 * @property string $reward_average
 * @property integer $reward_count
 */
class Reward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_id', 'reward_count'], 'integer'],
            [['reward_total', 'reward_average'], 'number'],
            [['table'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'r_id' => '打赏编号',
            'table' => 'Table',
            'table_id' => 'Table ID',
            'reward_total' => 'Reward Total',
            'reward_average' => 'Reward Average',
            'reward_count' => '打赏次数',
        ];
    }
}
