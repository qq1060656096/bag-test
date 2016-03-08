<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%oauth_bind}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $openid
 * @property string $type
 * @property string $created
 */
class OauthBind extends \yii\db\ActiveRecord
{
    const typeQQ = 'QQ';
    const textQQ = 'QQ';
    
    const typeWeiBo = 'weibo';
    const textWeiBo = '微博';
    
    const typeWeiXin = 'weixin';
    const textWeiXin = '微信';
    /**
     * 绑定类型
     * @return NULL|string
     */
    public static function constBindList(){
        static $data = null;
        if(isset($data))
            return $data;
        $data = [
            'user'=>'账号',
            self::typeQQ=>self::textQQ,
            self::typeWeiBo=>self::textWeiBo,
            self::typeWeiXin=>self::textWeiXin,
        ];
        return $data;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth_bind}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'integer'],
            [['created'], 'safe'],
            [['openid'], 'string', 'max' => 250],
            [['type'], 'string', 'max' => 12]
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
            'openid' => 'Openid',
            'type' => 'Type',
            'created' => 'Created',
        ];
    }
    /**
     * 获取用户绑定列表
     * @param integer $uid
     * @return array
     */
    public function getUserBindList($uid){
        $condition['uid'] = $uid;
        $arr_models = $this->findAll($condition);
        isset($arr_models[0]) ? null : $arr_models=[];
        return $arr_models;
    }
    /**
     * 绑定类型是否绑定
     * @param string $bind_type
     * @param array $userBindList
     * @return boolean
     */
    public static function bindTypeIsBind($bind_type,$userBindList){
        foreach ($userBindList as $key=>$row){
            if(isset($row->type) && $row->type==$bind_type)
                return true;
        }
        return false;
    }
}
