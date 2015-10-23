<?php

namespace common\models;

use Yii;
use common\z\ZCommonSessionFun;
use common\z\ZCommonFun;

/**
 * This is the model class for table "user".
 *
 * @property integer $uid
 * @property string $user
 * @property string $pass
 * @property integer $flag
 * @property string $created
 */
class User extends \yii\db\ActiveRecord
{
    public $operationError=0;
    public $operationMessage=null;
    public $operationData = null;
    public function clearOperation(){
        $this->operationError = 0;
        $this->operationMessage = null;
        $this->operationData = null;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flag'], 'integer'],
            [['created'], 'safe'],
            [['user'], 'string', 'max' => 128],
            [['pass'], 'string', 'max' => 255],
            [['user'], 'unique','message'=>'{attribute}已经存在'],
            [['user','pass'], 'required','message'=>'{attribute}不能为空']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '编号',
            'user' => '账号',
            'pass' => '密码',
            'flag' => '标记',
            'created' => '注册时间',
        ];
    }
    
    /**
     * 登录
     * @param string $user
     * @param string $pass
     * @return number
     */
    public function login($user,$pass){
//         echo $user;
        $condition['user'] = $user;
        $model = $this->find()->where($condition)->one();
//         ZCommonFun::print_r_debug($model);
        //
        if(!$model){
            $this->operationError = 1;
            $this->operationMessage = '用户没有找到';
        }
        else if( $model->pass!= $pass ){
            $this->operationError = 2;
            $this->operationMessage = '密码错误';
        }else{
         $this->operationError =0;
         $userInfo = $model->attributes;
         $userInfo['role'] = 0; //角色
         $userInfo['openidInfo'] = null;//第三方登录信息
         ZCommonSessionFun::set_user_session($userInfo);
        }
        return $this->operationError;
    }
    /**
     * 注册
     */
    public function register(){
        $this->created = NOW_TIME_YmdHis;
        $this->flag = NOW_TIME_STAMP;
        if( $this->validate() ){
           if( $this->save() ){
               return true;
           }
           return false;
        }
        return false;
    }
}
