<?php
namespace api\controllers;

use filsh\yii2\oauth2server\filters\auth\CompositeAuth;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class BaseController extends Controller{
    public function behaviors()
    {
        return ArrayHelper::merge (parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    ['class' => HttpBearerAuth::className()],
                    ['class' => QueryParamAuth::className(), 'tokenParam' => 'accessToken'],
                ],
                'optional'=>['login'],
            ],
            'exceptionFilter'=>[
                'class'=>ErrorToExceptionFilter::className(),
            ],
            'access' => [
                'class' => 'api\filter\AccessControl',
                /*'allowActions' => [
                    '*'
                ],*/
            ],
        ]);
    }

    public static function returnJson($data){
        if($data)
            return ['data'=>$data];
        return ['data'=>['user_id'=>\Yii::$app->user->id]];
    }
}