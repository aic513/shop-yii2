<?php

$config = [
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vk' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '',
                    'clientSecret' => '',
                ],
            ],
        ]
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*', '192.168.83.*']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
	    'class' => 'yii\gii\Module',
	    'allowedIPs' => ['127.0.0.1', '::1', '192.168.83.*'],
    ];
}

return $config;
