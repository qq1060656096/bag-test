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
use common\models\SurveyResulte;
use yii\caching\Cache;
use common\z\ZController;
use common\models\Question;
use common\models\QuestionOptions;
use yii\db\Transaction;
use frontend\models\SurveyOperation;
use frontend\models\frontend\models;
use common\z\ZCommonSessionFun;

/**
 * SurveyController implements the CRUD actions for Survey model.
 */
class SurveyController extends ZController
{
    public $pageSize = 2;

    /**
     * Lists all Survey models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->title = '最新';
        
        $sort = Yii::$app->request->get('sort',1);
        $this->view->title = $sort > 0 ?'最新' : '最热';
        $this->layout = false;
        $searchModel = new SurverySearch();
        $queryParams = Yii::$app->request->queryParams;
        
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
        //最新
        if($sort>0){
            $query->orderBy(['created'=>SORT_DESC]);
        }//最热
        else{
            $query->orderBy(['answer_count'=>SORT_DESC]);
        }
        $a_models = $query->all();
        
        $pageCount = $pagination->getPageCount();
        $page = Yii::$app->request->get('page',0);

        
//         echo $pageCount,'=',$page+1;
//         ZCommonFun::print_r_debug($pagination);
        
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
        }
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
        
        $pageCount = $pagination->getPageCount();
        $page = Yii::$app->request->get('page',0);
        //有数据,从第二页开始到最后一页
        if($pageCount>0 && $page>0 ){
//             echo $page,$pageCount;
            //超过最后一页
            if($page>$pageCount){
                return '';
            }
                foreach ($a_models as $key=>$row){
                   echo <<<str
<dl>
	<a href="./start.html">
		<dt>
			<img src="./bag-test/test-images/103754b6unkvhquepniein.jpg!50"
				alt="你有多怕谈恋爱：恋爱恐怖程度自评">
		</dt>
		<dd>
			<h3>{$row->id}{$row->title}</h3>
		</dd>
		<dd>{$row->intro}</dd>
		<dd>
			<span>测试过：{$row->answer_count}</span>
		</dd>
	</a>
</dl>                    
str;
                }    
               exit;       
        }
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
        $this->layout = false;
        $tax = Yii::$app->request->get('tax');
        $id = Yii::$app->request->get('id');
        //测试不存在
        if($id>0){
            $model  = Survey::findOne($id);
            if(!$model)
            return $this->redirect(['my']);
        }else{
            $model = new  Survey();
            $model->tax = $tax;
            $model->type=0;
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
            return $this->redirect(['step1_3','id'=>$model->id]);
            
            
        }
        
//         ZCommonFun::print_r_debug($model);
        return $this->render('step2', [
            'model' => $model,
            'tax'=>$tax,
        ]);
        
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
        //图片不存在
        $model_Images = Images::findOne($model->front_img);
        if(!$model_Images){
            $model_Images = new Images();
        }
        
        $load = $model_Images->load(Yii::$app->request->post());
        $model_Images->use_count=0;
//         print_r($model_Images);
        if($load){        
        
            if(empty($model_Images->image)){
                $model_Images->addError('image','请上传图片');
            }
            //设置测试封面
            //事物开始
            $transaction = Yii::$app->db->beginTransaction();
            try {
                
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
                                return $this->redirect(['step4','id'=>$model->id]); 
                            break;
                                        
                            //分数型心里测试
                            case 2:
                                return $this->redirect(['step4_2_question','id'=>$model->id]);
                                break;
                        
                            //跳转型心里测试
                            case 3:
                                return $this->redirect(['step4_3','id'=>$model->id]);
                                break;
                            default:
                                break;
                        }
                    }         
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
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
        if(!$model){
            $model = new Survey();
            if(!$model)
                return $this->redirect(['my']);
        }
        //查找问题
        $questionData = $model->findOneQuestion($model->id, 1, 0);
        $error = '';
        $posts = Yii::$app->request->post();
        //post提交
        $model_SurveyResulte = new SurveyOperation();
        $url = $model_SurveyResulte->step4_2_questionSave($posts, $id);
        if($url){
//             echo $url;
//             ZCommonFun::print_r_debug($url);
//             ZCommonFun::print_r_debug($posts);
//             exit;
            return $this->redirect($url);
        }
        
        return $this->render('step4_2_question',[
            'tax'=>$model->tax,
            'model'=>$model,
            'questionData'=>$questionData,
        ]);
    }
    
    /**
     * 分数型心里测试 结果
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
        //查询所有结果
        $condition['s_id'] = $id;
        $a_SurveyResulte = SurveyResulte::findAll($condition);
        isset($a_SurveyResulte[0]) ? null : $a_SurveyResulte=[];
        
        $model_SurveyResulte = new SurveyResulte();
        
        $posts = Yii::$app->request->post();
//         ZCommonFun::print_r_debug($posts);
        $model_SurveyResulte = new SurveyOperation();
        $url = $model_SurveyResulte->step4_2SaveResulteCondition2($posts, $condition, $id);
        if($url){
            return $this->redirect($url);
        }
//         ZCommonFun::print_r_debug($a_SurveyResulte);
        return $this->render('step4_2',[
            'model_SurveyResulte'=>$model_SurveyResulte,
            'a'=>$a_SurveyResulte,
            'tax'=>$model->tax,
            'model'=>$model,
        ]);
    }
    
    /**
     * 跳转型心里测试 结果
     */
    public function actionStep4_3($id){
        $model  = Survey::findOne($id);
        //没有找到
        if(!$model){
            $model = new Survey();
            if(!$model)
                return $this->redirect(['my']);
        }
        return $this->render('step4_3',[
            
        ]);
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
    public function actionCreate()
    {
        
        $model = new Survey();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Survey model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Survey model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

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
}
