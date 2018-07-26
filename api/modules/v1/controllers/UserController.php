<?php

namespace api\modules\v1\controllers;

use api\controllers\BaseController;
use api\exceptions\OperateException;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UnauthorizedHttpException;

class UserController extends BaseController {

    public function behaviors(){
        return ArrayHelper::merge (parent::behaviors(), [
            'access' => [
                'class' => 'api\filter\AccessControl',
                'allowActions' => [
                    'login',//允许访问的节点，可自行添加
                    'index',
                ]
            ],
        ]);
    }

    /**
     * @throws OperateException
     */
    public function actionIndex(){
        throw new OperateException('100003');
//        throw new UnauthorizedHttpException(11);
//        return ['data'=>[1,2,3,]];
    }

    public function actionLogin()
    {
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        Yii::$app->request->get('grant_type','grant_type');
        Yii::$app->request->get('username','pawn');
        Yii::$app->request->get('password','123456');
        Yii::$app->request->get('client_id','testclient');
        Yii::$app->request->get('client_secret','testpass');
        $response = $module->getServer()->handleTokenRequest();
//        var_dump($response->getParameters());exit;
        return ['data'=>$response->getParameters()];
    }
}