<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;
use common\models\Survey;
use common\models\SurveyResulte;
use common\models\Question;
use common\models\QuestionOptions;
use common\z\ZCommonFun;
use yii\db\Query;
use yii\base\Model;
use common\models\SurverySearch;
use yii\data\Pagination;
use common\models\Answer;
use common\models\AnswerUser;
use common\models\AnswerOperation;
class AnswerController extends Controller{
    /**
     * 奇趣测试回答
     */
    public function actionStep1($id){
        $this->layout = false;
        $model = Survey::findOne($id);
        if(!$model){//没找到
            $model = new Survey();
        }
        
        $data = $model->FindAllQuestionsOptions($id);
        
        $q = new Question();
        $posts = Yii::$app->request->post();
        $result = null;
        if( isset($posts['name']) ){
            $name = isset($posts['name']) ? $posts['name'] : '';
            $year = isset($posts['birth']['year']) ? $posts['birth']['year'] : 2015;
            $month = isset($posts['birth']['month']) ? $posts['birth']['month'] : 1;
            $day = isset($posts['birth']['day']) ? $posts['birth']['day'] : 1;
            
            $birth = $year.$month.$day;
            $model_SurveyResulte = new SurveyResulte();
            //计算测试结果
            $result = $model_SurveyResulte->getStep1Result($id, $name, $birth);
            $model->answer_count = $model->randCount($model->answer_count);
            $model->save();
            
//             ZCommonFun::print_r_debug($result);
        }
//         ZCommonFun::print_r_debug($posts);
        return $this->render('step1',[
            'data'=>$data,
            'model'=>$model,
            'result'=>$result,
            'posts'=>$posts,
        ]);
    }
    
    /**
     * 分数型回答
     */
    public function actionStep2($id){
        $model = Survey::findOne($id);
        if(!$model){//没找到
            $model = new Survey();
        }
        
//         $data = $model->FindAllQuestionsOptions($id);
        $count = $model->getQuestionCount($id);
//         echo $count;
        $q = new Question();
        $posts = Yii::$app->request->post();
        
        
        if(isset($posts['save'])){
        
        }
//         ZCommonFun::print_r_debug($data);
        return $this->render('step2',[
//             'data'=>$data,
            'model'=>$model,
            'count'=>$count,
            'posts'=>$posts,
        ]);
    }
    
    /**
     * 分数型问题回答
     */
    public function actionStep2Answer($id,$page){
        
        $model = Survey::findOne($id);
        if(!$model){//没找到
            $model = new Survey();
        }
        $data = $model->findOneQuestion($id, 1, $page);
//         ZCommonFun::print_r_debug($data);
        $posts = Yii::$app->request->post();
        
        
        if(isset($posts['save'])){
        
        }
        
        return $this->render('step2_answer',[
                    'data'=>$data,
            'model'=>$model,
            'page'=>$page,
            'posts'=>$posts,
        ]);
    }
    
    
    /**
     * 分数型问题回答2
     */
    public function actionStep2Answer2($id){
        $this->layout = false;
        $model = Survey::findOne($id);
        if(!$model){//没找到
            $model = new Survey();
        }
        $data = $model->FindAllQuestionsOptions($id);
//                 ZCommonFun::print_r_debug($_POST);
        $posts = Yii::$app->request->post();
    
        $error = '';
        if(isset($posts['save'])){
            $op = count($posts['options'])>0 ? true :false;
            ZCommonFun::print_r_debug($posts);
//             ZCommonFun::print_r_debug($data['options']);
//             exit;
            $total_score = 0;
            $save =0;
            $result = null;
            //保存结果
            $transaction = Yii::$app->db->beginTransaction();
     
            try {
                $model_AnswerUser = new AnswerUser();
                $user_IP = !empty($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
                $user_IP = !empty($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
                $model_AnswerUser->table_id = $id;
                
                $model_AnswerUser->ip = $user_IP;
                if(!$model_AnswerUser->save()){
                    $error = '用户操作失败';
                    $transaction->rollBack();
                }else{             
                    foreach ( $data['options'] as $key=>$value){
                        foreach ($value as $option){
                            foreach ($posts['options'] as $question_id=>$row){
                                //找到选项
                                if($option->qo_id = $row[0]){
                                    $model_Answer = new Answer();
                                    $model_Answer->table_id = $id;
                                    $model_Answer->question_id = $option->question_id;
                                    $model_Answer->qo_id = $row[0];
                                    $model_Answer->answer_score = $option->option_score;
                                    $model_Answer->au_id = $model_AnswerUser->au_id;
                                    $total_score += $model_Answer->answer_score;
                                    $model_Answer->save() ? $save++:null;
                                  
                                }
                            }
                        }
                        
                        if( $save>0){
                                                      
//                             $transaction->commit();
                            //设置测试数量
                            $model->setAnswerCount($id);
                            $model_SurveyResulte = new SurveyResulte();
                            $result = $model_SurveyResulte->getStep2Result($id, $total_score);
                        }else{
                            $error = '没有选项';
                            $transaction->rollBack();
                        }
                    }
                }
            } catch (\Exception $e) {
                $error = '事物异常';
//                 ZCommonFun::print_r_debug($e);
                $transaction->rollBack();
            }
            
            
            
        }
        echo $error;
//         ZCommonFun::print_r_debug($result);
        return $this->render('step2_answer',[
            'data'=>$data,
            'model'=>$model,
            'error'=>$error,
            'posts'=>$posts,
        ]);
    }
    /**
     * 分数型问题答题结果
     */
    public function actionStep2Result($id){
        $model = Survey::findOne($id);
        if(!$model){//没找到
            $model = new Survey();
        }
    }
    
}