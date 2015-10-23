<?php 
namespace common\models;

use Yii;
class AnswerOperation extends Answer{
    /**
     * 保存回答用户
     * @param array $attributes
     */
    function setAnswerUser($attributes){
        $model = new AnswerUser();
        $user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
        $user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
        $model->attributes = $attributes;
        $model->ip = $user_IP;
        return $model->save();
    }
}