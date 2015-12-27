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
    static $messageTable = 'answer_survey_resulte';
    public function actionIndex()
    {
        echo 2;
        exit();
    }

    public function actionList()
    {
        $id = Yii::$app->request->get('id', 0);
        $condition['table_id'] = $id;
//         $condition['table']  = self::$messageTable;
        // 分页
        
        $count = Message::find()->where($condition)->count();
        $pagination = new Pagination();
        $pagination->totalCount = $count;
        $pagination->pageSize = ZCommonFun::getPageSize();
        
        $model_Message = new Message();
        $data = $model_Message->find()
            ->where($condition)
            ->limit($pagination->getLimit())
            ->offset($pagination->getOffset())->orderBy(' msg_id desc')
            ->all();
        isset($data[0]) ?  : $data = [];
        $pageCount = $pagination->getPageCount();
        $page = Yii::$app->request->get('page',0);
      
        if($pageCount>0 && $page>0 ){
            //             echo $page,$pageCount;
            //超过最后一页
            if($page>$pageCount){
                echo '';
                exit;
            }
        }
         foreach($data as $key=>$model_Message){
             $name = $model_Message->from_uid;
             $time = ZCommonFun::time_tran($model_Message->add_time);
             $comment_add_url = Yii::$app->urlManager->createUrl(['comment/add','id'=>$id,'tid'=>$model_Message->from_uid,'content'=>'#content#']);
            echo <<<str
<li class="module-infobox layout-box media-graphic line-bottom" uid="{$model_Message->from_uid}" comment-url="{$comment_add_url}">
    <a href="javascript:void(0);" class="mod-media size-xs">
        <div class="media-main">
    		<img src="./bag-test/test-images/0(2)" height="34" width="34" data-bd-imgshare-binded="1">
    	</div>
     </a>
    <div class="box-col item-list">
    	<div class="item-main txt-s mct-a txt-cut">{$name}</div>
    	<div class="item-other txt-xxs mct-d txt-cut">
    		<span class="time">{$time}</span>
    	</div>
    	<div class="item-minor txt-l mct-b">{$model_Message->content}</div>
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
        
        if ($id < 1)
            ZCommonFun::output_json(null, 1, '页面不存在');
            
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
        $model_Message->to_uid = $uid;
        $model_Message->table = self::$messageTable;
        $model_Message->table_id = $id;
        $model_Message->add_time = NOW_TIME_YmdHis;
        $model_Message->content = $content;
        $model_Message->is_read = 0;
        $model_Message->parent_id = 0;
        $model_Message->title = '';
        $model_Message->status = 0;
        // save success
        if ($model_Message->save()) {
            $model_AnswerSurveyResulte = new AnswerSurveyResulte();
            $model_AnswerSurveyResulte->setcomment_count($model_Message->table_id);
            ZCommonFun::output_json(null, 0, '评论成功');
        }  // save failed
        else {
            ZCommonFun::output_json($model_Message->errors, - 2, '评论失败');
        }
    }
}
