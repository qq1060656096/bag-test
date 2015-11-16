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
 * @property integer $sex
 * @property string $intro
 * @property string $birthday
 * @property string $address
 * @property string $qq
 * @property string $school
 */
class UserProfile extends \yii\db\ActiveRecord
{
    static $sexData = array(
        '-1'=>'未知',
        '0'=>'女',
        '1'=>'男'
    );
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
            [['uid', 'sex'], 'integer'],
            [['money', 'friend_money'], 'number'],
            [['intro'], 'string'],
            [['birthday'], 'safe'],
            [['nickname', 'head_image', 'address', 'school'], 'string', 'max' => 255],
            [['qq'], 'string', 'max' => 24]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户uid',
            'nickname' => '昵称',
            'head_image' => '头像',
            'money' => 'Money',
            'friend_money' => 'Friend Money',
            'sex' => '性别',
            'intro' => '简介',
            'birthday' => '生日',
            'address' => '地址',
            'qq' => 'QQ',
            'school' => '学校',
        ];
    }
}
