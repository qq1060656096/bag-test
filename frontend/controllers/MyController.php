<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\models\Survey;
use common\models\SurverySearch;
use common\z\ZCommonSessionFun;
use common\z\ZCommonFun;
use common\models\UsersFriends;
use common\models\Message;
use common\models\User;
use common\models\common\models;
use yii\db\Query;
use common\z\ZController;

/**
 * Site controller
 */
class MyController extends ZController
{

    public $pageSize = 3;

    /**
     * 我测试过的，有权限
     */
    public function actionMeTest()
    {
        $this->getView()->title = '我创建的测试';
        $this->pageSize = 1;
        $this->layout = false;
        $searchModel = new SurverySearch();
        $where = [];
        $uid = ZCommonSessionFun::get_user_id();
        $temp_data = $searchModel->getMyTest($uid, null, null, $this->pageSize);
        // 列表
        if (isset($_GET['ajax'])) {
            return $this->render('my-test-list', [
                'a_models' => $temp_data['models'],
                'pagination' => $temp_data['pagination']
            ]);
        }

        return $this->render('me-test', [
            'a_models' => $temp_data['models'],
            'uid' => $uid,
            'ajax_url' => Yii::$app->urlManager->createUrl([
                'my/me-test',
                'page' => '#page#',
                'sort' => 1,
                'self' => 1,
                'ajax' => 1
            ])
        ]);
    }

    /**
     * 他测过的，无权限
     */
    public function actionMyTest($uid = 0)
    {
        $this->getView()->title = 'Ta测过的';

        $this->pageSize = 1;
        $uid = intval($uid);
        $uid = $uid > 0 ? $uid : 0;

        $this->layout = false;
        $searchModel = new SurverySearch();
        $where = [];
        $temp_data = $searchModel->getMyTest($uid, null, null, $this->pageSize);
        // 列表
        if (isset($_GET['ajax'])) {
            return $this->render('my-test-list', [
                'a_models' => $temp_data['models'],
                'pagination' => $temp_data['pagination']
            ]);
        }

        return $this->render('my2', [
            'a_models' => $temp_data['models'],
            'uid' => $uid,
            'ajax_url' => Yii::$app->urlManager->createUrl([
                'my/my-test',
                'page' => '#page#',
                'sort' => 1,
                'self' => 1,
                'ajax' => 1,
                'uid' => $uid
            ])
        ]);
    }

    /**
     * 他人主页，无权限
     */
    public function actionPersonalPage($uid = 0)
    {
        $this->getView()->title = User::getTaUidShowName($uid) . '个人主页';
        $this->layout = false;
        $uid = intval($uid);
        $uid = $uid > 0 ? $uid : 0;
        // $this->render('my2');

        $searchModel = new SurverySearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['SurverySearch']['uid'] = $uid;
        $queryParams['SurverySearch']['is_publish'] = 1;
        $query = $searchModel->query($queryParams);

        $count = $query->count();
        // echo $count;
        // 分页
        $pagination = new Pagination();
        // 每页现实数量
        $pagination->pageSize = $this->pageSize;
        // 总数量
        $pagination->totalCount = $count;
        $old_page = $pagination->page;
        $offset = $pagination->getOffset();
        $limit = $pagination->getLimit();
        $query->offset($offset);
        $query->limit($limit);
        $query->orderBy([
            'id' => SORT_DESC
        ]);
        $a_models = $query->all();

        if (isset($_GET['ajax'])) {

            if (isset($_GET[$pagination->pageParam]) && $pagination->pageCount < $_GET[$pagination->pageParam]) {
                $a_models = [];
            }
            // echo $pagination->pageCount,'-',$pagination->page,'$old_page',$_GET[$pagination->pageParam] ;
            // exit;
            return $this->render('my-test-list', [
                'a_models' => $a_models,
                'pagination' => $pagination
            ]);
        }

        // isset($a_models[0]) ? null : $a_models=[];
        return $this->render('my2', [
            'searchModel' => $searchModel,
            'a_models' => $a_models,
            'pagination' => $pagination,
            'self' => 1,
            'ajax_url' => Yii::$app->urlManager->createUrl([
                'my/personal-page',
                'page' => '#page#',
                'sort' => 1,
                'self' => 1,
                'ajax' => 1,
                'uid' => $uid
            ]),
            'uid' => $uid
        ]);
    }

    /**
     * 关注
     *
     * @param number $fuid
     */
    public function actionConcern($fuid = 0, $op = '')
    {
        $uid = ZCommonSessionFun::get_user_id();
        $fuid = intval($fuid);

        // $uid = 2;
        // $fuid = 2;

        if ($fuid < 1) {
            ZCommonFun::output_json(null, 2, '参数错误');
        }

        // 请登录
        if ($uid < 1) {
            ZCommonFun::output_json(null, - 1, '请登录');
        }
        $model_UsersFriends = new UsersFriends();
        $model_UsersFriends0 = $model_UsersFriends->get_user_friend($uid, $fuid);
        if ($model_UsersFriends0) {
            if ($model_UsersFriends0->delete()) {
                Message::addConcernLog($uid, $fuid, false);
                ZCommonFun::output_json('关注', 0, '取消关注成功');
            } else {
                ZCommonFun::output_json(null, - 2, '取消关注失败');
            }
            ZCommonFun::output_json(null, 1, '已关注');
        }

        $model_UsersFriends->uid = $uid;
        $model_UsersFriends->fuid = $fuid;
        $model_UsersFriends->created = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        // 关注成功
        if ($model_UsersFriends->save()) {
            Message::addConcernLog($uid, $fuid, true);
            ZCommonFun::output_json('已关注', 0, '关注成功');
        }

        ZCommonFun::output_json(null, - 2, '关注失败');
    }

    /**
     *Ta与我的交谈
     */
    public function actionTaMeMessage($uid){
        $this->layout = false;
        $this->view->title = 'Ta的私信';
        $model = new Message();
        $a_models = $model->getList($uid, 'users_friends', $this->pageSize, null);
        return $this->render('ta-me-message', [
            'a_models' => $a_models,
            'uid' => $uid,
            'ta_me'=>1,
            'ajax_url' => Yii::$app->urlManager->createUrl([
                'comment/list',
                'page' => '#page#',
                'sort' => 1,
                'self' => 1,
                'ajax' => 1,
                'uid' => $uid,
                'ta_me'=>1,
            ])
        ]);
    }


    /**
     * Ta的私信
     */
    public function actionMessage($uid)
    {
        $this->layout = false;
        $this->view->title = 'Ta的私信';
        $model = new Message();
        $a_models = [];
        return $this->render('my-message', [
            'a_models' => $a_models,
            'uid' => $uid,
            'ajax_url' => Yii::$app->urlManager->createUrl([
                'comment/list',
                'page' => '#page#',
                'sort' => 1,
                'self' => 1,
                'ajax' => 1,
                'uid' => $uid
            ])
        ]);
    }

    /**
     * 我的私信
     * @return \yii\web\Response|\yii\base\string
     */
    public function actionMyMessage()
    {
        $login_uid = ZCommonSessionFun::get_user_id();
        // 请登录
        if ($login_uid < 1) {
            return $this->redirect([
                'login/login'
            ]);
        }
        $this->layout = false;
        $this->view->title = '我的私信';
        $model = new Message();
        $uid = $login_uid;

        return $this->render('my-message3', [
            'a_models' => [],
            'uid' => $uid,
            'ta_me'=>0,
            'ajax_url' => Yii::$app->urlManager->createUrl([
                'comment/my-list',
                'page' => '#page#',
                'sort' => 1,
                'self' => 1,
                'ajax' => 1,
                'uid' => $uid,
                'ta_me'=>0,
            ])
        ]);
        /* return $this->render('my-message', [
            'a_models' => $a_models,
            'uid' => $uid,
            'ajax_url' => Yii::$app->urlManager->createUrl([
                'comment/list',
                'page' => '#page#',
                'sort' => 1,
                'self' => 1,
                'ajax' => 1,
                'uid' => $uid
            ])
        ]); */
    }

    /**
     * 搜索用户
     */
    public function actionUsersList($search = '')
    {
        $this->layout = false;
        $json['status'] = 0;
        $json['data'] = [];
        $model = new User();
        $query = $model->find();
        $query->join('inner join', 'user_profile', 'user.uid=user_profile.uid');
        $condition = "`user_profile`.`nickname` like :search or `user` like :search ";
        $query->where($condition, [
            ':search' => $search . '%'
        ]);
        $query->limit(100);
        // echo $query->createCommand()->getRawSql();
        $a_models = $query->all();
        isset($a_models[0]) ? null : $json['suggestions'] = [];
        foreach ($a_models as $key => $row) {
            $temp_row['uid'] = $row->uid;
            $temp_row['data'] = $row->user;
            $temp_row['value'] = $row->user;
            $json['suggestions'][] = $temp_row;
        }
        echo json_encode($json);
        exit();
    }

    /**
     * 指定用户的粉丝
     *
     * @param integer $uid
     */
    public function actionUidFans($uid)
    {
        $login_uid = ZCommonSessionFun::get_user_id();
        $this->layout = false;
        $uid = intval($uid);
        $this->view->title = User::getUidShowName($uid) . '的粉丝';
        $model = new UsersFriends();
        $condition['fuid'] = $uid;
        $data = $model->getList($condition, null, $this->pageSize);
        if (isset($_GET['ajax'])) {
            $status = 0;

            $html = '';
            if (isset($_GET[$data['pagination']->pageParam]) && $data['pagination']->pageCount < $_GET[$data['pagination']->pageParam]) {
                $data['models'] = [];
            }
            // ZCommonFun::print_r_debug($data);
            $my_fans_uids = ZCommonFun::listData($data['models'], 'uid', 'uid');
            $concer_data = [];
            if(count($my_fans_uids)>0){
                $my_fans_uids_str = implode(',', $my_fans_uids);
                $sql = <<<str

select uf.uid uf_uid,uf.fuid fans /*我关注的人*/,(
select count(id) from users_friends where uid=uf_uid and fuid=$login_uid
) fans_is_concern_ta /*uf.uid关注了他 */
,(
select count(id) from users_friends where uid=$login_uid and fuid=uf_uid
)ta_is_concern_fans /* 他关注了uf.uid */
,up.*
from users_friends uf
left join user_profile up on up.uid=uf.uid
where uf.uid in($my_fans_uids_str )
group by uf.uid

str;


                $query = new Query();
                $concer_data = $query->createCommand()->setSql($sql)->queryAll();
            }
//             ZCommonFun::print_r_debug($concer_data);
//             exit;
            foreach ($data['models'] as $key => $row) {
                $ta_url = Yii::$app->urlManager->createUrl([
                    'my/personal-page',
                    'uid' => $row->uid
                ]);
                $ta_nickname = User::getDefaultTaNickname();
                $ta_image    = User::getDefaultHead_image();
                $ta_intro    = User::getDefaultTaIntro();
                $concer_text = '关注';
                $is_find = false;
                foreach ($concer_data as $key2=>$row2){
                    if( $row->uid == $row2['uf_uid'] ){
                        !empty($row2['nickname']) ? $ta_nickname    = $row2['nickname']     : null;
                        !empty($row2['head_image']) ? $ta_image     = $row2['head_image']   : null;
                        !empty($row2['intro']) ? $ta_intro          = $row2['intro']        : null;
                        if( $row2['fans_is_concern_ta'] && $row2['ta_is_concern_fans'] ){
                            $url            = '';
                            $concer_text    = '相互关注';
                        }//当前用户已关注
                        else if( $row2['ta_is_concern_fans'] ){
                            $url            = '';
                            $concer_text    = '已关注';
                        }else {
                            $url = Yii::$app->urlManager->createUrl([
                                'my/concern',
                                'fuid' => $row->uid
                            ]);

                        }
                        $is_find = true;
                        break;
                    }
                }
                if(!$is_find){
                    $url = Yii::$app->urlManager->createUrl([
                        'my/concern',
                        'fuid' => $row->uid
                    ]);
                }


                $html .= <<<str
                <ul class="list" id="answer-view" style="margin:0;">
           <li class="diy-item"><a
					href="$ta_url"
					target="_blank">
						<figure class="cover">
							<img src="$ta_image"
								class="tuijian-img">
						</figure>
						<div class="diy-meta">
            				<div class="title mui-ellipsis">{$ta_nickname}</div>
            				<span class="iconfont icon-start-filled5"></span>
            				<div class="desc mui-ellipsis">{$ta_intro}</div>
            			</div>
				</a><a url="{$url}" class="play concern" onclick="concern(this)" data-ui="danger small icon-right">{$concer_text}<i class="iconfont icon-right"></i>
	</a>	</li>
                </ul>
str;
            }
            echo $html;
            exit();
        }

        return $this->render('fans', [
            'a_models' => $data['models'],
            'uid' => $uid,
            'ajax_url' => Yii::$app->urlManager->createUrl([
                'my/uid-fans',
                'uid' => $uid,
                'page' => '#page#',
                'ajax' => '1'
            ])
        ]);
    }

    /**
     * 指定用户关注的人
     *
     * @param integer $uid
     */
    public function actionUidConcern($uid)
    {
        $login_uid = ZCommonSessionFun::get_user_id();
        $this->layout = false;
        $uid = intval($uid);
        $this->view->title = User::getUidShowName($uid) . '关注的人';
        $model = new UsersFriends();
        $condition['uid'] = $uid;
        $data = $model->getList($condition, null, $this->pageSize);
        if (isset($_GET['ajax'])) {
            $status = 0;

            $html = '';
            if (isset($_GET[$data['pagination']->pageParam]) && $data['pagination']->pageCount < $_GET[$data['pagination']->pageParam]) {
                $data['models'] = [];
            }
            $my_fans_uids = ZCommonFun::listData($data['models'], 'fuid', 'fuid');
            $concer_data = [];
            if(count($my_fans_uids)>0){
                $my_fans_uids_str = implode(',', $my_fans_uids);
                $sql = <<<str

select uf.uid uf_uid,uf.fuid fans /*我关注的人*/,(
select count(id) from users_friends where uid=uf_uid and fuid=$login_uid
) fans_is_concern_ta /*uf.uid关注了他 */
,(
select count(id) from users_friends where uid=$login_uid and fuid=uf_uid
)ta_is_concern_fans /* 他关注了uf.uid */
,up.*
from users_friends uf
left join user_profile up on up.uid=uf.uid
where uf.uid in($my_fans_uids_str )
group by uf.uid

str;


                $query = new Query();
                $concer_data = $query->createCommand()->setSql($sql)->queryAll();
            }
            //             ZCommonFun::print_r_debug($concer_data);
            //             exit;
            // ZCommonFun::print_r_debug($data);
            foreach ($data['models'] as $key => $row) {
                $ta_url = Yii::$app->urlManager->createUrl([
                    'my/personal-page',
                    'uid' => $row->fuid
                ]);

                $ta_nickname = User::getDefaultTaNickname();
                $ta_image    = User::getDefaultHead_image();
                $ta_intro    = User::getDefaultTaIntro();
                $concer_text = '关注';
                $is_find = false;
                foreach ($concer_data as $key2=>$row2){
                    if( $row->fuid == $row2['uf_uid'] ){
                        !empty($row2['nickname']) ? $ta_nickname    = $row2['nickname']     : null;
                        !empty($row2['head_image']) ? $ta_image     = $row2['head_image']   : null;
                        !empty($row2['intro']) ? $ta_intro          = $row2['intro']        : null;
                        if( $row2['fans_is_concern_ta'] && $row2['ta_is_concern_fans'] ){
                            $url            = '';
                            $concer_text    = '相互关注';
                        }//当前用户已关注
                        else if( $row2['ta_is_concern_fans'] ){
                            $url            = '';
                            $concer_text    = '已关注';
                        }else {
                            $url = Yii::$app->urlManager->createUrl([
                                'my/concern',
                                'fuid' => $row->fuid
                            ]);

                        }
                        $is_find = true;
                        break;
                    }
                }
                if(!$is_find){
                    $url = Yii::$app->urlManager->createUrl([
                        'my/concern',
                        'fuid' => $row->fuid
                    ]);
                }



                $html .= <<<str
                <ul class="list" id="answer-view" style="margin:0;">
           <li class="diy-item"><a
					href="$ta_url"
					target="_blank">
						<figure class="cover">
							<img src="$ta_image"
								class="tuijian-img">
						</figure>
						<div class="diy-meta">
            				<div class="title mui-ellipsis">{$ta_nickname}</div>
            				<span class="iconfont icon-start-filled5"></span>
            				<div class="desc mui-ellipsis">{$ta_intro}</div>
            			</div>
				</a>
            	<a url="{$url}" class="play concern" onclick="concern(this)" data-ui="danger small icon-right">{$concer_text}<i class="iconfont icon-right"></i>
	</a>
            				    </li>
                </ul>
str;
            }
            echo $html;
            exit();
        }
        return $this->render('fans', [

            'uid' => $uid,
            'ajax_url' => Yii::$app->urlManager->createUrl([
                'my/uid-concern',
                'uid' => $uid,
                'page' => '#page#',
                'ajax' => '1'
            ])
        ]);
    }
}
