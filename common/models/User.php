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
    
    const scenarioOauthBind = 'oauth-bind';
    
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
            [['user','pass'], 'required','message'=>'{attribute}不能为空'],
            [['pass'], 'safe', 'on' =>self::scenarioOauthBind],
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
    /**
     * 绑定用户信息
     * @param unknown $user 用户名
     * @param unknown $pass 密码
     * @param unknown $uid 用户id
     * @param unknown $openid 开放id
     * @param unknown $type 类型
     * @param unknown $nickname 昵称
     * @param unknown $head_image 头像
     * @param string $is_register true注册用户|false老用户绑定
     * @return number
     */
    public function userBind($user,$pass,$uid,$openid,$type,$nickname,$head_image,$is_register=false){
        $model_OauthBind = new OauthBind();
        $condition['openid'] = $openid;
        $condition['type'] = $type;
        $model_OauthBind=$model_OauthBind->findOne($condition);
        if($model_OauthBind && $model_OauthBind->uid>0&& $model_User = User::findOne($model_OauthBind->uid)){
            $is_register=false;
        }
//         ZCommonFun::print_r_debug($model_User);
//         ZCommonFun::print_r_debug($model_OauthBind);
//         exit;
        //已存在用户
        if(!$is_register){
            
        }//注册用户
        else{
            $model_User = new User();
    
            $max_uid = User::find()->max('uid');
            $max_uid ++;
            $model_User->user = $max_uid.'';
            $model_User->pass = $model_User->user;
            $model_User->created = NOW_TIME_YmdHis;
            $model_User->save();
        }
        
        
        $model_OauthBind = new OauthBind();
        $condition['openid'] = $openid;
        $condition['type'] = $type;
        $model_OauthBind=$model_OauthBind->findOne($condition);
        //已经绑定了
        if( $model_OauthBind ){
            $this->operationData['user'] = $model_User;
            $model_UserProfile = UserProfile::findOne(['uid'=>$model_User->uid]);
            if(!$model_UserProfile){
                $model_UserProfile = new UserProfile();
                $model_UserProfile->uid = $model_User->uid;
                $model_UserProfile->nickname = $nickname;
                $model_UserProfile->head_image = $head_image;
                $model_UserProfile->money = 0;
                $model_UserProfile->friend_money = 0;
                
                $model_UserProfile->save();
//                 ZCommonFun::print_r_debug($model_UserProfile);
//                 exit;
            }
            
            $this->operationData['oauth_bind'] = $model_OauthBind;
            $this->operationData['user_profile'] = $model_UserProfile ;
            return 1;
        }
        
        $model_OauthBind = new OauthBind();
        $model_OauthBind->openid = $openid.'';
        $model_OauthBind->type = $type;
        $model_OauthBind->uid = $model_User->uid;
        $model_OauthBind->created = NOW_TIME_YmdHis;
        if( $model_OauthBind->save() ){
            $model_UserProfile = UserProfile::findOne(['uid'=>$model_User->uid]);
            //如果没有设置过用户信息，就设置用户信息
            if(!$model_UserProfile){ 
                $model_UserProfile = new UserProfile();
                $model_UserProfile->uid = $model_User->uid;
                $model_UserProfile->nickname = $nickname;
                $model_UserProfile->head_image = $head_image;
                $model_UserProfile->money = 0;
                $model_UserProfile->friend_money = 0;
            
                $model_UserProfile->save();
            }
            
            $this->operationData['user'] = $model_User;
            $this->operationData['user_profile'] = $model_UserProfile;
            return 0;
        }
        
        return -1;
    }
}
