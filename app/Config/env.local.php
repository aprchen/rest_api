<?php

return [
    'database' => [
        'adapter'    => 'Mysql',
        'host'       => 'localhost',
        'username'   => 'root',
        'password'   => '123456789',
        'port'       => '8889',
        'prefix'     => 'sl',
        'dbname'     => 'qy_api',
        'charset'    => 'utf8',
    ],
    'redis'=>[
        "host" => '127.0.0.1',
        "port" => 6379,
        "auth" => "",
        'statsKey'=>'_PHCR' //_PHCR
    ],
    'modelsCache'=>[
        'lifetime'=>[
            'frontendData'=>86400 //一天
        ]
    ]
];
