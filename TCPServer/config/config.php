<?php

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:02
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
return new Phalcon\Config([
    'server'=>[
        'port'=>'9501',
        'host'=>'127.0.0.1',
        'worker_num'=>'2',
        'task_worker_num'=> '2'
    ],
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
]);