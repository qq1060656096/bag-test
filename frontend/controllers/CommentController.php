<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use common\z\ZCommonFun;
use common\z\ZCommonSessionFun;
use common\models\Message;
use yii\data\Pagination;
use common\models\AnswerSurveyResulte;
class CommentController extends Controller
{
    static $messageTable = '';
    public function actionIndex()
    {
        echo 2;
        exit();
    }

    public function actionList()
    {
        $id = Yii::$app->request->get('id', 0);
        $uid = Yii::$app->request->get('uid', 0);
        $condition['table_id'] = $id;
//         $condition['table']  = self::$messageTable;
        // 分页
        
        $count = Message::find()->where($condition)->count();
        $pagination = new Pagination();
        $pagination->totalCount = $count;
        $pagination->pageSize = ZCommonFun::getPageSize();
        
        $model_Message = new Message();
        $where = null;
        $data = $model_Message->getList($uid, '', 10, $where);
//         ZCommonFun::print_r_debug($data);
        isset($data['models'][0]) ?  : $data['models'] = [];
      
      
        if(count($data['models'])<1 ){
            //             echo $page,$pageCount;
            //超过最后一页
          
                echo '';
                exit;
            
        }
         foreach( $data['models'] as $key=>$model_Message){
             $name = isset($model_Message->fromUser) ? $model_Message->fromUser->getShowName():'';
             $head_image = isset($model_Message->fromUser->userProfile) ? $model_Message->fromUser->userProfile->getHeadImage0():'./images/head_image.png';
//              ZCommonFun::print_r_debug($model_Message->fromUser->userProfile);
             $time = ZCommonFun::time_tran($model_Message->add_time);
             $comment_add_url = Yii::$app->urlManager->createUrl(['comment/add','id'=>$id,'tid'=>$model_Message->from_uid,'content'=>'#content#']);
             $to_uid_url = Yii::$app->urlManager->createUrl(['my/personal-page','uid'=>$model_Message->to_uid]);
             $to_show_name = isset($model_Message->toUser) ? $model_Message->toUser->getShowName():'';
            echo <<<str
<li class="module-infobox layout-box media-graphic line-bottom" uid="{$model_Message->from_uid}" comment-url="{$comment_add_url}">
    <a href="javascript:void(0);" class="mod-media size-xs">
        <div class="media-main">
    		<img src="{$head_image}" height="34" width="34" data-bd-imgshare-binded="1">
    	</div>
     </a>
    <div class="box-col item-list">
    	<div class="item-main txt-s mct-a txt-cut">{$name}</div>
    	<div class="item-other txt-xxs mct-d txt-cut">
    		<span class="time">{$time}</span>
    	</div>
    	<div class="item-minor txt-l mct-b">
    	<a href="{$to_uid_url}">@{$to_show_name}</a>
    	{$model_Message->content}
    	</div>
    </div>
	<a href="javascript:void(0);" class="operate-box" data-node="zanPL">
	    <i class="icon icon-likesmall"></i>
	    <em class="num mct-d"></em>
    </a>
</li>
str;
            
        }
        exit;
    }

    /**
     * 发布评论
     */
    public function actionAdd()
    {
        $id = Yii::$app->request->get('id', 0);
        $id = $id ? (int) $id : 0;
        $to_uid = Yii::$app->request->get('tid', 0);
        $to_uid = $to_uid ? (int) $to_uid : 0;
        $uid = ZCommonSessionFun::get_user_id();
        $content = Yii::$app->request->get('content', '');
        
//         if ($id < 1)
//             ZCommonFun::output_json(null, 1, '页面不存在');
            
            /*
         * if($to_uid < 1 )
         * ZCommonFun::output_json(null, 1, '页面不存在3');
         */
        if (empty($content))
            ZCommonFun::output_json(null, 2, '评论内容不能为空');
        
        if ($uid < 1)
            ZCommonFun::output_json(null, -1, '请登录');
        
        $model_Message = new Message();
        $model_Message->from_uid = $uid;
        $model_Message->to_uid = $to_uid;
        $model_Message->table = self::$messageTable;
        $model_Message->table_id = $id;
        $model_Message->add_time = NOW_TIME_YmdHis;
        $model_Message->content = $content;
        $model_Message->is_read = 0;
        $model_Message->parent_id = 0;
        $model_Message->title = '';
        $model_Message->group_id = $uid.$to_uid;
        $model_Message->status = 0;
        // save success
        if ($model_Message->save()) {
//             $model_AnswerSurveyResulte = new AnswerSurveyResulte();
//             $model_AnswerSurveyResulte->setcomment_count($model_Message->table_id);
            ZCommonFun::output_json(null, 0, '评论成功');
        }  // save failed
        else {
            ZCommonFun::output_json($model_Message->errors, - 2, '评论失败');
        }
    }
}
