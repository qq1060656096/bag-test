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
/**
 * Site controller
 */
class MyController extends Controller
{
    public $pageSize= 10;
    /**
     * 我测试过的，有权限
     */
    public function actionMeTest(){
        $this->getView()->title = '我创建的测试';
        $this->pageSize = 1;
        $this->layout = false;
        $searchModel = new SurverySearch();
        $where = [];
        $uid = ZCommonSessionFun::get_user_id();
        $temp_data = $searchModel->getMyTest($uid, null, null, $this->pageSize);
        //列表
        if( isset($_GET['ajax']) ){
            return $this->render('my-test-list',[ 'a_models'=>$temp_data['models'],'pagination' =>$temp_data['pagination']]);
        }
        
        return $this->render('me-test',['a_models'=>$temp_data['models'],'uid'=>$uid,
            'ajax_url'=>Yii::$app->urlManager->createUrl(['my/me-test','page'=>'#page#','sort'=>1,'self'=>1,'ajax'=>1]),
        ]);
        
    }
    /**
     * 他测过的，无权限
     */
    public function actionMyTest($uid=0){
        $this->getView()->title = 'Ta测过的';
        
        $this->pageSize = 1;
        $uid = intval($uid);
        $uid = $uid>0 ? $uid : 0;
        
        
        $this->layout = false;
        $searchModel = new SurverySearch();
        $where = [];
        $temp_data = $searchModel->getMyTest($uid, null, null, $this->pageSize);
        //列表
        if( isset($_GET['ajax']) ){
            return $this->render('my-test-list',[ 'a_models'=>$temp_data['models'],'pagination' =>$temp_data['pagination']]);
        }
        
        return $this->render('my2',['a_models'=>$temp_data['models'],'uid'=>$uid,
            'ajax_url'=>Yii::$app->urlManager->createUrl(['my/my-test','page'=>'#page#','sort'=>1,'self'=>1,'ajax'=>1,'uid'=>$uid]),
        ]);
    }
    
    /**
     * 他人主页，无权限
     */
    public function actionPersonalPage($uid=0){
        $this->getView()->title = 'Ta创建的测试';
        $this->layout = false;
        $uid = intval($uid);
        $uid = $uid>0 ? $uid : 0;
//         $this->render('my2');
        
        $searchModel = new SurverySearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['SurverySearch']['uid'] = $uid;
        $queryParams['SurverySearch']['is_publish'] = 1;
        $query = $searchModel->query( $queryParams );
        
        $count = $query->count();
        //         echo $count;
        //分页
        $pagination = new Pagination();
        //每页现实数量
        $pagination->pageSize = $this->pageSize;
        //总数量
        $pagination->totalCount = $count;
        $offset = $pagination->getOffset();
        $limit = $pagination->getLimit();
        $query->offset($offset);
        $query->limit($limit);
        $query->orderBy(['id'=>SORT_DESC]);
        $a_models = $query->all();
      
        if( isset($_GET['ajax']) ){
            return $this->render('my-test-list',[ 'a_models'=>$a_models,'pagination' =>$pagination]);
        }
        
//         isset($a_models[0]) ? null : $a_models=[];
        return $this->render('my2', [
            'searchModel' => $searchModel,
            'a_models' => $a_models,
            'pagination'=>$pagination,
            'self' => 1,
            'ajax_url'=>Yii::$app->urlManager->createUrl(['my/personal-page','page'=>'#page#','sort'=>1,'self'=>1,'ajax'=>1,'uid'=>$uid]),
            'uid'=>$uid
        ]);
    }
    /**
     * 关注
     * @param number $fuid
     */
    public function actionConcern($fuid=0,$op=''){
        $uid = ZCommonSessionFun::get_user_id();
        $fuid = intval( $fuid );
        
//         $uid = 2;
//         $fuid = 2;
        
        if( $fuid < 1 ){
            ZCommonFun::output_json(null, 2, '参数错误');
        }
        
        //请登录
        if( $uid < 1 ){
            ZCommonFun::output_json(null, -1, '请登录');
        }
        $model_UsersFriends = new UsersFriends();
        $model_UsersFriends0 = $model_UsersFriends->get_user_friend($uid, $fuid);
        if( $model_UsersFriends0 ){
            if( $model_UsersFriends0->delete() ){
                ZCommonFun::output_json('关注', 0, '取消关注成功');
            }else{
                ZCommonFun::output_json(null, -2, '取消关注失败');
            }
            ZCommonFun::output_json(null, 1, '已关注');
        }
        
        $model_UsersFriends->uid = $uid;
        $model_UsersFriends->fuid = $fuid;
        $model_UsersFriends->created = date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);
        //关注成功
        if($model_UsersFriends->save()){
            ZCommonFun::output_json('已关注', 0, '关注成功');
        }
        ZCommonFun::output_json(null, -2, '关注失败' );
    }
}
