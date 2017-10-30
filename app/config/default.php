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
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'baseUri'        => '/',
    ],
    'authentication' => [
        'secret' => 'L%JZZ#aJ%Ka#I3koe!jHxcXd@U',
        'expirationTime' => 86400 * 7, // One week till token expires
    ],
    'annotations'=>[
        'prefix'   => 'annotations',
        'lifetime' => '3600',
        'adapter'  => 'memory',      // Load the Memory adapter
    ]
];