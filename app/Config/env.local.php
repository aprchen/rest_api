<?php

return [
    'database' => [
        'adapter'    => 'Mysql',
        'host'       => 'localhost',
        'username'   => 'root',
        'password'   => 'root',
        'port'       => '8889',
        'prefix'     => 't_',
        'dbname'     => 'test',
        'charset'    => 'utf8',
    ],
    'redis'=>[
        "host" => '127.0.0.1',
        "port" => 6379,
        "auth" => ""
    ]
];
