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

/**
 * 空白页
 * BlankController controller
 */
class BlankController extends ZController
{
    public function actionTest(){
        $this->layout = false;
        $this->view->title = '如何创建测试';
        return $this->render('test');
    }
}
