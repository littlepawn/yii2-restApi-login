<?php
namespace backend\controllers;

use backend\models\ES;
use yii\elasticsearch\Exception;
use yii\web\Controller;

/**
 * ElasticSearch controller
 */
class ElasticSearchController extends Controller
{

    public function actionGetList()
    {
        try {
            $query=[
                'bool' => [
                    'must' => [
                        ['match' => ['content' => '中国']],
                    ],
                ],
            ];
            $res = ES::find()->query($query)->asArray()->all();
            dd($res);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
