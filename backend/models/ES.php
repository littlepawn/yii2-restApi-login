<?php
namespace backend\models;
use yii\elasticsearch\ActiveRecord;

class ES extends ActiveRecord
{
    public static $currentIndex;

    # 定义db链接
    public static function getDb()
    {
        return \Yii::$app->get('elasticsearch');
    }

    # db
    public static function index()
    {
        return 'index';
    }

    # table
    public static function type()
    {
        return 'fulltext';
    }

    # 属性
    public function attributes()
    {
        $mapConfig = self::mapConfig();
        return array_keys($mapConfig['properties']);
    }

    # mapping配置
    public static function mapConfig(){
        return [
            'properties' => [
                'content'			=> ['type' => 'string',	"index" => "not_analyzed"],
            ]
        ];
    }

    public static function mapping()
    {
        return [
            static::type() => self::mapConfig(),
        ];
    }

    /**
     * Set (update) mappings for this model
     */
    public static function updateMapping(){
        $db = self::getDb();
        $command = $db->createCommand();
        if(!$command->indexExists(self::index())){
          $command->createIndex(self::index());
        }
        $command->setMapping(self::index(), self::type(), self::mapping());
    }

    public static function getMapping(){
        $db = self::getDb();
        $command = $db->createCommand();
        return $command->getMapping();
    }
}