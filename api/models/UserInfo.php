<?php
namespace api\models;

use api\components\BaseModel;
use api\exceptions\OperateException;
use Yii;

class UserInfo extends BaseModel {
    const SCENARIO_USER_REGISTER = 'user_register';
    const SCENARIO_USER_LOGIN = 'user_login';

    public $username;
    public $password;
    public $rePassword;
    public $email;
    public $mobile;

    public function scenarios()
    {
        return [
            self::SCENARIO_USER_REGISTER => ['username', 'password', 'rePassword', 'email', 'mobile', ],
            self::SCENARIO_USER_LOGIN => ['username', 'password', ],
        ];
    }

    public function rules(){
        return [
            [['username','password','rePassword'],'trim'],
            [['username','password','rePassword'],'required'],
        ];
    }

    /**
     * 用户登陆
     * @throws \api\exceptions\OperateException
     * @throws \yii\base\InvalidConfigException
     * @throws \api\exceptions\ValidateException
     */
    public function login()
    {
        if (!$this->validate()) {
            static::getErrorMessage($this);
        }
        $model=new User();
        $res=$model->checkUserCredentials($this->username,$this->password);
        if(!$res)
            throw new OperateException(100002);
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        Yii::$app->request->post('grant_type','grant_type');
        Yii::$app->request->post('client_id','testclient');
        Yii::$app->request->post('client_secret','testpass');
        $oauthResponse = $module->getServer()->handleTokenRequest()->getParameters();
        if(!isset($oauthResponse['access_token']))
            throw new OperateException(100003);
        $accessToken=$oauthResponse['access_token'];

        $user=$model->getUserDetails($this->username);
        return ['access_token' => $accessToken,'user_id'=>$user['user_id']];
    }

    /**
     * @throws \api\exceptions\ValidateException
     */
    public function register(){
        if (!$this->validate()) {
            static::getErrorMessage($this);
        }

    }
}