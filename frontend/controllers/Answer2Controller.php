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
class Answer2Controller extends Controller{
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
        //查找answer操作
        $aid = Yii::$app->request->get('aid',0);
        $aid = (int)$aid;
        $model_Answer = null;
        if($aid>0){
            $model_Answer = new Answer();
            $model_Answer = $model_Answer->findOne(['a_id'=>$aid,'table_id'=>$id]);
        }
        $result = null;
        if( ( isset($posts['name']) && !empty($posts['name'])) || $model_Answer){
            if(isset($posts['name'])){
                $model->save();
                $model_Answer = new Answer();
                $model_Answer->table_id = $id;
                $model_Answer->value = $posts['name'];
                $model_Answer->save();
            }else{
                $posts['name'] = $model_Answer->value;
            }
//             ZCommonFun::print_r_debug($posts['name']);
//             ZCommonFun::print_r_debug($model_Answer);
//             exit;
            $name = isset($posts['name']) ? $posts['name'] : '';
            $year = isset($posts['birth']['year']) ? $posts['birth']['year'] : 2015;
            $month = isset($posts['birth']['month']) ? $posts['birth']['month'] : 1;
            $day = isset($posts['birth']['day']) ? $posts['birth']['day'] : 1;
            
            $birth = $year.$month.$day;
            $model_SurveyResulte = new SurveyResulte();
            //计算测试结果
            $result = $model_SurveyResulte->getStep1Result($id, $name, $birth);
            $model->answer_count = $model->randCount($model->answer_count);
            
            
//             ZCommonFun::print_r_debug($result);
            return $this->render('step1_post',[
                'data'=>$data,
                'model'=>$model,
                'result'=>$result,
                'posts'=>$posts,
                'model_Answer'=>$model_Answer,
            ]);
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
        if(isset($posts['save']) ){
            $op = count($posts['options'])>0 ? true :false;
            $result_id = isset($posts['resulte']) ? intval($posts['resulte']):0;
//             echo $result_id;
//             ZCommonFun::print_r_debug($posts);
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
                $model_AnswerUser->sid = $id;
                //直接跳转答案
                if($result_id>0){
                    $model_AnswerUser->table = 'survey_resulte';
                    $model_AnswerUser->table_id = $result_id;
                }
                
                
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
                                    $model_Answer->answer_score += $option->option_score;
                                    $model_Answer->au_id = $model_AnswerUser->au_id;
                                    $total_score += $model_Answer->answer_score;
                                    $model_Answer->save() ? $save++:null;
                                  
                                }
                            }
                        }
                        
                        
                    }
                    
                    if( $save>0){
                    
                        //                             $transaction->commit();
                        //设置测试数量
                        $model->setAnswerCount($id);
                        return $this->redirect(['show-resulte','auid'=>$model_AnswerUser->au_id]);
                    }else{
                        $error = '没有选项';
                        $transaction->rollBack();
                    }
                }
            } catch (\Exception $e) {
                $error = '事物异常';
                ZCommonFun::print_r_debug($e);
                $transaction->rollBack();
            }
            
            
            
        }
//         echo $error;
//         exit;
//         ZCommonFun::print_r_debug($result);
        return $this->render('step2_answer',[
            'data'=>$data,
            'model'=>$model,
            'error'=>$error,
            'posts'=>$posts,
        ]);
    }
    /**
     * 显示结果
     * @return \yii\base\string
     */
    public function actionShowResulte(){
        //查找answer操作
        $auid = Yii::$app->request->get('auid',0);
        $auid = (int)$auid;
        $model_Answer = new Answer();
        if($auid>0){
            $model_AnswerUser = new AnswerUser();
            $model_AnswerUser = $model_AnswerUser->findOne(['au_id'=>$auid]);
        
            //如果已经有回答者了，直接显示
            if($model_AnswerUser){
                $id = $model_AnswerUser->table_id;
                $model_SurveyResulte = new SurveyResulte();
                //如果直接选择了答案
                if($model_AnswerUser->table == 'survey_resulte' && $model_AnswerUser->table_id>0){
                    $result = $model_SurveyResulte->findOne(['sr_id'=>$model_AnswerUser->table_id]);
                }else{
                    $result = $model_SurveyResulte->getStep2Result($id, $model_AnswerUser->answer_score);
                }
        
                $model = \common\models\Survey::findOne(['id'=>$id]);
                $model? : $model= new \common\models\Survey();
                return $this->render('step2_answer_post',[   
                    'model'=>$model,
                    'result'=>$result,
                    'model_Answer'=>$model_AnswerUser
                ]);
            }
        }
    }
    
}