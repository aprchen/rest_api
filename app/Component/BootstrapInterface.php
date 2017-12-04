<?php

namespace App\Component;

use App\Component\Core\App;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午4:14
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
interface BootstrapInterface {

    public function run(App $app, FactoryDefault $di, Config $config);

}