<?php
namespace frontend\models;
use yii;
use common\models\Survey;
use common\models\SurveyResulte;
use common\models\Question;
use common\models\QuestionOptions;
use common\z\ZCommonFun;
use common\z\ZCommonSessionFun;
/**
 * 问卷
 * @author drupal
 *
 */
class SurveyOperation extends Survey{
    public $errorResulte = '';
    
   
    /**
     * 奇趣测试保存条件
     * @param unknown $post
     * @param unknown $condition
     * @param unknown $id
     * @return Ambigous <string, multitype:string >
     */
    public function step4SaveResulteCondition1($post,$condition,$id){
        $url = '';
        $post_data = [];
        if(isset($post['name'][0])){
            foreach ($post['name'] as $key=>$name){
                $value = isset($post['value'][$key]) ? $post['value'][$key] : '';
                if( isset($value[0])&& isset($name[0]) ){
                    $post_data[$key]['name'] = $name;
                    $post_data[$key]['value'] = $value;
                    isset($post['sr-id'][$key])? $post_data[$key]['sr-id'] = $post['sr-id'][$key] : null;
                }
            }
            //删除结果
            $deleteSurveyResulte = new SurveyResulte();
            $deleteAll = $deleteSurveyResulte->getAll($id);
            isset($deleteAll[0]) ?  null : $deleteAll=[];
            $sr_ids = ZCommonFun::listData($deleteAll, 'sr_id', 'sr_id');
            
//             ZCommonFun::print_r_debug($sr_ids);
//             ZCommonFun::print_r_debug($post_data);
//             exit;
            
            //有结果
            if($post_data){
                //保存结果
                $transaction = Yii::$app->db->beginTransaction();
                
                $save=0;
                try {
                    foreach ($post_data as $key=>$row){
                        if( isset( $row['sr-id']) && $row['sr-id']>0 ){
                            $row_SurveyResulte = SurveyResulte::findOne($row['sr-id']);
                            if($row_SurveyResulte ){
                                
                                //结果存在，就不删除
                                unset($sr_ids[$row['sr-id']]);
                                if($row_SurveyResulte->s_id != $id){
                                    continue;
                                }
                               $save ++ ;
                            }else{
                                $row_SurveyResulte = new SurveyResulte();
                            }
                        }else{
                            $row_SurveyResulte = new SurveyResulte();
                        }
                        $row_SurveyResulte->name = $row['name'];
                        $row_SurveyResulte->value = $row['value'];
                        $row_SurveyResulte->s_id = $id;
                        
                        $row_SurveyResulte->uid = ZCommonSessionFun::get_user_id(); 
                        $row_SurveyResulte->save() ? $save++:null;
                    }
                    if($save>0){
                        $condition = null;
                        if(count($sr_ids)>0){
                            $condition['sr_id'] = $sr_ids;
                            $condition['s_id'] = $id;
                            //删除所有结果
                            SurveyResulte::deleteAll($condition);
                        }
                        $transaction->commit();
                        $url=['my'] ;
                    }else{
                        $transaction->rollBack();
                    }
                }catch (\Exception $e){
                    $transaction->rollBack();
                }
            }
        }
        
//         ZCommonFun::print_r_debug($post);
//         ZCommonFun::print_r_debug($post_data);
//         exit;
        return $url;
    }
    
    /**
     *  分数型测试问题
     * @param unknown $posts
     * @param unknown $id
     */
    public function step4_2_questionSave($posts,$id,$page){
        $url='';
        $error='';
        if( isset($posts['label']['option-label'][0])){     
//             ZCommonFun::print_r_debug($posts);
//             exit;
            //保存问题
            if( !empty($posts['label-name'] ) ){
                $transacation = Yii::$app->db->beginTransaction();
                try {
                    $question_id = isset ($posts['qid'] ) ? $posts['qid'] : 0;
                    if($question_id>0){
                        $model_Question = Question::findOne($question_id);
                        //不是当前测试的问题
                        if($model_Question->table_id!=$id){
                            continue;
                        }
                    }else{
                        $model_Question = new Question();
                    }
                    
                    $model_Question->label = $posts['label-name'];
                    $model_Question->table_id = $id;
                    $save = 0 ;
                    if( $model_Question->save()){
                        
                        foreach ($posts['label']['option-label'] as $key=>$value){
                            if(empty($value)) continue;
                            
                            $qo_id = isset ($posts['label']['qo-id'][$key] ) ? $posts['label']['qo-id'][$key] : 0;
                            if($qo_id>0){
                                $model_QuestionOptions = QuestionOptions::findOne($qo_id);
                                //不是当前测试的选项
                                if($model_QuestionOptions->table_id!=$id){
                                    continue;
                                }
                                $save++;
                            }else{                       
                                $model_QuestionOptions = new QuestionOptions();
                            }
                            $model_QuestionOptions->question_id = $model_Question->question_id;
                            $model_QuestionOptions->table_id = $id;
                            $model_QuestionOptions->uid = ZCommonSessionFun::get_user_id();
                            $model_QuestionOptions->option_label = $value;
                            $model_QuestionOptions->question_id = $model_Question->question_id;
                            $score = isset($posts['label']['option-score'][$key]) ?$posts['label']['option-score'][$key]:1;
                            $score = (int)$score;
                            $model_QuestionOptions->option_score = $score;
                            if($model_QuestionOptions->save()) $save++;
            
                        }
                    }else{
                        $transacation->rollBack();
                        $error = '保存失败';
                    }
                    if($save>0){
                       
                            $transacation->commit();
        
                            if(isset($posts['save-next'])){
//                                ZCommonFun::print_r_debug($save);
//                                exit;
                               return $url = ['step4_2_question','id'=>$id,'page'=>$page];
                            }else{
                               return $url = ['step4_2','id'=>$id];
                            }
                        
                        
                    }else{
                        $transacation->rollBack();
                        $error='请填写选项';
                    }
        
                } catch (\Exception $e) {
//                     ZCommonFun::print_r_debug($e);
                    $transacation->rollBack();
                    $error ='事物异常';
                }
            }else{
                $error ='提交表单错误';
            }
//             ZCommonFun::print_r_debug($posts);
//             exit;
            $this->errorResulte = $error;
        }
    }
    
    /**
     * 分数型测试结果保存
     * @param unknown $post
     * @param unknown $condition
     * @param unknown $id
     */
    public function step4_2SaveResulteCondition2($post,$condition,$id){
        $post_data = [];
        $url=$error='';
        if(isset($post['name'][0])){
            foreach ($post['name'] as $key=>$name){
                $value = isset($post['value'][$key]) ? $post['value'][$key] : '';
                $intro = isset($post['intro'][$key]) ? $post['intro'][$key] : '';
                $min = isset($post['score-min'][$key]) ? $post['score-min'][$key] : 1;
                $max = isset($post['score-max'][$key]) ? $post['score-max'][$key] : 1;

                $temp = $min>$max ?$min:$max;
                $max = $temp;
                $min = $max;
                
                if($max>0&& $min>0 &&!empty($value)&& isset($name[0]) ){
                    $post_data[$key]['name'] = $value;
                    $post_data[$key]['value'] = $value;
                    $post_data[$key]['intro'] = $intro;
                    $post_data[$key]['sr-id'] =isset($post['sr-id'][$key])? $post['sr-id'][$key] : null;
                    $post_data[$key]['min'] = $min;
                    $post_data[$key]['max'] = $max;
                }
            }
            //有结果
            if($post_data){
                //保存结果
                $transaction = Yii::$app->db->beginTransaction();
                
                //删除结果
                $deleteSurveyResulte = new SurveyResulte();
                $deleteAll = $deleteSurveyResulte->getAll($id);
                isset($deleteAll[0]) ?  null : $deleteAll=[];
                $sr_ids = ZCommonFun::listData($deleteAll, 'sr_id', 'sr_id');
                
                $save=0;
                try {
                    foreach ($post_data as $key=>$row){
                        if( isset( $row['sr-id']) && $row['sr-id']>0 ){
                            $row_SurveyResulte = SurveyResulte::findOne($row['sr-id']);
                            if($row_SurveyResulte ){
                                
                                //结果存在，就不删除
                                unset($sr_ids[$row['sr-id']]);
                                if($row_SurveyResulte->s_id != $id){
                                    continue;
                                }
                               $save ++ ;
                            }else{
                                $row_SurveyResulte = new SurveyResulte();
                            }
                        }else{
                            $row_SurveyResulte = new SurveyResulte();
                        }
                        
                        $row_SurveyResulte->score_max = $row['max'];
                        $row_SurveyResulte->score_min = $row['min'];
                        $row_SurveyResulte->name = $row['name'];
                        $row_SurveyResulte->value = $row['value'];
                        $row_SurveyResulte->intro = $row['intro'];
                        
                        $row_SurveyResulte->value = $row['value'];
                        $row_SurveyResulte->value = $row['value'];
                        $row_SurveyResulte->uid = ZCommonSessionFun::get_user_id();
                        $row_SurveyResulte->s_id = $id;
                        $row_SurveyResulte->save() ? $save++:null;
                    }
                    if($save>0){
                        $condition = null;
                        if(count($sr_ids)>0){
                            $condition['sr_id'] = $sr_ids;
                            $condition['s_id'] = $id;
                            //删除所有结果
                            SurveyResulte::deleteAll($condition);
                        }
                        
                        
                        $transaction->commit();
                        $url = ['my'];
                    }
//                     ZCommonFun::print_r_debug($sr_ids);
//                     ZCommonFun::print_r_debug($post_data);
//                     exit;
                    $url = ['my'];
                }catch (\Exception $e){
//                     ZCommonFun::print_r_debug($e);
                    $transaction->rollBack();
                }
            }
            
        }
        
        return $url;
    }
}