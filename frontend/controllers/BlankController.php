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
use common\z\ZController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\z\ZCommonFun;

/**
 * 空白页
 * BlankController controller
 */
class BlankController extends ZController
{
    public function actionTest(){
        $this->layout = false;
        $this->view->title = '如何创建测试';
        $params = ['blank/test2','id'=>2];
        $url = Yii::$app->urlManager->createUrl($params);
        $this->redirect($url);
        return $this->render('test');
    }

    public function actionTest2(){
        $params = ['blank/test2','id'=>2];
        echo Yii::$app->urlManager->createUrl($params);
        ZCommonFun::print_r_debug($_SERVER);
    }

    /**
     * 如何创建测试
     * @param unknown $tax
     * @return \yii\base\string
     */
    public function actionHow_test($tax){
        $this->layout = false;
        $tax = intval($tax);
        return $this->render('how_test',['tax'=>$tax]);
    }
}
