<?php
namespace api\controllers;

class CommonController extends BaseController {
    protected $userId;
    public function init()
    {
        parent::init();
        $this->userId=\Yii::$app->user->id;
    }
}