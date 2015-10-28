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
}
