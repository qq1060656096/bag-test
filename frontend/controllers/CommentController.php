<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use common\z\ZCommonFun;
use common\z\ZCommonSessionFun;
use common\models\Message;
use yii\data\Pagination;
use common\models\AnswerSurveyResulte;
use common\z\ZController;
use common\models\User;
class CommentController extends Controller
{
    static $messageTable = '';
    public function actionIndex()
    {
        echo 2;
        exit();
    }

    /**
     * 我的消息
     */
    public function actionMyList(){
        $model_Message = new Message();
        $data = $model_Message->getMyList(ZCommonSessionFun::get_user_id(), ZCommonFun::getPageSize(), '');
        isset($data['models'][0]) ?  : $data['models'] = [];
        if(count($data['models'])<1 ){
            //             echo $page,$pageCount;
            //超过最后一页
            echo '';
            exit;
        }

        foreach( $data['models'] as $key=>$model_Message){
            $name       = isset($model_Message->fromUser) ? $model_Message->fromUser->getShowName():'';
            $head_image = isset($model_Message->fromUser->userProfile) ? $model_Message->fromUser->userProfile->getHeadImage0():'./images/head_image.png';
            $intro      = isset($model_Message->fromUser->userProfile) ? $model_Message->fromUser->userProfile->getHeadImage0():'./images/head_image.png';
            $talk_url   = Yii::$app->urlManager->createUrl(['my/ta-me-message','uid'=>$model_Message->from_uid]);
            echo <<<str
    	<a href="{$talk_url}" class="weui_media_box weui_media_appmsg">
			<div class="weui_media_hd">
				<img class="weui_media_appmsg_thumb" src="{$head_image}" alt="">
			</div>
			<div class="weui_media_bd">
				<h4 class="weui_media_title">{$name}</h4>
				<p class="weui_media_desc">{$model_Message->content}</p>
			</div>
		</a>
str;
        }
    }

    /**
     * Ta与我私信
     * 我和某人的消息
     */
    public function actionList()
    {
        $id     = Yii::$app->request->get('id', 0);
        $ta_uid = Yii::$app->request->get('uid', 0);
        $login_uid = ZCommonSessionFun::get_user_id();
        $model_Message = new Message();
        $data   = $model_Message->getTaList($ta_uid, $login_uid, '', ZCommonFun::getPageSize(), null);
        isset($data['models'][0]) ?  : $data['models'] = [];
//         ZCommonFun::print_r_debug($data);
//         exit;
        if(count($data['models'])<1 ){
            //echo $page,$pageCount;
            //超过最后一页
                echo '';
                exit;
        }

        $User               = User::findOne($login_uid);
        $login_head_image   = $User ? $User->getTaShowHead_image() : User::getDefaultHead_image();
        $ta_User            = User::findOne($ta_uid);
        $ta_head_image      = $ta_User ? $ta_User->getTaShowHead_image() : User::getDefaultHead_image();
//         $this->title = $ta_user_showNickname.'与'.$login_user_showNickname;
         foreach( $data['models'] as $key=>$model_Message){
             //我发出的
             if( $model_Message->from_uid == $login_uid ){
                $head_image = $login_head_image;
                $class0     = 'imgright';
                $class      = 'spanright';
             }//他发给我的
             else{
                $head_image = $ta_head_image;
                $class0     = 'imgleft';
                $class      = 'spanleft';
             }

             echo <<<str
             <li page="{$data['pagination']->page}" pageCount="{$data['pagination']->pageCount}"><img src="{$head_image}"
				class="{$class0}"><span class="{$class}">{$model_Message->content}</span></li>


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
        if($to_uid==$uid)
            ZCommonFun::output_json(null, 3, '私信不能发给自己');

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
