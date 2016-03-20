<?php

namespace frontend\controllers;

use Yii;
use common\models\Survey;
use common\models\SurverySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use common\z\ZCommonFun;
use common\models\Images;
use common\models\User;
use common\models\SurveyResulte;
use yii\caching\Cache;
use common\z\ZController;
use common\models\Question;
use common\models\QuestionOptions;
use yii\db\Transaction;
use frontend\models\SurveyOperation;
use frontend\models\frontend\models;
use common\z\ZCommonSessionFun;
use common\z\oauth\qq\QQ;
use common;
use yii\base\Model;
use common\models\OauthBind;
/**
 * SurveyController implements the CRUD actions for Survey model.
 */
class SurveyController extends ZController
{
    public $pageSize = 10;
    public function beforeAction($action){
        $no_login_actions = ['index','index-ajax'];
        $action_id = strtolower($action->id);
        if(in_array($action_id, $no_login_actions)){
            return true;
        }
        if( ZCommonSessionFun::get_user_id()<1 ){
            $url = Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlLoginUserStr,'gourl'=> $_SERVER['REQUEST_URI']]);
            return $this->redirect($url);
        }
        return true;
    }
    
    /**
     * Lists all Survey models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->title = '最新';
        if(isset($_GET['code'])){
            
            $qq = new QQ();
            $qq->is_mobile = true;
            $access_token = $qq->qq_callback();
            $zhao_uid = ZCommonSessionFun::get_user_id();
            $zhao_uid =  $zhao_uid>0 ? $zhao_uid : '';
//             echo $zhao_uid;
//                     ZCommonFun::print_r_debug($access_token);
//                     exit;
            $openid = $qq->get_openid();
            $qq = new QQ($access_token,$openid);
            $user_info = $qq->get_user_info();
            $model_User = new User();
            $return = $model_User->userBind('', '', $zhao_uid, $openid, OauthBind::typeQQ, $user_info['nickname'], $user_info['figureurl'],true);
            //绑定成功或者已经绑定
            if($return===0 || $return===1){
                $user = $model_User->operationData['user']->attributes;
                $user['nickname'] = $model_User->operationData['user_profile']->nickname;
                $user['head_image'] = $model_User->operationData['user_profile']->head_image;
                $user['openid'] = $openid;
                ZCommonSessionFun::set_user_session($user);
                //qq登录类型
                if(intval($zhao_uid)>0){
       
                    $bind_url = ['user-profile/bind-list'];
                    return $this->redirect($bind_url);
                }else{
                    ZCommonSessionFun::set_login_type(OauthBind::typeQQ);
                }
                return $this->redirect([ZCommonSessionFun::urlMyStr]);
            }
             
            ZCommonFun::print_r_debug( $model_User->operationData );
            
            exit;
        }
        $sort = Yii::$app->request->get('sort',0 );
        $this->view->title = $sort > 0 ?'最新' : '最热';
        if( $sort < 1 ){
            $this->view->title = ZController::$site_name.' : 可以自己创建测试的网站';
        }else{
            $this->view->title = ZController::$site_name.' : 最新';
        }
        
        $this->layout = false;
        $searchModel = new SurverySearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['SurverySearch']['is_publish'] = 1;
//         ZCommonFun::print_r_debug($queryParams);
//         ZCommonFun::print_r_debug(Yii::$app->request->queryParams);
//         ZCommonFun::print_r_debug($_POST);
        if(isset($_POST['SurverySearch']['title'])){
            $queryParams['SurverySearch']['title'] = $_POST['SurverySearch']['title'];
        }
        $search = false;
        if(isset($queryParams['SurverySearch']['title'])){
           $search = $queryParams['SurverySearch']['title'];
        }
        $query = $searchModel->query( $queryParams );
        
        $count = $query->count();
        
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
        $op_name = '';
        //最新
        if($sort>0){
            $query->orderBy(['created'=>SORT_DESC]);
            $op_name = '最新';
        }//最热
        else{
            $op_name = '最热';
            $query->orderBy(['answer_count'=>SORT_DESC]);
        }
        $a_models = $query->all();
        
        $pageCount = $pagination->getPageCount();
        $page = Yii::$app->request->get('page',0);

        $model_SurveyOperation = new SurveyOperation();
        $models_SurveyOperation = $model_SurveyOperation->getIsTop();
//         echo $pageCount,'=',$page+1;
//         ZCommonFun::print_r_debug($pagination);
        return $this->render('index2', [
            'models_SurveyOperation'=>$models_SurveyOperation,
            'searchModel' => $searchModel,
            'a_models' => $a_models,
            'pagination'=>$pagination,
            'sort'=>$sort,
            'op_name'=>$op_name,
            'search'=>$search,
        ]);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'a_models' => $a_models,
            'pagination'=>$pagination,
            'sort'=>$sort,
        ]);
    }
    
/**
     * Lists all Survey models.
     * @return mixed
     */
    public function actionIndexAjax()
    {
        $sort = Yii::$app->request->get('sort',1);
        $self = Yii::$app->request->get('self',0);
        $queryParams = Yii::$app->request->queryParams;
        
        if($self > 0){
            
            if(  ZCommonSessionFun::get_user_id()<1 ){
                $url = Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlLoginUserStr]);
                return $this->redirect($url);
            }
            $queryParams['SurverySearch']['uid'] = ZCommonSessionFun::get_user_id();
        }else{
            $queryParams['SurverySearch']['is_publish'] = 1;
        }
        $queryParams['SurverySearch']['is_publish'] = 1;
        $this->layout = false;
        $searchModel = new SurverySearch();
        
        $query = $searchModel->query( $queryParams );
        $count = $query->count();
        
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
        if($self > 0){
            $sort = 1;
        }
        //最新
        if($sort>0){
            $query->orderBy(['created'=>SORT_DESC]);
        }//最热
        else{
            $query->orderBy(['answer_count'=>SORT_DESC]);
        }
        $a_models = $query->all();
        $role = ZCommonSessionFun::get_role();
        $pageCount = $pagination->getPageCount();
        $page = Yii::$app->request->get('page',0);
        $data='';
        //有数据,从第1页开始到最后一页
        if($pageCount>0 && $page>0 ){
//             echo $page,$pageCount;
            //超过最后一页
            if($page>$pageCount){
                $tempData['data'] = $data;
                $tempData['status'] = 0;
                $tempData['message'] = '';
                echo json_encode($tempData);
                exit;
            }
                foreach ($a_models as $key=>$row){
                    if($row->tax==1){
                        $url = Yii::$app->urlManager->createUrl(['answer/step1','id'=>$row->id]);
                    }else{
                        $url = Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$row->id]);
                    }
               
                   $image = common\models\Survey::getImageUrl($row);
                   $is_top_text = '';
                   $is_top_url = '';
                   $op0 = Yii::$app->urlManager->createUrl(['survey/recommend','id'=>$row->id,'op'=>0]);
                   $op1 = Yii::$app->urlManager->createUrl(['survey/recommend','id'=>$row->id,'op'=>1]);
                   $is_top = 0;
                   if( $row->is_top > 0 ):
                       $is_top_text = '取消推荐';
                       $is_top = 0;
                   else:
                       $is_top_text = '推荐';
                       $is_top = 1;
                   endif;
                   $str_recommend = '';
                   if( $role == 1 ):
       				$str_recommend = <<<str
       				<a
       					is_top="{$is_top}" op0="{$op0}" op1="{$op1}"
       					class="play recommend" data-ui="danger small icon-right" style="right: 75px;"> {$is_top_text}<i
       						class="iconfont icon-right"></i>
       				</a>
str;
			
       				endif;
                   if($self>0){
                       $row_ur_done   = Yii::$app->urlManager->createUrl(['survey/done','id'=>$row->id]);
                       //发布
                       $row_ur_done_publish   = Yii::$app->urlManager->createUrl(['survey/done','is_ajax'=>1,'id'=>$row->id]);
                       $row_ur_change = Yii::$app->urlManager->createUrl(['survey/step2','id'=>$row->id]);
                   $data.=<<<str
                   <dl>
                   <a href="{$url}">
                   <dt>
                   <img src="{$image}"
                   alt="你有多怕谈恋爱：恋爱恐怖程度自评">
                   </dt>
                   <dd>
                   <h3>{$row->title}</h3>
                   </dd>
                   <dd>{$row->intro}</dd>
                   <dd>
                       <a class="btn_bg" href="{$row_ur_done}">预览</a>
    				      &nbsp; &nbsp;
    				      <a class="btn_bg ajax-publish" href="{$row_ur_done_publish}">发布</a>
    				      &nbsp;&nbsp;
    				    <a class="btn_bg" href="{$row_ur_change}">修改</a>
    					<span>测试过：{$row->answer_count}</span>
                   </dd>
                   
                   </a>
                   </dl>
str;
                   
                   }else{
                    $data.= <<<str
       

			    <li class="diy-item" date-id="2626"><a
					href="{$url}"
					target="_blank">
						<figure class="cover">
							<img class=""
								src="{$image}">
						</figure>
						<div class="diy-meta">
							<div class="title mui-ellipsis">{$row->title}</div>
							<span class="iconfont icon-start-filled5"></span> <span
								class="count">{$row->answer_count}人在测</span>
							<div class="desc mui-ellipsis">{$row->intro}</div>
						</div>
				</a> 
                   {$str_recommend}
				<a
					href="{$url}"
					class="play" data-ui="danger small icon-right"> 去测<i
						class="iconfont icon-right"></i>
				</a></li>
str;
                   }
                }    
                      
        }
        
        $tempData['data'] = $data;
        $tempData['status'] = 0;
        $tempData['message'] = '';
        echo json_encode($tempData);
        exit;
        
    }
    /**
     * 选择测试分类 1
     * @return \yii\base\string
     */
    public function actionStep1()
    {
        $this->layout = false;
//         $model = new Survey();
        return $this->render('step1', [
            
        ]);
    
    }

    /**
     * 奇趣测试 2
     * @return \yii\web\Response|\yii\base\string
     */
    public function actionStep2()
    {
        global $survey_tax;
//         ZCommonFun::print_r_debug($survey_tax);
//         exit;
        $this->layout = false;
        $tax = Yii::$app->request->get('tax');
        $id = Yii::$app->request->get('id');
        //测试不存在
        if($id>0){
            $model  = Survey::findOne($id);
            //没找到 不是自己的测试
            if(!$model || $model->uid != ZCommonSessionFun::get_user_id())
                return $this->redirect(['my']);
            
            $this->view->title = $model->title;
            $tax = $model->tax;
        }else{
            $model = new  Survey();
            $model->tax = $tax;
            $model->type=0;
            $this->view->title = isset( $survey_tax[$tax] ) ? $survey_tax[$tax] : '';
            $model->created = date('Y-m-d H:i:s');
        }
//         echo $tax;
        //post提交
        $is_post = false;
        if(isset($_POST['Survey'])){
            $is_post = true;
            isset($_POST['Survey']['title']) ? $model->title = $_POST['Survey']['title'] : null;
            isset($_POST['Survey']['intro']) ? $model->intro = $_POST['Survey']['intro'] : null;
            $model->uid = ZCommonSessionFun::get_user_id();
            
        }
        if( $is_post && $model->save()){
//             ZCommonFun::print_r_debug($model->attributes);
//             exit;
            $model->is_publish=0;
            $model->save();
            return $this->redirect(['step1_3','id'=>$model->id]);
            
//             return $this->redirect(['step-airthmetic','id'=>$model->id]);//跳转到算法
        }

        return $this->render('step2', [
            'model' => $model,
            'tax'=>$tax,
        ]);
        
    }
    
    /**
     * 设置算法
     * @return \yii\web\Response|\yii\base\string
     */
    public function actionStepAirthmetic()
    {
        $this->layout = false;
        $tax = Yii::$app->request->get('tax');
        $id = Yii::$app->request->get('id');
        //测试不存在
        if($id>0){
            $model  = Survey::findOne($id);
            //没找到 不是自己的测试
            if(!$model || $model->uid != ZCommonSessionFun::get_user_id())
                return $this->redirect(['my']);
        
            $this->view->title = $model->title;
            $tax = $model->tax;
        }
        if(isset($_POST['Survey']['arithmetic'])){
            //Survey[arithmetic]
            $model->arithmetic = $_POST['Survey']['arithmetic'];
            $model->save();
            $url = ['done','id'=>$id];//跳转到预览
            return $this->redirect($url);
        }
        $viewDdata['model'] = $model;
        return $this->render('step-airthmetic',$viewDdata);
    }
    /**
     * 测试封面图片
     * @return \yii\web\Response|\yii\base\string
     */
    public function actionStep1_3($id)
    {
        $this->layout = false;
        $model  = Survey::findOne($id);
        //没有找到
        if(!$model){    
            $model = new Survey();
            if(!$model)
                return $this->redirect(['my']);
        }
        $this->view->title = $model->title;
        //图片不存在
        $model_Images = Images::findOne($model->front_img);
        if(!$model_Images){
            $model_Images = new Images();
            $model_Images->use_count=0;
        }
        
       //&& !empty($_POST['image'])
        if(isset($_POST['image']) ){
            $load = true;
//             ZCommonFun::print_r_debug($_POST);
//             exit;
            $fileName = $_POST['image'];
            
            $model_Images->image = $fileName ? $fileName : $model_Images->image;
//             if(empty($model_Images->image)){
//                 $model_Images->addError('image','请上传图片');
//             }
            //设置测试封面
            //事物开始
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->is_publish=0;
                //图片保存
                $model_Images->use_count++;
                if(count($model_Images->errors)<1&& $model_Images->save() ){
                    //设置测试封面
                    $model->front_img = $model_Images->id;
                    if ($model->save()){
                        $transaction->commit();
                
                        switch ( $model->tax ){
                            //奇趣测试
                            case 1:
                                //跳转到添加测试结果
                                return $this->redirect(['step4_2','id'=>$model->id]);
                                break;
                
                                //分数型心里测试
                            case 2:
                                return $this->redirect(['step4_2_question','id'=>$model->id]);
                                break;
                
                                //跳转型心里测试
                            case 3:
                                return $this->redirect(['step4_2_question','id'=>$model->id]);
                                break;
                            default:
                                break;
                        }
                    }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
//             ZCommonFun::print_r_debug($arr);
//             exit;
        }
        
//         ZCommonFun::print_r_debug($model_Images);
        return $this->render('step1_3', [
            'model_Images' => $model_Images,
            'tax'=>$model->tax,
            'model'=>$model,
        ]);
    
    }
    
    /**
     * 奇趣测试 结果
     */
    public function actionStep4($id){
        $this->layout = false;
        $model  = Survey::findOne($id);
        //没有找到
        if(!$model){    
            $model = new Survey();
            if(!$model)
                return $this->redirect(['my']);
        }
        //查询所有结果
        $condition['s_id'] = $id;
        $a_SurveyResulte = SurveyResulte::findAll($condition);
        isset($a_SurveyResulte[0]) ? null : $a_SurveyResulte=[];
        
        $model_SurveyResulte = new SurveyResulte();
        
        $post = Yii::$app->request->post();
        
        //保存结果
        $model_SurveyResulte = new SurveyOperation();
        $url = $model_SurveyResulte->step4SaveResulteCondition1($post, $condition, $id);
        if($url){
            $model->is_publish = 1;
            $model->save();
            return $this->redirect($url);
        }
        
        
//         ZCommonFun::print_r_debug($post_data);
//         exit;
        return $this->render('step4', [
            'model_SurveyResulte'=>$model_SurveyResulte,
            'a_SurveyResulte'=>$a_SurveyResulte,
            'tax'=>$model->tax,
            'model'=>$model,
        ]);
    }
    
    /**
     * 分数型心里测试 问题
     */
    public function actionStep4_2_question($id){
        
        $this->layout = false;
        $model  = Survey::findOne($id);
        //没有找到
        if(!$model || $model->uid!=ZCommonSessionFun::get_user_id() ){
            $model = new Survey();
            if(!$model )
                return $this->redirect(['my']);
        }
        $page = Yii::$app->request->get('page',1);

        //查找问题
        $questionData = $model->findOneQuestion($model->id, 1, $page-1);


        $error = '';
        $posts = Yii::$app->request->post();
        //post提交
        $model_SurveyResulte = new SurveyOperation();
  
        $url = $model_SurveyResulte->step4_2_questionSave($posts, $id,$page);
        
        if( $url || (isset($_POST['save']) &&$questionData['count']>0) ){
            
//             ZCommonFun::print_r_debug($url);
//             ZCommonFun::print_r_debug($posts);
//             ZCommonFun::print_r_debug($model);
//             exit;
   
            $model->is_publish=0;
            $model->save();
            switch ( $model->tax ){
                    //分数型心里测试
                case 2:
                    if(isset($posts['save-next'])){
                       
                        return $this->redirect($url);
                    }
                    else{
                        
                        return $this->redirect(['step4_3','id'=>$model->id]);
                    }
                    break;
            
                    //跳转型心里测试
                case 3:
                    
                   if(isset($posts['save-next'])){
                       
                        return $this->redirect($url);
                    }
                    else{
                          return $this->redirect(['step4_2','id'=>$model->id]);
                    } 
                    break;
                default:
                    break;
            }
        }
        
        return $this->render('step4_2_question',[
            'tax'=>$model->tax,
            'model'=>$model,
            'page'=>$page,
            'questionData'=>$questionData,
        ]);
    }
    /**
     * 删除
     */
    public function actionQuestionDelete($id,$page){
        $id = intval($id);
        $page= intval($page);
        $this->layout = false;
        $id >0 ? $model  = Survey::findOne($id) : $model=false;
        //没有找到
        if(!$model || $model->uid!=ZCommonSessionFun::get_user_id() ){
            if(!$model )
                return $this->redirect(['my']);
        }
        //查找问题
        $questionData = $model->findOneQuestion($model->id, 1, $page-1);
//         ZCommonFun::print_r_debug($questionData);
//         ZCommonFun::print_r_debug($questionData['question']);
//         ZCommonFun::print_r_debug($questionData['options']);
        if(isset($questionData['question']->question_id)){
            $qustion_id = $questionData['question']->question_id;
            //删除问题
            if($questionData['question']->delete()){
                //删除选项
                $model_QuestionOptions = new QuestionOptions();
                $condition['question_id'] = $qustion_id;
                //删除选项
                $model_QuestionOptions->deleteAll($condition);
            }
        }
        $model->is_publish=0;
        $model->save();
        $this->redirect(['survey/step4_2_question','id'=>$id]);
    }
    
    /**
     * 删除测试结果
     */
    public function actionResultDelete($id,$page){
        $id = intval($id);
        $page= intval($page);
        $this->layout = false;
        $id >0 ? $model  = Survey::findOne($id) : $model=false;
        //没有找到
        if(!$model || $model->uid!=ZCommonSessionFun::get_user_id() ){
            if(!$model )
                return $this->redirect(['my']);
        }
        $model_SurveyResulte = new SurveyResulte();
        $model_SurveyResulteDetail = $model_SurveyResulte->findOneSurveyResulte($id, 1, $page-1);
//         ZCommonFun::print_r_debug($model_SurveyResulteDetail);
        //删除
        if( isset($model_SurveyResulteDetail['SurveyResulte']->sr_id ) ){
            $model_SurveyResulteDetail['SurveyResulte']->delete();
        }
        $model->is_publish=0;
        $model->save();
        $this->redirect(['survey/step4_2','id'=>$id,'page'=>1]);
    }
    /**
     * 测试结果保存
     */
    public function actionStep4_2($id){
        $this->layout = false;
        $model  = Survey::findOne($id);
        //没有找到
        if(!$model){    
            $model = new Survey();
            if(!$model)
                return $this->redirect(['my']);
        }
        $page = Yii::$app->request->get('page',1);
        
        $model_SurveyResulte = new SurveyResulte();
        $model_SurveyResulteDetail = $model_SurveyResulte->findOneSurveyResulte($id, 1, $page-1);
        $model_SurveyResulte = $model_SurveyResulteDetail['SurveyResulte'] ? $model_SurveyResulteDetail['SurveyResulte'] : new SurveyResulte();
//            ZCommonFun::print_r_debug($model_SurveyResulteDetail);
//         exit;
        $limit_score_start = 0;
        $limit_score_end   = 0;
    
        if($model->tax==2){
            //获取所有测试结果
            $model_SurveyResulte_all = new SurveyResulte();
            $model_SurveyResulte_all = $model_SurveyResulte_all->findOneSurveyResulte($id, $page-1, 0,false,true);
//             ZCommonFun::print_r_debug($model_SurveyResulte_all);
//             exit;
            
            foreach ($model_SurveyResulte_all['SurveyResulte'] as $key=>$row){
                $limit_score_start = $row->score_min;
                $limit_score_end = $row->score_max;
            }
        }
        //保存
        if( isset($_POST['SurveyResulte']) ){
//             ZCommonFun::print_r_debug($_POST);
//                        ZCommonFun::print_r_debug($model_save_SurveyResulte);
//                        exit;
           $sr_id = isset($_POST['sr_id']) ? $_POST['sr_id'] : 0;
           $model_save_SurveyResulte = new SurveyResulte();
           
           if( $sr_id > 0 ){
               $model_save_SurveyResulte = $model_save_SurveyResulte->findOne($sr_id);
               //本事当前问卷的结果
               if($model_save_SurveyResulte&& $model_save_SurveyResulte->s_id!=$id){
                   $model_save_SurveyResulte = null;
               }
           }
           
//            ZCommonFun::print_r_debug($_POST);
           $model_save_SurveyResulte ? null : new SurveyResulte();
           $model_save_SurveyResulte->s_id=$id;
           $model_save_SurveyResulte->load($_POST);
           //删除老的图片
           if( !empty($model_save_SurveyResulte->oldAttributes['image']) &&$model_save_SurveyResulte->image!= $model_save_SurveyResulte->oldAttributes['image']){
               @unlink(UPLOAD_DIR.$model_save_SurveyResulte->oldAttributes['image']);
           }
           $model_save_SurveyResulte->uid = ZCommonSessionFun::get_user_id();
           //保存成功
           $resulte = $model_save_SurveyResulte->save();    
           
//            ZCommonFun::print_r_debug($_POST);
//            ZCommonFun::print_r_debug($model_save_SurveyResulte);
//            exit;
           if($resulte){
               $model->is_publish=0;
               $model->save();
               //添加下一个结果
               if(isset($_POST['save-next'])){
                   $url = \Yii::$app->urlManager->createUrl(['survey/step4_2','id'=>$id,'page'=>$page]);
                   $this->redirect($url);
               }//保存结果完成
               else{
                   if($model->tax==3){
                       $url = ['step4_4','id'=>$model->id];
                       return $this->redirect($url);
                   }
                   
                   if($model->tax==1){
                       $url = \Yii::$app->urlManager->createUrl(['survey/step-airthmetic','id'=>$id]);//跳转算法
                       return $this->redirect($url);
                   }
                   $url = \Yii::$app->urlManager->createUrl(['survey/done','id'=>$id]);//跳转预览              
                   return $this->redirect($url);
                   
               }
           }
        }

        
       /*  $model_SurveyResulte = new SurveyOperation();
        $url = $model_SurveyResulte->step4_2SaveResulteCondition2($posts, $condition, $id);
        if($url){
            $model->is_publish = 1;
            $model->save();
            if($model->tax==3){
                $url = ['step4_4','id'=>$model->id];
                return $this->redirect($url);
            }
            return $this->redirect($url);
        } */
//         ZCommonFun::print_r_debug($a_SurveyResulte);
// ZCommonFun::print_r_debug($model_SurveyResulteDetail);
// exit;
        //可选最大总分数
        $question_total_score       = $model_SurveyResulteDetail['question']['question_total_score'];
        ////可选最小分数
        $question_total_min_score   = $limit_score_end;
        //如果已经设置分数限制，
        $limit_score_end> 0 ? $question_total_min_score+=1 : $question_total_min_score = $model_SurveyResulteDetail['question']['question_total_min_score'];
//         echo $limit_score_start,'-',$limit_score_end,'<br/>';
//         echo $question_total_min_score,'-',$question_total_score,'<br/>';
//         exit;
        return $this->render('step4_2survey_resulte',[
            'model_SurveyResulte'=>$model_SurveyResulte,
            'a'=>array(),
            'tax'=>$model->tax,
            'model'=>$model,
            'page'=>$page,
            'count'=>$model_SurveyResulteDetail['count'],
            'model_SurveyResulteDetail'=>$model_SurveyResulteDetail,
            'question_total_score'=>$question_total_score,
            'question_total_min_score'=>$question_total_min_score,//可选最小分数
            
        ]);
    }
    
    /**
     * 跳转型心里测试 结果
     */
    public function actionStep4_3($id){
        $this->layout = false;
        $model  = Survey::findOne($id);
        //没有找到
        if(!$model){
            $model = new Survey();
            if(!$model)
                return $this->redirect(['my']);
        }
        $data = $model->FindAllQuestionsOptions($id);
        $posts = Yii::$app->request->post();
        
        //post提交
        if(isset($posts['save'])){
            $model->is_publish=0;
            $model->save();
//             ZCommonFun::print_r_debug( $data );
            isset($data['options'][0]) ? null:$data['options']=[];
            foreach ( $data['options'] as $key=>$row ){
                if( !isset( $row[0] ) )
                    continue; 
                foreach ($row as $key2=>$row_option){
                    if(isset($posts['option']["{$row_option->qo_id}"])&& $posts['option']["{$row_option->qo_id}"] >$key+1){
                        $row_option->skip_question=$posts['option']["{$row_option->qo_id}"];
                        $row_option->save();
                    }
                    
                }
                
            }
            //跳转型心里测试
            if($model->tax==3){
                $url = ['step4_3_question','id'=>$id];
                return $this->redirect($url);
            }else{
                $url = ['step4_2','id'=>$id];
                return $this->redirect($url);
            }
            //                 ZCommonFun::print_r_debug($row_option);
            //                 exit;
        }
//         ZCommonFun::print_r_debug( $posts );
        return $this->render('step4_3',[
            'a_SurveyResulte'=>'',
            'data'=>$data,
            'model'=>$model,
        ]);
    }
    
    /**
     * 跳转型心里测试 结果选择
     */
    public function actionStep4_4($id){
        $this->layout = false;
        $model  = Survey::findOne($id);
        //没有找到
        if(!$model){
            $model = new Survey();
            if(!$model)
                return $this->redirect(['my']);
        }
        $model_SurveyResulte = new SurveyResulte();
        //获取调查所有的结果
        $models_SurveyResulte = $model_SurveyResulte->getAll($id) ;
        isset( $models_SurveyResulte[0] ) ?  : $models_SurveyResulte = array();
        //获取所有问题选项
        $data = $model->FindAllQuestionsOptions($id);
        $posts = Yii::$app->request->post();
        //post提交
        if( isset($posts['option'])|| isset($posts['resulte']) ){
//             ZCommonFun::print_r_debug( $data );
//             ZCommonFun::print_r_debug($posts);
//             exit;
            isset($data['options'][0]) ? null:$data['options']=[];
            foreach ( $data['options'] as $key=>$row ){
                if( !isset( $row[0] ) )
                    continue; 
                foreach ($row as $key2=>$row_option){
                    $is_save = false;
                    if(isset($posts['option']["{$row_option->qo_id}"])&& $posts['option']["{$row_option->qo_id}"] >$key+1){
                        $row_option->skip_question=$posts['option']["{$row_option->qo_id}"];
                        
                        $is_save = true;
                    }
                    if(isset($posts['resulte']["{$row_option->qo_id}"])){
                        $row_option->skip_resulte=$posts['resulte']["{$row_option->qo_id}"];
                        $is_save= true;
                    }
                    $row_option->save();
                }
                
            }
//             $model->is_publish = 1;
            $url = ['done','id'=>$id];//跳转到预览
//                 $url = ['step-airthmetic','id'=>$id];//选择算法
            return $this->redirect($url);
            //                 ZCommonFun::print_r_debug($row_option);
            //                 exit;
        }
//         ZCommonFun::print_r_debug( $posts );
        return $this->render('step4_4',[
            'a_SurveyResulte'=>'',
            'data'=>$data,
            'model'=>$model,
            'models_SurveyResulte'=>$models_SurveyResulte
        ]);
    }
    
    /**
     * 创建测试完成
     * @param integer $id
     */
    public function actionDone($id){
        $this->layout = false;
        $viewData = array();
        $model  = Survey::findOne($id);
        //没有找到
        if(!$model){
            $model = new Survey();
            if(!$model)
                return $this->redirect(['my']);
        }
        $message = '';
        $viewData['question_all'] = $model->FindAllQuestionsOptions($id);
        $model_SurveyResulte = new SurveyResulte();
        //获取调查所有的结果
        $viewData['result_all'] = $model_SurveyResulte->getAll($id) ;
        $viewData['model'] = $model;
        if(isset($_POST['save'])){
            //检测是否能发布
            $check_arr = $this->checkPublish($viewData['question_all'], $model, $viewData['result_all']);
            $message .= isset($check_arr[0]) && $check_arr[0]>0 ? '包含'.$check_arr[0].'组敏感词,':'';
            $message .= $message==''&& isset($check_arr[1]) && $check_arr[1]>0 ? '包含'.$check_arr[1].'项未填写,':'';
            $message .= $message==''&& isset($check_arr['message']) && !empty($check_arr['message']) ? $check_arr['message']:'';
            $message ? $message.='不能发布。':null;
//             ZCommonFun::print_r_debug($check_arr);
//             exit;
            if($message==''){
                $model->is_publish=1;
                if($model->save()){
                    $message='发布成功';
                    return $this->redirect(['survey/index','sort'=>1]);
                }else{
                   $message='发布失败';
                } 
            }
            //ajax发布
            if(isset($_GET['is_ajax']) && $_GET['is_ajax'] ){
                $this->layout = false;
                $json['message'] = $message; 
                header('Content-type: application/json');
                echo json_encode($json);
//                 ZCommonFun::print_r_debug($json);
                exit;
            }
 
        }
        
        $viewData['message'] = $message;
        return $this->render('done',$viewData);
    }
    
    
  
    /**
     * 我的测试
     */
    public function actionMy(){
        $this->layout = false;
        if( ZCommonSessionFun::get_user_id()<1 ){
            $url = Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlLoginUserStr]);
            return $this->redirect($url);
        }
        $searchModel = new SurverySearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['SurverySearch']['uid'] = ZCommonSessionFun::get_user_id();
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
        
        return $this->render('my2', [
            'searchModel' => $searchModel,
            'a_models' => $a_models,
            'pagination'=>$pagination,
            'self' => 1,
        ]);
        
    }
    

    /**
     * Creates a new Survey model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionCreate()
//     {
        
//         $model = new Survey();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Updates an existing Survey model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//     public function actionUpdate($id)
//     {
        

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Deletes an existing Survey model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

    /**
     * Finds the Survey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Survey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Survey::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * 检测发布
     */
    public function checkPublish($question_all,$model,$result_all){
        $message = '';
        isset($question_all['questions'][0]) ? null:$question_all['questions']=[];
        if($model->tax>1){
            !isset($question_all['questions'][0]) ?$message='至少包含一个问题,':null;
        }
        isset($question_all['options'][0]) ? null:$question_all['options']=[];
        isset($result_all[0]) ? null:$result_all=[];
        
        $replace_prefix = '<b class="replace_word" style="color: blue;">';
        $replace_self = false;
        $replace_suffix = '</b>';
        $replace = true;
        
        $all_count = 0;//敏感词数量
        $all_count_empty = 0;//未填写项
        $all_question_empty = 0; //空问题数量
        $all_question_option_empty = 0;//空选项数量
        ZCommonFun::replace_filter_words($model->title, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
        $all_count+=$replace_count;
        ZCommonFun::replace_filter_words($model->intro, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
        $all_count+=$replace_count;
        empty($model->title)?$all_count_empty++:null;
        empty($model->intro)?$all_count_empty++:null;
        //问题
        $index=0;
        
        foreach ($question_all['questions'] as $key=>$question){
            $index++;
            $label = $question->label;
            $replace_count = 0;
            $label = ZCommonFun::replace_filter_words($label, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
            $all_count+=$replace_count;
            $error = !empty($label) ? '' : '问题不能为空';
            $error ? $all_count_empty++:null;
            isset($question_all['options'][$key]) ? null : $question_all['options'][$key]=[];
            if(count($question_all['options'][$key])<1){
                $all_count_empty++;
            }
            foreach ($question_all['options'][$key] as $key2=>$question_option){
                $option_label = $question_option->option_label;
                $option_label =  ZCommonFun::replace_filter_words($option_label, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
                $all_count+=$replace_count;
                $error_option_label = !empty($option_label) ? '':'选项不能为空';
                $error_option_label ? $all_count_empty++:null;
                $speparator = $question_option->skip_question>0 || $question_option->skip_resulte>0 ? '——' :'';
                $skip_text = '';
            
                $question_option->skip_question>0 ? $skip_text="转{$question_option->skip_question}题":'';
                $question_option->skip_resulte>0 ? $skip_text="转{$question_option->skip_question}结果":'';
                $score_text='';
                if($model->tax==2){
                    $score_text='—('.$question_option->option_score.'分)';
                }
            }
        }
        $index = 0;
        !isset($result_all[0])?$message.='至少包含一个测试结果':'';
        foreach ($result_all as $key=>$result){
            $index++;
            $name          = $result->name;
            $name =  ZCommonFun::replace_filter_words($name, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
            $all_count+=$replace_count;
            $error_name    = !empty($name) ? '' : '姓名之前不能为空';
            $error_name    ? $all_count_empty++:null;
            $value         = $result->value;
            $value =  ZCommonFun::replace_filter_words($value, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
            $all_count+=$replace_count;
            $error_value   = !empty($value) ? '' : '姓名之后不能为空';
            $error_value   ? $all_count_empty++:null;
            $intro         = $result->intro;
            $intro =  ZCommonFun::replace_filter_words($intro, $replace_prefix, $replace_self, $replace_suffix, $replace,$replace_count) ;
            $all_count+=$replace_count;
            $error_intro   = !empty($intro) ? '' : '结果详情不能为空';
            $error_intro   ? $all_count_empty++:null;
            $image         = $result->image;
            $error_image   = !empty($image) ? '' : '图片不能为空';
            $error_image   ? $all_count_empty++:null;
            $image = SurveyResulte::getImageUrl($result);
            $score_text='';
            if($model->tax==2){
                $score_text=''.$result->score_min.'分~~'.$result->score_max.'分';
            }
        }
        
        return [$all_count,$all_count_empty,'message'=>$message];
    }
    /**
     * 推荐
     * @return \yii\web\Response
     */
    public function actionRecommend($id,$op){
        $this->layout = false;
        $model  = Survey::findOne($id);
        if(ZCommonSessionFun::get_user_id()<1){
            ZCommonFun::output_json(null, -1, '请登录');
        }
        if(ZCommonSessionFun::get_role()!=1){
            ZCommonFun::output_json(null, 2, '管理员才能操作');
        }
        //没有找到
        if(!$model){
            ZCommonFun::output_json(null, 1, '测试不存在');
            $model = new Survey();
        }
        //推荐
        $model->is_top = $op==1 ? $_SERVER['REQUEST_TIME'] : 0;
        if($model->save()){
            ZCommonFun::output_json(null, 0, '操作成功');
        }
        ZCommonFun::output_json(null, -2, '操作失败');
    }
    /**
     * 获取步数量
     * @param integer $tax
     * @return number
     */
    public static function stepCount($tax){
        static $data;
        if(!$data):
            $data['1']['step'] = 5;
            $data['2']['step'] = 6;
            $data['3']['step'] = 6;
        endif;
        
        $return = isset($data[$tax]['step']) ?  $data[$tax]['step'] : 0;
        return $return;
    }
}
