<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp'
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\entities\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true, 'domain' => 'yii2-karantin'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<_a:about|contact|signup|login|logout>' => 'site/<_a>',

                'cabinet' => 'cabinet/default/index',
                'cabinet/<_c:[\w\-]+>' => 'cabinet/<_c>/index',
                'cabinet/<_c:[\w\-]+>/<id:\d+>' => 'cabinet/<_c>/view',
                'cabinet/<_c:[\w\-]+>/<_a:[\w-]+>' => 'cabinet/<_c>/<_a>',
                'cabinet/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => 'cabinet/<_c>/<_a>',

                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
];
