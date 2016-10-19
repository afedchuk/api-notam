<?php

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'notam/index',
    'components' => [
        'xml' => [
            'class' => 'app\components\Xml',
        ],
        'api' => [
            'class' => 'app\components\Client',
            'usr' => 'usertest@gmail.com',
            'passwd' => 'usrpassword',
            'url' => 'https://api.com/notam/service.wsdl',
            'options' => [
                'trace' => true,
                'use' => SOAP_LITERAL,
                'cache_wsdl' => WSDL_CACHE_NONE,
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'api/error',
        ],
        'request' => [
            'cookieValidationKey' => 'zKRr59uK4fqUeYQNo6QbLYf1b5d3BYPJ',
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
    ],
    'params' => [
        'googleApi' => ''
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
