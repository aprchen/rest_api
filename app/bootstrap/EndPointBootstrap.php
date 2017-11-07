<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:38
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\BootStrap;


use App\Controller\DefaultController;
use App\Controller\TestController;
use App\Controller\UsersController;
use App\Mapper\BootstrapInterface;
use App\Mvc\EndPointManager;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;


class EndPointBootstrap implements BootstrapInterface
{

    /**
     * @param Micro $app
     * @param FactoryDefault $di
     * @param Config $config
     * 路由注册
     */
    public function run(Micro $app, FactoryDefault $di, Config $config)
    {
        $manager = new EndPointManager($app);
        $manager->add(
            DefaultController::class,
            UsersController::class,
            TestController::class
        );
        $manager->run();
    }

}