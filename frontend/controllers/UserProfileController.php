<?php

namespace frontend\controllers;

use Yii;
use common\models\UserProfile;
use common\models\UserProfileSeach;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\z\ZCommonSessionFun;
use common\models\User;
use common\z\ZCommonFun;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller
{
   


    /**
     * Updates an existing UserProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBind()
    {
        if( ZCommonSessionFun::get_user_id()<1 ){
            $url = Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlLoginUserStr]);
            return $this->redirect($url);
        }
        
        $this->view->title='个人设置';
        $this->layout = false;
        $condition['uid']  = ZCommonSessionFun::get_user_id();
        $model = $model = UserProfile::findOne($condition);
        if(!$model){
            $model = new UserProfile();
        }
        $model->uid = ZCommonSessionFun::get_user_id();
        $model->birthday = $model->birthday ? date('Y-m-d',strtotime($model->birthday)):'';
        $load = $model->load(Yii::$app->request->post());
       
        if ( $load && $model->save()) {
            return $this->redirect(['bind']);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }
    /**
     * 修改密码
     */
    public function actionChangePass(){
        if( ZCommonSessionFun::get_user_id()<1 ){
            $url = Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlLoginUserStr]);
            return $this->redirect($url);
        }
        $this->view->title='修改密码';
        $this->layout = false;
        $condition['uid']  = ZCommonSessionFun::get_user_id();
        $model_old = User::findOne($condition);
        if(!$model_old){
            
            $url = Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlLoginUserStr]);
            return $this->redirect($url);
        }
        $model = new User();
        $model->user = $model_old->user;
        $load = $model->load(Yii::$app->request->post());
        $message = '';
        if($load){
            if(empty($model->pass)){
                $model->addError('pass','密码不能为空');
            }
            if(empty($model->flag)){
                $model->addError('flag','重复密码不能为空');
            }else if($model->pass!=$model->flag){
                $model->addError('flag','两次密码不一致');
            }
            
            if( !$model->hasErrors() ){
                $model_old->pass = ZCommonFun::getPass($model->pass);
                if( $model_old->save()){
                    $model->pass = '';
                    $model->flag = '';
                    $message = '修改密码成功';
                }
            }
        }
        return $this->render('change-pass', [
            'model' => $model,
            'message'=>$message,
        ]);
    }
    
  /**
   * 第三方绑定列表
   */
  public function actionBindList(){
      if( ZCommonSessionFun::get_user_id()<1 ){
          $url = Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlLoginUserStr]);
          return $this->redirect($url);
      }
      $this->layout = false;
//       header("Cache-Control: post-check=0, pre-check=0", false);
//       Yii::$app->request->headers->set('Cache-Control','no-store, no-cache, must-revalidate');
//       Yii::$app->request->headers->set('Pragma','no-cache');
//       Yii::$app->request->headers->set('Expires','Mon, 28 Feb 1990 22:22:04 GMT');
      $condition['uid']  = ZCommonSessionFun::get_user_id();
      $model = $model = UserProfile::findOne($condition);
      if(!$model){
          $model = new UserProfile();
      }
      return $this->render('bind-list',['model'=>$model]);
  }

  

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
