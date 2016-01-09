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
 * @property integer $test_count
 * @property integer $testing_count
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
            [['uid', 'sex','test_count','testing_count'], 'integer'],
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
            'test_count'=>'测试次数',
            'testing_count'=>'被测试次数'
        ];
    }
    /**
     * 设置测试次数
     * @param integer $uid
     */
    public function setTestCount($uid){
        $condition['uid'] = $uid;
        $count = Survey::find()->where($condition)->count();
        $testing_count = Survey::find()->where($condition)->sum('answer_count');
        $model_UserProfile = UserProfile::findOne($uid);
        $model_UserProfile ? null : $model_UserProfile=new UserProfile();
        $model_UserProfile->uid = $uid;
        $model_UserProfile->test_count = $count;
        $model_UserProfile->testing_count = $testing_count;
        return $model_UserProfile->save();
    }
    /**
     * 获取昵称
     * @return string
     */
    public function getNickname0(){
        $nickname = !empty($this->nickname) ? $this->nickname : 'NO.'.$this->uid;
        return $nickname;
    }
    
    
    /**
     * 获取简介
     * @return string
     */
    public function getIntro0(){
        $return = !empty($this->intro) ? $this->intro : '暂无简介';
        return $return;
    }
    /**
     * 获取头像
     */
    public function getHeadImage0(){
        $image = !empty($this->head_image) ? $this->head_image : './images/head_image.png';
        return $image;
    }
    
    /**
     * 获取准确率
     * @return float;
     */
    public static function getRate0(){
        $return = rand(95, 99);
        $return = '99.'.$return.'%';
        return $return;
    }
}
