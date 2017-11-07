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
    'whiteList'=>[
        '127.0.0.1',
        '::1',
        '10.4.6.3',
        '10.4.6.4',
    ]
];
