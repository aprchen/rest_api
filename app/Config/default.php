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
        'description' => 'RESTful Api,依靠灵活的注解进行配置路由,可自由的添加获取参数进行相应的配置',
        'modelsDir' => APP_PATH . '/Models/',
        'migrationsDir' => APP_PATH . '/Migrations/',
        'viewsDir' => APP_PATH . '/Views/',
        'baseUri' => '/',
    ],
    'authentication' => [
        'secret' => 'L%JZZ#aJ%Ka#I3koe!jHxcXd@U',
        'expirationTime' => 86400 * 7, // One week till token expires
    ],
    "router" => [
        'adapter'=>'files', //{''不使用缓存,files,文件缓存}
        "frontendOptions" => [
            "lifetime" => 172800,
        ],
        "backendOptions" => [
            "cacheDir" => APP_PATH . "/Cache/router/",
        ],
        'annotations' => [
            'prefix' => 'annotations',
            'lifetime' => '3600',
            'adapter' => 'memory',    //{memory 测试开发用,apc 正式环境,files }
            "annotationsDir" => APP_PATH . "/Cache/Annotations/", // files 模式启用
        ]
    ]
];