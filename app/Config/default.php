<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午6:34
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
return [
    'application' => [
        'title' => 'vhome.api',
        'description' => 'Phalcon 练习接口',
        'modelsDir'      => APP_PATH . '/Models/',
        'migrationsDir'  => APP_PATH . '/Migrations/',
        'viewsDir'       => APP_PATH . '/Views/',
        'baseUri'        => '/',
    ],
    'authentication' => [
        'secret' => 'L%JZZ#aJ%Ka#I3koe!jHxcXd@U',
        'expirationTime' => 86400 * 7, // One week till token expires
    ],
    'annotations'=>[
        'prefix'   => 'annotations',
        'lifetime' => '3600',
        'adapter'  => 'files',    //{memory 测试开发用,apc 正式环境,files }
        "annotationsDir" => APP_PATH."/Cache/Annotations/", // files 模式启用
    ]
];