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
use common\models\OauthBind;
use common\z\ZController;
/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends ZController
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
            $userInfo = ZCommonSessionFun::get_user_session();
            $userInfo['profile'] = $model->attributes;
            $userInfo['nickname'] = $model->nickname;
            $userInfo['head_image'] = $model->head_image;
            $userInfo['intro'] = $model->intro;
            ZCommonSessionFun::set_user_session($userInfo);
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
   * 绑定账号
   */
  public function actionBindAccount(){
      $this->layout = false;
      $old_login_uid = ZCommonSessionFun::get_user_id();
      if( ZCommonSessionFun::get_user_id()<1 ){
          $url = Yii::$app->urlManager->createUrl([ZCommonSessionFun::urlLoginUserStr]);
          return $this->redirect($url);
      }
      $model = new User();

      if(isset($_POST['User']['user']) && isset($_POST['op'])){

          $post = $_POST['User'];
          $user = isset($post['user']) ? $post['user']: '';
          $pass = isset($post['pass']) ? $post['pass']: '';
          $post = $_POST['User'];
          //已有账户绑定
          if($_POST['op']==1){
              $condition['user'] = $user;
              $model_find = new User();

              $model_find = $model_find->find()->where($condition)->one();

              if(!$model_find){
                  $model->addError('user','用户没有找到');
              }
              else if( $model_find->pass!= ZCommonFun::getPass($pass) ){
                  $model->addError('pass','密码错误');
              }else if($model_find->is_bind_user==1){
                  $model->addError('user','账户已被绑定过');
              }else{
                    $connection = Yii::$app->db;
                    $transaction = $connection->beginTransaction();
                    try {
                        $model_find->is_bind_user = 1;
                        $model_find->save();
                        $model_Oauth = new OauthBind();

                        $model_Oauth_condition['uid'] = $old_login_uid;
                        $model_Oauth_attributes['uid'] = $model_find->uid;
                        $model_Oauth->updateAll($model_Oauth_attributes,$model_Oauth_condition);
                        $transaction->commit();
                        ZCommonSessionFun::set_user_session($model_find->attributes);
                        $url = Yii::$app->urlManager->createUrl(['user-profile/bind-list']);
                        return $this->redirect($url);
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        $model->addError('user','绑定失败');
                    }

              }
          }//绑定新账户
          else{

              $model->pass = ZCommonFun::getPass($model->pass);
              $model = $model->findOne(ZCommonSessionFun::get_user_id());
              if( $model ){
                  $model->user = $user;
                  $model->pass = ZCommonFun::getPass( $pass );
                  $model->is_bind_user = 1;
                  if( $model->save() ){
                      ZCommonSessionFun::set_user_session($model->attributes);
                      $url = Yii::$app->urlManager->createUrl(['user-profile/bind-list']);
                      return $this->redirect($url);
                  }
              }else{
                  $model = new User();
                  $model->user = $user;
                  $model->pass = $pass;

                  $model->addError('user','用户已被删除');
              }
          }



        }
      return $this->render('bind-account', [ 'model'=>$model ] );
  }

  /**
   * 绑定，注册
   * @return \yii\base\string
   */
  public function actionBinding(){
      $this->layout = false;
      $model = new User();
      return $this->render('binding',['model'=>$model]);
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
