<?php

namespace App\Mapper;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;


/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午4:14
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
interface BootstrapInterface {

    public function run(Micro $app, FactoryDefault $di, Config $config);

}