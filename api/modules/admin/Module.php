<?php

namespace api\modules\admin;

use yii\base\Event;
use yii\web\Response;

class Module extends \mdm\admin\Module
{
    public function afterAction($action, $result)
    {
        Event::on(Response::className(), Response::EVENT_BEFORE_SEND, [$this, 'formatDataBeforeSend']);
        return parent::afterAction($action, $result);
    }

    public function formatDataBeforeSend($event){
        $response = $event->sender;
        var_dump($response);exit;
    }
}
