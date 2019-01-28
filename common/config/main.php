<?php
return [
    'language' => 'zh-CN',
    'timeZone'   => 'PRC',
    'charset'    => 'utf-8',
    'sourceLanguage' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            'defaultTimeZone' => 'PRC',
            'dateFormat'      => 'php:Y-m-d',
            'timeFormat'      => 'php:H:i:s',
            'datetimeFormat'  => 'php:Y-m-d H:i:s',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=test',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
    ],
];
