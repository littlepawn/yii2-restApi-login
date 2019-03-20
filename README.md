# yii2-restApi-login
basic rest api login module with yii2

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

##tips:

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

2.其他配置参考http://www.shuijingwanwq.com/2015/08/26/649/
