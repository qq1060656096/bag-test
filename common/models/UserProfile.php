<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $nickname
 * @property string $head_image
 * @property string $money
 * @property string $friend_money
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'integer'],
            [['money', 'friend_money'], 'number'],
            [['nickname', 'head_image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'nickname' => 'Nickname',
            'head_image' => 'Head Image',
            'money' => 'Money',
            'friend_money' => 'Friend Money',
        ];
    }
}
