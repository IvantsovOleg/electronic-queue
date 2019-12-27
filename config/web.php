<?php

$params = require(__DIR__ . '/params.php');


$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'components' => [
        'formatter' => [
          'class' => 'yii\i18n\Formatter'
        ],
      ],

    /*'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => '\views\site\about', // it can be '@path/to/your/layout'.
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\User',
                    'idField' => 'user_id'
                ],
                'other' => [
                    'class' => 'path\to\OtherController', // add another controller
                ],
            ],
            'menus' => [
                'assignment' => [
                    'label' => 'Grand Access' // change label
                ],
                'route' => null, // disable menu route
            ]
        ],
        //
    ],*/
    'components' => [


        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'pol'
        ],
        /* 'view' => [
             'theme' => [
                 'pathMap' => [
                     '@app/views' => '@vendor/p2made/yii2-sb-admin-theme/views/sb-admin-2',
                 ],
             ],
         ],*/
        'response' => [
            'formatters' => [
                'php' => 'app\components\PhpArrayFormatter',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '10.144.4.33',
                'username' => 'b40.imp68',
                'password' => 'sr7rS3kz',
                'port' => '25',
                'encryption' => 'TLS',
            ],
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
        'mycomponent' => [

            'class' => 'app\components\MyComponent',

        ],
        'cxml' => [

            'class' => 'app\components\CXml',

        ],
        'cxmlinput' => [

            'class' => 'app\components\CxmlInput',

        ],
        'cxloutput' => [

            'class' => 'app\components\CxmlOutput',

        ],
        'cmonitor' => [

            'class' => 'app\components\CMonitor',

        ],
        'cmp3file' => [

            'class' => 'app\components\CAudiofile',

        ],
        'db' => require(__DIR__ . '/db.php'),
        
        /*'authManager' => [
            'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
        ]*//*,
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],*/

    ],
    /* 'as access' => [
         'class' => 'mdm\admin\components\AccessControl',
         'allowActions' => [
             'site/about', // add or remove allowed actions to this list
         ]
     ]*/

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
