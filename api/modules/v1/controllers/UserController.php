<?php

namespace api\modules\v1\controllers;

use api\controllers\BaseController;
use api\exceptions\OperateException;
use api\models\UserInfo;
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
//        throw new OperateException('100004');
//        throw new UnauthorizedHttpException(11);
        return ['data'=>[1,2.44,true,"44",["aa"=>3,4]]];
    }

    public function actionRegister(){
        $params = Yii::$app->request->post();
        $model = new UserInfo();
    }

    /**
     * @return array
     * @throws OperateException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin(){
        $params = Yii::$app->request->post();
        $model = new UserInfo();
        $model->setScenario(UserInfo::SCENARIO_USER_LOGIN);
        $model->load($params, '');
        $result = $model->login();
        return static::returnJson($result);
    }
}