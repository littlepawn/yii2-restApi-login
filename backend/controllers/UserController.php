<?php
/**
 * Created by PhpStorm.
 * User: wj992
 * Date: 2018/3/14
 * Time: 15:29
 */

namespace backend\controllers;

use yii\web\Controller;
use backend\models\User;

class UserController extends Controller
{
    public function actionIndex(){
        $user = User::find()->all();
//        dd($user);
        var_dump(env(YII_DEBUG));
    }
}