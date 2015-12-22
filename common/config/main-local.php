<?php
return [
    'components' => [
        //======缓存配置 start======
    /*     'cache' => [
            'class' => 'yii\caching\MemCache',
//             'useMemcached'=>true,
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 100,
                ],
                 
            ],
            'serializer'=>false,
            'keyPrefix'=>'',
//             'useMemcached'=>true,
        ], */
        //======缓存配置 end======
//         'session' => ['class' => '\common\components\ZSession'],            // session组件yii\web\Session
        /*
         * 'db' => [
         * 'class' => 'yii\db\Connection',
         * 'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
         * 'username' => 'root',
         * 'password' => '',
         * 'charset' => 'utf8',
         * ],
         */
        
        //======主从数据库配置 start======
        'db' => [
            
            'class' => 'yii\db\Connection',          
            // 配置主服务器
            'masterConfig' => [
                'username' => 'root',
//                 'password' => 'root0601',
                'password' => 'root',
                'charset' => 'utf8',
                'attributes' => [
                    // use a smaller connection timeout
                    PDO::ATTR_TIMEOUT => 10
                ]
            ],
            
            // 配置主服务器组
            'masters' => [
                [
                    'dsn' => 'mysql:host=localhost;dbname=survey'
                ],
        
            ],
            
            // 配置从服务器
            'slaveConfig' => [
                'username' => 'root',
//                 'password' => 'root0601',
                'password' => 'root',
                'charset' => 'utf8',
                'attributes' => [
                    // use a smaller connection timeout
                    PDO::ATTR_TIMEOUT => 10
                ]
            ],
            
            // 配置从服务器组
            'slaves' => [
                [
                    'dsn' => 'mysql:host=localhost;dbname=survey'
                ],

            ]
        ],
        //======主从数据库配置 end======
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail'
        ],
        
         
        
        
        
    ],
    'modules' => [
        'gii' => YII_DEBUG ? [
            'class' => 'yii\gii\Module',
            'allowedIPs' => [
                '127.0.0.1',
                '::1'
            ]
        ] : [],
    ]
];
