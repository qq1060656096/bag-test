<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_friends".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $fuid
 * @property string $fusername
 * @property integer $gid
 * @property string $created
 * @property string $note
 */
class UsersFriends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'fuid', 'created'], 'required'],
            [['uid', 'fuid', 'gid'], 'integer'],
            [['created'], 'safe'],
            [['fusername', 'note'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'users表中的uid',
            'fuid' => '好友uid[引用users表中的uid]',
            'fusername' => '用户好友名',
            'gid' => '好用分组id',
            'created' => '添加好友时间',
            'note' => '好友备注',
        ];
    }
    
    /**
     * 获取指定用户的朋友
     * @param unknown $uid
     * @param unknown $fuid
     * @return Ambigous <\yii\db\static, \yii\db\null>
     */
    public function get_user_friend($uid,$fuid){
        $model = new UsersFriends();
        $condition['uid'] = $uid;
        $condition['fuid'] = $fuid;
        return $model->findOne($condition);
    }
    /**
     * 获取是否相互关注
     * @param unknown $uid
     * @param unknown $fuid
     * @return 0相互不关注,1相互关注,2我关注的人,3关注我的人
     */
    public function get_user_each_concern($uid,$fuid){
        static $status=null;
        if($status!==null){
            return $status;
        }
        //相互不关注
        $status = 0;
        $user_friend = $this->get_user_friend($uid, $fuid);
        $friend_user = $this->get_user_friend($fuid, $uid);
        
        
        //相互关注
        if($user_friend && $friend_user){
            $status = 1;
        }//我关注的人
        else  if($user_friend){
            $status = 2;
        }//关注我的人
        else if($friend_user){
            $status = 3;
        }
        return $status;
    }
    
    /**
     * 获取粉丝数量，或者关注着数量
     * @param integer $uid
     * @param boolean $is_fans true粉丝,false关注
     * @return integer
     */
    public static function get_concern_count($uid,$is_fans = false){
        $model = new UsersFriends();
        if(!$is_fans){
            $condition['uid'] = $uid;
        }else{
            $condition['fuid'] = $uid;
        }
        $count = $model->find()->where($condition)->count();
//         echo $model->find()->where($condition)->createCommand()->getRawSql();
        return $count;
    }
}
