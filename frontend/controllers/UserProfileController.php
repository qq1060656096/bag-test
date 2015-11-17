<?php

namespace frontend\controllers;

use Yii;
use common\models\UserProfile;
use common\models\UserProfileSeach;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\z\ZCommonSessionFun;

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
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['bind']);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
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
