# yii2-restApi-login
basic rest api login module with yii2

tips:

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