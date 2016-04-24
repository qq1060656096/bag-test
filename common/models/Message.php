<?php

namespace common\models;

use Yii;
use yii\data\Pagination;
use yii\db\Query;
/**
 * This is the model class for table "{{%message}}".
 *
 * @property string $msg_id
 * @property string $from_uid
 * @property string $to_uid
 * @property string $title
 * @property string $content
 * @property string $add_time
 * @property string $last_update
 * @property string $group_id
 * @property integer $is_read
 * @property string $parent_id
 * @property integer $status
 * @property string $table
 * @property integer $table_id
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_uid', 'to_uid', 'last_update', 'is_read', 'parent_id', 'status', 'table_id'], 'integer'],
            [['content'], 'string'],
            [['title','group_id'], 'string', 'max' => 100],
            [['table'], 'string', 'max' => 64],
            [['add_time'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'msg_id' => 'Msg ID',
            'from_uid' => 'From Uid',
            'to_uid' => 'To Uid',
            'title' => 'Title',
            'content' => 'Content',
            'add_time' => 'Add Time',
            'last_update' => 'Last Update',
            'group_id'=>'分组id',
            'is_read' => 'Is Read',
            'parent_id' => 'Parent ID',
            'status' => 'Status',
            'table' => 'Table',
            'table_id' => 'Table ID',
        ];
    }
    /**
     * 获取列表数据
     * @param integer $uid
     * @param string $table
     * @param integer $pageSize
     * @param mixed $where
     * @param mixed $sort
     * @return []
     */
    public function getList($uid,$table,$pageSize,$where,$sort = ['add_time'=>SORT_DESC]){
        $model_Message = new Message();

        $query = $model_Message->find()->where('`table`=:table and (from_uid=:from_uid or to_uid=:to_uid)',
            [':table'=>$table,':from_uid'=>$uid,'to_uid'=>$uid])
        ;

        if($where){
            $query->andWhere($where);
        }
        if($sort){
            $query->orderBy($sort);
        }

        $pagination = new Pagination();
        $pagination->totalCount = $query->count();

        $offset = $pagination->getOffset();
        $limit = $pagination->getLimit();
        $query->offset($offset);
        $query->limit($limit);
//         echo $query->createCommand()->getRawSql();
        $a_models = $query->all();
        if( isset($_GET[$pagination->pageParam])&& $pagination->pageCount < $_GET[$pagination->pageParam]  ){
            $a_models = [];
        }

        $temp_data['models'] = $a_models;
        $temp_data['pagination'] = $pagination;
        return $temp_data;
    }
    /**
     * 获取列表数据
     * @param integer $login_uid
     * @param integer $pageSize
     * @param mixed $where
     * @param mixed $sort
     * @return []
     */
    public function getMyList(  $login_uid ,$pageSize,$where,$sort = ['add_time'=>SORT_DESC]){


        $model_Message = new Message();
        /**
         select * from message where msg_id in(
        	select MAX(msg_id) from
        	message GROUP BY from_uid
        )
         */
        $message = new Message();
        $query = $message->find();
        $query->select('max(`msg_id`)');
        $query->where(['to_uid'=>$login_uid]);
        $query->groupBy('from_uid');


        $pagination = new Pagination();
        $pagination->totalCount = $query->count();
        $pagination->setPageSize($pageSize);
        $offset = $pagination->getOffset();
        $limit = $pagination->getLimit();

        $condition[0] = 'in';
        $condition[1] = 'msg_id' ;
        $condition[2] = $query;
        $query_all = $model_Message->find()->where($condition)->offset($offset)->limit($limit);
//         echo $query_all->createCommand()->getRawSql();
// exit();

        //                 echo $query->createCommand()->getRawSql();
        //                 exit;
        $a_models = $query_all->all();
        if( isset($_GET[$pagination->pageParam])&& $pagination->pageCount < $_GET[$pagination->pageParam]  ){
            $a_models = [];
        }

        $temp_data['models'] = $a_models;
        $temp_data['pagination'] = $pagination;
        return $temp_data;
    }
    /**
     * 获取列表数据
     * @param integer $ta_uid
     * @param integer $login_uid
     * @param string  $table
     * @param integer $pageSize
     * @param mixed $where
     * @param mixed $sort
     * @return []
     */
    public function getTaList( $ta_uid , $login_uid , $table,$pageSize,$where,$sort = ['msg_id'=>SORT_ASC]){
        $pageSize=1;
        $arr = [
            $ta_uid,$login_uid
        ];
        $arr = array_unique( $arr );
        $str = implode(',', $arr);
        $model_Message = new Message();

        $query = $model_Message->find()->where("`table`=:table and ( (from_uid=$login_uid and to_uid=$ta_uid ) or (from_uid=$ta_uid and to_uid=$login_uid ) ) ",
            [':table'=>$table ] ) ;

        if($where){
            $query->andWhere($where);
        }
        if($sort){
            $sort['msg_id']=SORT_DESC;
            $query->orderBy($sort);
        }

        $pagination = new Pagination();
        $pagination->totalCount = $query->count();

        $offset = $pagination->getOffset();
        $limit = $pagination->getLimit();
        $query->offset($offset);
        $query->limit($limit);
        $pagination->page;
//                 echo $query->createCommand()->getRawSql();
//                 exit;
        $a_models = $query->all();
        if( isset($_GET[$pagination->pageParam])&& $pagination->pageCount < $_GET[$pagination->pageParam]  ){
            $a_models = [];
        }

        $temp_data['models'] = $a_models;
        $temp_data['pagination'] = $pagination;
        return $temp_data;
    }

    /**
     * 添加关注日志
     * @param integer $from_uid 发送者uid
     * @param integer $to_uid   接受者uid
     * @param boolean $is_concern true关注,false取消关注
     * @return boolean
     */
    public static function addConcernLog($from_uid,$to_uid,$is_concern=true,$table_id=0){
        $model = new Message();
        $model->from_uid = $from_uid;
        $model->to_uid = $to_uid;
        if($is_concern){
            $model->title = '关注';
            $model->content = '关注成功';
        }else{
            $model->title = '取消关注';
            $model->content = '取消关注';
        }
        $model->group_id = '';
        $model->table = 'users_friends';
        $model->table_id = $table_id;
        $model->add_time = date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);
        return $model->save();
    }

    public function getFromUser(){
        return $this->hasOne(User::className(), ['uid'=>'from_uid']);
    }

    public function getToUser(){
        return $this->hasOne(User::className(), ['uid'=>'to_uid']);
    }
}
