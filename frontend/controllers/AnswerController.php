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
use common\z\ZCommonSessionFun;
use common\models;
use common\models\User;
use common\models\UserProfile;
use common\models\AnswerSurveyResulte;
use frontend\models\SurveyOperation;
use common\z\ZController;
class AnswerController extends ZController{
    /**
     * 随机皮肤
     * @return array('file'=>'','css'=>'')
     */
    public function randSkin(){
        $skins= [
            ['file'=>'answer',
            'css'=>'./css/v1.css'
            ],
            ['file'=>'answer3',
            'css'=>'./css/v3.css'
            ],
            ['file'=>'answer4',
            'css'=>'./css/v4.css'
            ],
        ];

       $rand = rand(0, 2);
       return $skins[$rand];
    }
    /**
     * 获取用户ip地址
     * @return string
     */
    public static function getUserIP(){
        $user_IP = !empty($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
        $user_IP = !empty($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
        return $user_IP;
    }
    /**
     * 随机显示测试
     * @return Ambigous <multitype:, mixed>
     */
    public function getRandSurvey(){
        $queryParams['SurverySearch']['is_publish'] = 1;
        $searchModel = new \common\models\SurverySearch();
        $query = $searchModel->query( $queryParams );
        $query->offset(0);
        $query->limit(20);
        $a_models = $query->all();
        $len = count($a_models);
        $len<1 ? $a_models=[]:null;
        $rand_arr = [];
        if($len>4){
            $rand_arr = array_rand($a_models,4);
        }
        $temp = [];
        foreach ($rand_arr as $key=>$value){
            $temp[$value] = $a_models[$value];
        }


        return $temp;
    }
    /**
     * 测试结果
     */
    public function actionResulte(){
        $this->layout = false;
        $au_id = Yii::$app->request->get('au_id');
        $au_id = $au_id ? intval($au_id) : 0;



        $model_AnswerUser = AnswerUser::findOne($au_id);
        if (!$model_AnswerUser) $model_AnswerUser = new AnswerUser();
        $model = null;
        if($model_AnswerUser){
            $model = Survey::findOne($model_AnswerUser->sid);
        }

        $model ? null : $model = new Survey();
        $model_AnswerSurveyResulte = AnswerSurveyResulte::findOne( $model_AnswerUser->table_id );
        //没找到结果
        if( !$model_AnswerSurveyResulte )
            $model_AnswerSurveyResulte = new AnswerSurveyResulte();
        else{
            $model_AnswerSurveyResulte->setvisit_count($model_AnswerUser->table_id);
        }
        $model_AnswerSurveyResulte->visit_count++;
        $model_Users = null;
        $model_UsersProfile = null;
//         ZCommonFun::print_r_debug($model->attributes);
        if( $model->uid ){
            $zhao_condition['uid'] = $model->uid;
            $model_Users = User::findOne( $zhao_condition);

            $model_UsersProfile = UserProfile::findOne( $zhao_condition );
        }
//         ZCommonFun::print_r_debug($model_UsersProfile->attributes);
        !$model_Users ? $model_Users = new User() : '';
        !$model_UsersProfile ? $model_UsersProfile = new UserProfile() : '';
//         ZCommonFun::print_r_debug($model_AnswerSurveyResulte);
//         exit;
        $model_SurveyOperation = new SurveyOperation();
        $models_SurveyOperation = $model_SurveyOperation->getIsTop();
        return $this->render('resulte22',array(
            'models_SurveyOperation'=>$models_SurveyOperation,
            'model'=>$model,
            'model_AnswerUser'=>$model_AnswerUser,
            'model_SurveyResulte'=>$model_AnswerSurveyResulte,
            'image'=>Survey::getImageUrl($model),
            'model_Users'=>$model_Users,
            'model_UsersProfile'=>$model_UsersProfile,
            'randSurvey'=>$this->getRandSurvey(),//随机测试
        ));
        return $this->render('resulte2',array(
            'model'=>$model,
            'model_AnswerUser'=>$model_AnswerUser,
            'model_SurveyResulte'=>$model_AnswerSurveyResulte,
            'image'=>Survey::getImageUrl($model),
            'model_Users'=>$model_Users,
            'model_UsersProfile'=>$model_UsersProfile,
            'randSurvey'=>$this->getRandSurvey(),//随机测试
        ));

        return $this->render('resulte',array(
            'model'=>$model,
            'model_AnswerUser'=>$model_AnswerUser,
            'model_SurveyResulte'=>$model_AnswerSurveyResulte,
            'image'=>Survey::getImageUrl($model),
            'model_Users'=>$model_Users,
            'model_UsersProfile'=>$model_UsersProfile,
            'randSurvey'=>$this->getRandSurvey(),//随机测试
        ));
    }
    public function popupMessage($message){
        $url = Yii::$app->urlManager->createUrl(['survey/index']);
        $title = ZController::$site_name;
        echo <<<str
        <html>
        <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="js/smile-alert-master/smile-alert.css" />
        <script src="js/smile-alert-master/smile-alert.js"></script>
        </head>
<body>


        </body>
<script>

var options = {
	cancel          : true,
	cancelText		: '确定',
	cancelCallBack 	:function(event){
                window.location.href="{$url}";
		consle.log('options.cancelCallBack');
	},
	delay           :0,
	confirm         : false
};

alert('{$title}','{$message}',options);
    </script>
</html>
str;

    }
    /**
     * 奇趣测试回答
     */
    public function actionStep1($id){
        $this->layout = false;
        $model = Survey::findOne($id);
        if(!$model){//没找到
            $model = new Survey();
        }
        if($model->is_publish<1){
            $this->popupMessage($model->title.'未发布，不能测试');
            exit;
        }
        $data = $model->FindAllQuestionsOptions($id);

        $q = new Question();
        $posts = Yii::$app->request->post();
        //查找answer操作
        $aid = Yii::$app->request->get('aid',0);
        $aid = (int)$aid;


        $result = null;

        if( ( isset($posts['name']) && !empty($posts['name'])) ){

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
            $month = isset($posts['birth']['month']) ? $posts['birth']['month'] : '01';
            $day = isset($posts['birth']['day']) ? $posts['birth']['day'] : '01';
            $constellation = isset($posts['constellation']) ? intval($posts['constellation']) : 0;
            $constellation = $constellation>0&&$constellation<13?$constellation:0;

            $birth = $year.'-'.$month.'-'.$day;
            $birth = date('Y-m-d',strtotime($birth));
            $model_SurveyResulte = new SurveyResulte();
            //计算测试结果
            $result = $model_SurveyResulte->getStep1Result($id, $name, $birth);
           // $model->answer_count = $model->randCount($model->answer_count);
            if($result){

                $model_AnswerUser = new AnswerUser();
                $model_AnswerUser->uid = ZCommonSessionFun::get_user_id();
                $model_AnswerUser->sid = $id;
                $model_AnswerUser->answer_name = $name;
                $model_AnswerUser->answer_age = $birth;
                $model_AnswerUser->constellation = $constellation;
                //直接跳转答案
                if($result){
                    //保存回答者结果,防止用户更改数据导致结果丢失
                    $mode_AnswerSurveyResulte = new AnswerSurveyResulte();
                    $mode_AnswerSurveyResulte->attributes = $result->attributes;
                    $mode_AnswerSurveyResulte->save();
                    $model_AnswerUser->table = 'answer_survey_resulte';
                    $model_AnswerUser->table_id = $mode_AnswerSurveyResulte->answer_sr_id;
                }
                $model_AnswerUser->ip = self::getUserIP();
                if( $model_AnswerUser->save() ){
                    //设置测试数量
                    $model->setAnswerCount($id);

                    $model_UserProfile = new UserProfile();
                    $model_UserProfile->setTestCount($model_AnswerUser->uid);
                   return  $this->redirect(['resulte','au_id'=>$model_AnswerUser->au_id]);
                }
            }


        }
        $model_Users = null;
        $model_UsersProfile = null;
        if( $model->uid ){
            $model_Users = User::findOne( $model->uid );
            $model_UsersProfile = UserProfile::findOne( $model->uid );
        }

        !$model_Users ? $model_Users = new User() : '';
        !$model_UsersProfile ? $model_UsersProfile = new UserProfile() : '';

        $model_SurveyOperation = new SurveyOperation();
        $models_SurveyOperation = $model_SurveyOperation->getIsTop();

        return $this->render('answer2',[
            'models_SurveyOperation'=>$models_SurveyOperation,
            'data'=>$data,
            'model'=>$model,
            'result'=>$result,
            'posts'=>$posts,
            'image'=>Survey::getImageUrl($model),
            'model_Users'=>$model_Users,
            'model_UsersProfile'=>$model_UsersProfile,
            'randSurvey'=>$this->getRandSurvey(),//随机测试
        ]);

        return $this->render('answer',[
            'data'=>$data,
            'model'=>$model,
            'result'=>$result,
            'posts'=>$posts,
            'image'=>Survey::getImageUrl($model),
            'model_Users'=>$model_Users,
            'model_UsersProfile'=>$model_UsersProfile,
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
        if($model->is_publish<1){
            $this->popupMessage($model->title.'未发布，不能测试');
            exit;
        }
        $data = $model->FindAllQuestionsOptions($id);
//                 ZCommonFun::print_r_debug($_POST);
//                 exit;
        $posts = Yii::$app->request->post();



        $error = '';
        if(isset($posts['name']) ){
            $op = count($posts['options'])>0 ? true :false;
            $res = isset($posts['res']) ? intval($posts['res']) : 0;
            $res_model_SurveyResulte = $res>0 ? SurveyResulte::findOne($res) : null;
            if($res_model_SurveyResulte && $res_model_SurveyResulte->s_id ==$id ){

            }else{
                $res_model_SurveyResulte = null;
            }

            $total_score = 0;
            $save =0;
            $result = null;

            //保存结果
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $name = isset($posts['name']) ? $posts['name'] : '';
                $year = isset($posts['birth']['year']) ? $posts['birth']['year'] : 2015;
                $month = isset($posts['birth']['month']) ? $posts['birth']['month'] : '01';
                $day = isset($posts['birth']['day']) ? $posts['birth']['day'] : '01';
                $constellation = isset($posts['constellation']) ? intval($posts['constellation']) : 0;
                $constellation = $constellation>0&&$constellation<13?$constellation:0;

                $birth = $year.'-'.$month.'-'.$day;

                $birth = date('Y-m-d',strtotime($birth));

                $model_AnswerUser = new AnswerUser();
                $model_AnswerUser->sid = $id;
                $model_AnswerUser->table = 'survey_resulte';
                $res_model_SurveyResulte ? $model_AnswerUser->table_id = $res_model_SurveyResulte->sr_id : null;
                $model_AnswerUser->answer_name = $name;
                $model_AnswerUser->answer_age  = $birth;
                $model_AnswerUser->constellation = $constellation;


                $model_AnswerUser->ip = self::getUserIP();
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
                        $model_SurveyResulte = new SurveyResulte();
                        //如果直接选择了答案
                        if($model_AnswerUser->table == 'survey_resulte' && $model_AnswerUser->table_id>0){
                            $result = $res_model_SurveyResulte;
//
                        }else{
                            $result = $model_SurveyResulte->getStep2Result($id, $model_AnswerUser->answer_score);

                        }
                        if($result&& !$res_model_SurveyResulte){
                            //保存回答者结果,防止用户更改数据导致结果丢失
                            $mode_AnswerSurveyResulte = new AnswerSurveyResulte();
                            $mode_AnswerSurveyResulte->attributes = $result->attributes;
                            $mode_AnswerSurveyResulte->save();
                            $model_AnswerUser->table == 'answer_survey_resulte';

                            $model_AnswerUser->table_id = $mode_AnswerSurveyResulte->answer_sr_id;
                        }
                        $model_AnswerUser->save();
                        $transaction->commit();
                        //设置测试数量
                        $model->setAnswerCount($id);
                        $model_UserProfile = new UserProfile();
                        $model_UserProfile->setTestCount($model_AnswerUser->uid);
                        return $this->redirect(['resulte','au_id'=>$model_AnswerUser->au_id]);
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
        $model_Users = null;
        $model_UsersProfile = null;
        if( $model->uid ){
            $model_Users = User::findOne( $model->uid );
            $model_UsersProfile = UserProfile::findOne( $model->uid );
        }

        !$model_Users ? $model_Users = new User() : '';
        !$model_UsersProfile ? $model_UsersProfile = new UserProfile() : '';
//         echo $error;
//         exit;
//         ZCommonFun::print_r_debug($result);

        $model_SurveyOperation = new SurveyOperation();
        $models_SurveyOperation = $model_SurveyOperation->getIsTop();
        return $this->render('step2answer3',[
            'models_SurveyOperation'=>$models_SurveyOperation,
            'data'=>$data,
            'model'=>$model,
            'error'=>$error,
            'posts'=>$posts,
            'image'=>Survey::getImageUrl($model),
            'model_Users'=>$model_Users,
            'model_UsersProfile'=>$model_UsersProfile,
            'randSurvey'=>$this->getRandSurvey(),//随机测试
        ]);

        return $this->render('step2answer',[
            'data'=>$data,
            'model'=>$model,
            'error'=>$error,
            'posts'=>$posts,
            'image'=>Survey::getImageUrl($model),
            'model_Users'=>$model_Users,
            'model_UsersProfile'=>$model_UsersProfile,
        ]);
    }

}