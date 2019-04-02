# yii2-restApi-login
basic rest api login module with yii2

## oauth2.0
php composer.phar require --prefer-dist filsh/yii2-oauth2-server "*"
main.php
```
‘modules’ => [
    ‘oauth2’ => [
        ‘class’ => ‘filsh\yii2\oauth2server\Module’,
        ‘tokenParamName’ => ‘accessToken’,
        ‘tokenAccessLifetime’ => 3600 * 24,
        ‘storageMap’ => [
            ‘user_credentials’ => ‘common\models\User’,
        ],
        ‘grantTypes’ => [
            ‘user_credentials’ => [
                ‘class’ => ‘OAuth2\GrantType\UserCredentials’,
            ],
            ‘refresh_token’ => [
                ‘class’ => ‘OAuth2\GrantType\RefreshToken’,
                ‘always_issue_new_refresh_token’ => true
            ]
        ]
    ],
    ‘v1’ => [
        ‘class’ => ‘passport\modules\v1\Module’,
    ],
],
```

## RBAC
composer.json增加"mdmsoft/yii2-admin": "~2.0"
main.php
```
return [
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            ...
        ]
        ...
    ],
    ...
    'components' => [
        ...
        'authManager' => [
            'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
        ]
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
];
```

yii migrate --migrationPath=@mdm/admin/migrations
yii migrate --migrationPath=@yii/rbac/migrations

## tips:

1.filsh/yii2-oauth2-server在yii2的2.0.13版本有bug,解决方案：
更改vendor/filsh/Module.php里面的函数
```
    public function getRequest()
    {
        if(!ArrayHelper::keyExists('request', $this->getComponents())) {
            $this->set('request', Request::createFromGlobals());
        }
        return $this->get('request');
    }
    
    public function getResponse()
    {
        if(!ArrayHelper::keyExists('response', $this->getComponents())) {
            $this->set('response', new Response());
        }
        return $this->get('response');
    }
    
   ```
2.内部实现grant_type=>password
```
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        //获取oauth框架的请求体,并覆盖其请求方式
        $filshRequest=$module->getRequest();
        $filshRequest->request=array_merge(Yii::$app->request->post(),['grant_type'=>'password','client_id'=>'testclient','client_secret'=>'testpass']);
        $module->set('request',$filshRequest);
        $oauthResponse = $module->getServer()->handleTokenRequest()->getParameters();
        if(!isset($oauthResponse['access_token']))
            throw new OperateException(StatusCode::USER_GENERATE_ACCESS_TOKEN_FAILED);
        return [
            'accessToken' => $oauthResponse['access_token'],
            'userId'=>$this->uid,
            'expiresIn'=>$oauthResponse['expires_in'],
            'tokenType'=>$oauthResponse['token_type'],
            'refreshToken'=>$oauthResponse['refresh_token'],
        ];
```

3.refresh token刷新
```
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        //获取oauth框架的请求体,并覆盖其请求方式
        $filshRequest=$module->getRequest();
        $filshRequest->request=['grant_type'=>'refresh_token','client_id'=>'testclient','client_secret'=>'testpass','refresh_token'=>$this->refreshToken];
        $module->set('request',$filshRequest);
        $oauthResponse = $module->getServer()->handleTokenRequest()->getParameters();
        if(!isset($oauthResponse['access_token']))
            throw new OperateException(StatusCode::USER_GENERATE_ACCESS_TOKEN_FAILED);
        return [
            'accessToken' => $oauthResponse['access_token'],
            'expiresIn'=>$oauthResponse['expires_in'],
            'tokenType'=>$oauthResponse['token_type'],
            'refreshToken'=>$oauthResponse['refresh_token'],
        ];
```

4.其他配置参考http://www.shuijingwanwq.com/2015/08/26/649/
